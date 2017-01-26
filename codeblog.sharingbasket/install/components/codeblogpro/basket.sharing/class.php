<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use \Bitrix\Main\Loader;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\SystemException;
use \Bitrix\Main\Config\Option;
use \Bitrix\Sale\Fuser;
use \Bitrix\Main\Application;
use \Bitrix\Main\Web\Uri;
use CodeBlog\SharingBasket\Basket;
use CodeBlog\SharingBasket\Storage;
use CodeBlog\SharingBasket\Captcha;

\Bitrix\Main\Loader::includeModule('codeblog.sharingbasket');

CJSCore::Init('jquery');

class CCodeBlogBasketSharingComponent extends \CBitrixComponent
{

    protected $requiredModules = ['iblock',
                                  'sale'];

    protected function checkModules() {
        foreach ($this->requiredModules as $moduleName) {
            if (!Loader::includeModule($moduleName)) {
                throw new SystemException(Loc::getMessage('COMPONENT_BASKET_SHARING_NO_MODULE', ['#MODULE#',
                                                                                                 $moduleName]));
            }
        }

        return $this;
    }

    /**
     * Event called from includeComponent before component execution.
     * Takes component parameters as argument and should return it formatted as needed.
     *
     * @param  array [string]mixed $arParams
     *
     * @return array[string]mixed
     */
    public function onPrepareComponentParams($params) {

        return $params;
    }

    /**
     * Event called from includeComponent before component execution.
     * Includes component.php from within lang directory of the component.
     *
     * @return void
     */
    public function onIncludeComponentLang() {
        $this->includeComponentLang(basename(__FILE__));
        Loc::loadMessages(__FILE__);
    }

    protected function prepareResult() {

        $request = Application::getInstance()->getContext()->getRequest();

        $urlClear = new Uri($request->getRequestUri());

        $urlClear->deleteParams(['save_basket']);
        $urlClear->deleteParams(['enter_code']);

        $this->arResult['URL']['CLEAR'] = $urlClear->getUri();

        $this->arResult['STATUS']['IS_SAVE_BASKET']         = ($request->get('save_basket') == 'y');
        $this->arResult['STATUS']['IS_BASKET_SHARING_AJAX'] = ($request->get('basket_sharing_ajax') == 'y');
        $this->arResult['STATUS']['IS_APPLIED_CODE']        = ((int)$request->get('saved_basket_id') > 0);

        return $this;
    }

    /**
     * @return bool
     */
    protected function isUseCaptcha() {

        global $USER;

        $isShowCaptcha = false;

        if ($this->arParams['CAPTCHA_SHOW'] == 'Y') {
            $isShowCaptcha = true;
        }

        if (($this->arParams['CAPTCHA_SHOW'] == 'S') && (!$USER->IsAuthorized())) {
            $isShowCaptcha = true;
        }

        $this->arResult['CAPTCHA']['SHOW'] = $isShowCaptcha;

        return $isShowCaptcha;
    }

    /**
     * @return void
     */
    protected function initializationCaptcha() {

        $this->arResult['CAPTCHA']['CODE']                          = Captcha\Helper::getCaptcha();
        $this->arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME']  = Captcha\Helper::CAPTCHA_SID_NAME;
        $this->arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME'] = Captcha\Helper::CAPTCHA_WORD_NAME;
        $this->arResult['CAPTCHA']['FORM']['NAME']                  = Captcha\Helper::CAPTCHA_FORM_NAME;
    }

    /**
     * @return bool
     */
    public function isValidCaptcha() {

        $request = Application::getInstance()->getContext()->getRequest();

        $captchaWord = $request->getPost($this->arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME']);
        $captchaCode = $request->getPost($this->arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME']);

        $isValidCaptcha = Captcha\Helper::checkCaptcha($captchaWord, $captchaCode);

        return $isValidCaptcha;
    }

    /**
     * @return bool
     */
    public function isCaptchaVerify() {

        if ($this->isUseCaptcha()) {

            $isCaptchaVerify = (Captcha\Helper::isApplliedCaptcha() && $this->isValidCaptcha());

        } else {
            $isCaptchaVerify = true;
        }

        return $isCaptchaVerify;
    }


    public function executeComponent() {

        global $APPLICATION;

        try {
            $this->checkModules()->prepareResult();

            if ($this->isUseCaptcha()) {
                $this->initializationCaptcha();
            }

            $basket      = new Basket\Basket();
            $basketValue = $basket->getItemsListFormat();

            /**
             * TODO: реализовать проверку существоания корзины прозрачным функционалом, а не хардкодом
             */
            $this->arResult['STATUS']['BASKET']['IS_EMPTY'] = $basketValue == '[]';

            if ($this->arResult['STATUS']['IS_SAVE_BASKET']) {

                $storage = Storage\StorageHelper::getStorage();

                $APPLICATION->restartBuffer();

                if (!$this->isCaptchaVerify()) {
                    echo('Попробуйте ввести капчу снова');
                } else {
                    $this->arResult['BASKET']['ID'] = $storage->saveBasketToStorage($basketValue, $userId = Fuser::getId());
                    echo $this->arResult['BASKET']['ID'];
                }
                exit();
            }


            if ($this->arResult['STATUS']['IS_APPLIED_CODE']) {

                $APPLICATION->restartBuffer();

                $savedBasketId = (int)Application::getInstance()->getContext()->getRequest()->get('saved_basket_id');

                $basket = new Basket\Basket();

                $storage = Storage\StorageHelper::getStorage();

                if ($storage->isStorageExist($savedBasketId)) {

                    $basketItemsListFormat = $storage->restoreBasketItemsListFromStorage($savedBasketId);

                    if (!empty($basketItemsListFormat)) {
                        $basket->setBasketByItemsListFormat($basketItemsListFormat);
                        echo "<script>location.href = '" . $this->arResult['URL']['CLEAR'] . "';</script>";
                    } else {
                        echo 'Корзина с указанным кодом не найдена';
                    }

                    exit();
                }

                echo('Некорректный код');
                exit();
            }


            $this->includeComponentTemplate();
        } catch (SystemException $e) {

            self::__showError($e->getMessage());
        }
    }
}
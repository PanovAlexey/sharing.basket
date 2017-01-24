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

\Bitrix\Main\Loader::includeModule('codeblog.sharingbasket');

CJSCore::Init('jquery');

class CCodeBlogBasketSharingComponent extends \CBitrixComponent
{

    protected $requiredModules = ['iblock',
                                  'sale'];

    protected function isAjax() {
        return isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'y';
    }

    protected function checkModules() {
        foreach ($this->requiredModules as $moduleName) {
            if (!Loader::includeModule($moduleName)) {
                throw new SystemException(Loc::getMessage('COMPONENT_BASKET_SHARING_NO_MODULE', ['#MODULE#',
                                                                                                 $moduleName]));
            }
        }

        return $this;
    }

    protected function getProductsListFromBasket() {

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

        return $this;
    }


    public function executeComponent() {

        global $APPLICATION;

        try {
            $this->checkModules()->prepareResult();

            $basket      = new Basket\Basket();
            $basketValue = $basket->getItemsListFormat();

            $this->arResult['STATUS']['IS_SAVE_BASKET']         = (Application::getInstance()->getContext()->getRequest()->get('save_basket')
                                                                   == 'y');
            $this->arResult['STATUS']['IS_BASKET_SHARING_AJAX'] = (Application::getInstance()->getContext()->getRequest()->get('basket_sharing_ajax')
                                                                   == 'y');
            $this->arResult['STATUS']['IS_APPLIED_CODE']        = ((int)Application::getInstance()->getContext()->getRequest()->get('saved_basket_id')
                                                                   > 0);

            /**
             * TODO: реализовать проверку существоания корзины прозрачным функционалом, а не хардкодом
             */
            $this->arResult['STATUS']['BASKET']['IS_EMPTY']     = $basketValue == '[]';

            if ($this->arResult['STATUS']['IS_SAVE_BASKET']) {

                $storage = Storage\StorageHelper::getStorage();

                $this->arResult['BASKET']['ID'] = $storage->saveBasketToStorage($basketValue, $userId = Fuser::getId());

                $APPLICATION->restartBuffer();

                echo $this->arResult['BASKET']['ID'];
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
                        echo "error";
                    }

                    exit();
                }

                echo('Некорректный код');
                exit();
            }


            if ($this->isAjax()) {
                $APPLICATION->restartBuffer();

                die();
            }

            $this->includeComponentTemplate();
        } catch (SystemException $e) {

            if ($this->isAjax()) {

                $APPLICATION->restartBuffer();
                echo json_encode(['status' => 'error',
                                  'data'   => $e->getMessage()], JSON_FORCE_OBJECT);
                die();
            }

            self::__showError($e->getMessage());
        }
    }
}
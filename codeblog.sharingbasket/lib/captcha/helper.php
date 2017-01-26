<?
/**
 * Created by PhpStorm.
 * User: Alexey
 * Date: 26.01.2017
 * Time: 12:05
 *
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright © 2016, Alexey Panov
 */

namespace CodeBlog\SharingBasket\Captcha;

use \Bitrix\Main\Application;

class Helper
{

    const CAPTCHA_SID_NAME  = 'codeblog_basket_sharing_captcha_sid';
    const CAPTCHA_WORD_NAME = 'codeblog_basket_sharing_captcha_word';
    const CAPTCHA_FORM_NAME = 'codeblog_basket_sharing_captcha_form';

    /**
     * @param string $captchaWord
     * @param string $captchaCode
     *
     * @return bool
     */
    public static function checkCaptcha($captchaWord, $captchaCode) {

        global $APPLICATION;

        if ($APPLICATION->CaptchaCheckCode($captchaWord, $captchaCode)) {
            $captchaValid = true;
        } else {
            $captchaValid = false;
        }

        return $captchaValid;
    }

    /**
     * @return string
     */
    public static function getCaptcha() {

        global $APPLICATION;

        $code = $APPLICATION->CaptchaGetCode();

        return $code;
    }

    /**
     * @return bool
     */
    public static function isApplliedCaptcha() {

        $request = Application::getInstance()->getContext()->getRequest();

        $captchaWord = $request->getPost(self::CAPTCHA_WORD_NAME);
        $captchaCode = $request->getPost(self::CAPTCHA_SID_NAME);

        $isAppliedCaptcha = false;

        if (isset($captchaCode) && isset($captchaWord)) {
            $isAppliedCaptcha = true;
        }

        return $isAppliedCaptcha;
    }


}


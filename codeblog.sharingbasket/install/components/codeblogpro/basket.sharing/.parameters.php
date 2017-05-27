<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$captchaUseVariantsList = [
    'N' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_CAPTCHA_N'),
    'S' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_CAPTCHA_S'),
    'Y' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_CAPTCHA_Y')
];

$sendingCodeUseVariantsList = [
    'N' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_SENDING_CODE_N'),
    'S' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_SENDING_CODE_S'),
    'Y' => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_SENDING_CODE_Y')
];

$arComponentParameters = [
    'PARAMETERS' => [
        'CACHE_TIME'   => [
            'DEFAULT' => 36000000
        ],
        'CAPTCHA_SHOW' => [
            'PARENT'   => 'DATA_SOURCE',
            'NAME'     => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_CAPTCHA'),
            'TYPE'     => 'LIST',
            'MULTIPLE' => 'N',
            'DEFAULT'  => 'N',
            'VALUES'   => $captchaUseVariantsList
        ],
        'SEND_CODE_SHOW' => [
            'PARENT'   => 'ADDITIONAL_SETTINGS',
            'NAME'     => Loc::getMessage('CODEBLOGPRO_BASKET_SHARING_IS_USE_SENDING_CODE'),
            'TYPE'     => 'LIST',
            'MULTIPLE' => 'N',
            'DEFAULT'  => 'N',
            'VALUES'   => $captchaUseVariantsList
        ],
    ]
];
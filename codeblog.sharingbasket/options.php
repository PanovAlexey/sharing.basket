<?
/**
 * Created by PhpStorm.
 * Date: 10.01.2017
 * Time: 11:00
 *
 * @package   CodeBlog
 * @category  Bitrix, basket module
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright ? 2016, Alexey Panov
 */
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use CodeBlog\SharingBasket\Vendor;
use Bitrix\Main\Loader;

Loader::includeModule('codeblog.sharingbasket');

$moduleId = 'codeblog.sharingbasket';
$mid       = $_REQUEST['mid'];
IncludeModuleLangFile(__FILE__);

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $moduleId . '/include.php');
IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $moduleId . '/options.php');

$tabsList = [
    [
        'DIV' => 'edit1',
        'TAB' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_MAIN_OPTIONS_TITLE_VALUE'),
        'ICON' => '',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_MAIN_OPTIONS_TITLE_VALUE')
            . Loc::getMessage('CODEBLOG_BASKET_SHARING_IN_FULL_VERSION_VALUE'),
    ]
];

$groupsList = [
    'MAIN' => [
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_MAIN_OPTIONS_VALUE'),
        'TAB' => 0
    ],
];

$optionsList = array(
    'TYPE_STORAGE' => [
        'GROUP' => 'MAIN',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_TYPE_STORAGE_VALUE'),
        'TYPE' => 'STRING',
        'VALUE' => '',
        'SORT' => '0',
        'NOTES' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_TYPE_STORAGE_NOTES_VALUE'),
        'OTHER_PARAMETERS' => 'disabled value="' . Option::get('codeblog.sharingbasket', 'typeStorage') . '"',
    ],
    'IS_USE_SENDING_EMAIL' => [
        'GROUP' => 'MAIN',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_IS_SENDING_TO_EMAIL_VALUE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y',
        'SORT' => '10',
        'OTHER_PARAMETERS' => 'disabled="disabled"',
        'NOTES' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_ALLOW_IS_SENDING_TO_EMAIL_VALUE'),
    ],
    'IS_USE_SENDING_PHONE' => [
        'GROUP' => 'MAIN',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_IS_SENDING_TO_PHONE_VALUE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'N',
        'SORT' => '20',
        'OTHER_PARAMETERS' => 'disabled="disabled"',
        'NOTES' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_ALLOW_IS_SENDING_TO_PHONE_VALUE'),
    ],
    'LOG_IS_USE' => [
        'GROUP' => 'MAIN',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_IS_USE_LOGGING_VALUE'),
        'TYPE' => 'CHECKBOX',
        'REFRESH' => (Option::get('codeblog.sharingbasket', 'LOG_IS_USE')) ? Option::get('codeblog.sharingbasket', 'LOG_IS_USE') : 'Y',
        'SORT' => '100',
        'OTHER_PARAMETERS' => 'disabled="disabled"',
        'NOTES' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_IS_USE_LOGGING_NOTES_VALUE'),
    ],
    'LOG_FILE_NAME' => [
        'GROUP' => 'MAIN',
        'TITLE' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_LOG_FILE_NAME_VALUE'),
        'TYPE' => 'STRING',
        'DEFAULT' => empty(Option::get('codeblog.sharingbasket', 'LOG_FILE_NAME')) ? 'log.txt' : Option::get('codeblog.sharingbasket', 'LOG_FILE_NAME'),
        'SORT' => '110',
        'NOTES' => Loc::getMessage('CODEBLOG_SHARING_BASKET_OPTIONS_LOG_FILE_NAME_NOTES_VALUE'),
        'OTHER_PARAMETERS' => 'disabled="disabled"',
    ],
);


$options = new Vendor\CModuleOptions(
    $moduleId,
    $tabsList,
    $groupsList,
    $optionsList
);
$options->ShowHTML();
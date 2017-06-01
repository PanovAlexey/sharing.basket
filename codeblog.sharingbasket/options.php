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
        'TAB' => 'Настройки',
        'ICON' => '',
        'TITLE' => 'Настройки'
    ]
];

$groupsList = [
    'MAIN' => ['TITLE' => 'Основные настройки', 'TAB' => 0],
];

$optionsList = array(
    'TYPE_STORAGE' => [
        'GROUP' => 'MAIN',
        'TITLE' => 'Тип хранилища',
        'TYPE' => 'STRING',
        'DEFAULT' => Option::get('codeblog.sharingbasket', 'typeStorage'),
        'SORT' => '0',
        'NOTES' => 'Место хранения сохраненных корзин. Задается при установке модуля.',
        'OTHER_PARAMETERS' => 'disabled',
    ],
    'IS_USE_SENDING_EMAIL' => [
        'GROUP' => 'MAIN',
        'TITLE' => 'Отправка номера корзины на Email',
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'Y',
        'SORT' => '10',
        'NOTES' => 'Позволить отправлять номер сохраненной корзины на Email.',
    ],
    'IS_USE_SENDING_PHONE' => [
        'GROUP' => 'MAIN',
        'TITLE' => 'Отправка номера корзины на телефон',
        'TYPE' => 'CHECKBOX',
        'REFRESH' => 'N',
        'SORT' => '20',
        'OTHER_PARAMETERS' => 'disabled="disabled"',
        'NOTES' => 'Позволить отправлять номер сохраненной корзины на мобильный телефон.',
    ],
    'LOG_IS_USE' => [
        'GROUP' => 'MAIN',
        'TITLE' => 'Использовать логирование',
        'TYPE' => 'CHECKBOX',
        'REFRESH' => (Option::get('codeblog.sharingbasket', 'LOG_IS_USE')) ? Option::get('codeblog.sharingbasket', 'LOG_IS_USE') : 'Y',
        'SORT' => '100',
        'NOTES' => 'Сохранять информацю о совершенных модулем дейсвтиях для последуюшего анализа или выявления ошибок.',
    ],
    'LOG_FILE_NAME' => [
        'GROUP' => 'MAIN',
        'TITLE' => 'Имя лог файла',
        'TYPE' => 'STRING',
        'DEFAULT' => empty(Option::get('codeblog.sharingbasket', 'LOG_FILE_NAME')) ? 'log.txt' : Option::get('codeblog.sharingbasket', 'LOG_FILE_NAME'),
        'SORT' => '110',
        'NOTES' => 'Имя лог файла.',
    ],
);

$options = new Vendor\CModuleOptions($moduleId, $tabsList, $groupsList, $optionsList);
$options->ShowHTML();
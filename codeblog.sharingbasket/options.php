<?
/**
 * Created by PhpStorm.
 * Date: 10.01.2017
 * Time: 11:00
 *
 * @package   CodeBlog
 * @category  Bitrix, basket module
 * @author    Alexey Panov <panov@codeblog.pro>
 * @copyright Copyright � 2016, Alexey Panov
 */
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;

$module_id = 'codeblog.sharingbasket';
$mid       = $_REQUEST['mid'];
IncludeModuleLangFile(__FILE__);

require_once($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $module_id . '/include.php');
IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $module_id . '/options.php');

/**
 * @ToDo перенести настройки и параметры модуля в опции из доп раздела меню
 *       https://dev.1c-bitrix.ru/community/webdev/user/104863/blog/5296/
 */
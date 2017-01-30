<?

define(ADMIN_MODULE_NAME, 'codeblog.sharingbasket');
define(ADMIN_MODULE_ICON, '');

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php');

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/subscribe/include.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/subscribe/prolog.php');

IncludeModuleLangFile(__FILE__);

$POST_RIGHT = $APPLICATION->GetGroupRight('codeblog.sharingbasket');
// если нет прав - отправим к форме авторизации с сообщением об ошибке
if ($POST_RIGHT == 'D') {
    $APPLICATION->AuthForm(GetMessage('ACCESS_DENIED'));
}

// здесь будет вся серверная обработка и подготовка данных
?>
<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php'); // второй общий пролог
?>
<?
// здесь будет вывод страницы
?>
    <h3>Тип хранилища сохраненных корзин:</h3>
    <p><?= \Bitrix\Main\Config\Option::get('codeblog.sharingbasket', 'typeStorage'); ?></p>
<? require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/epilog_admin.php');

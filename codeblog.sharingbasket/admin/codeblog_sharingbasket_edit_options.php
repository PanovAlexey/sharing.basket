<?

define(ADMIN_MODULE_NAME, 'codeblog.sharingbasket');
define(ADMIN_MODULE_ICON, '');

// подключим все необходимые файлы:
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php'); // первый общий пролог

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/subscribe/include.php'); // инициализация модуля
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/subscribe/prolog.php'); // пролог модуля

// подключим языковой файл
IncludeModuleLangFile(__FILE__);

// получим права доступа текущего пользователя на модуль
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

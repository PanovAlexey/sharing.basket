<? if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Localization\Loc; ?>

<?

$currentPHPVersion       = explode('.', PHP_VERSION);
$currentPHPVersionNumber = (float)($currentPHPVersion[0] . '.' . $currentPHPVersion[1]);

if ($currentPHPVersionNumber < 5.4) {
    ShowMessage('Ваша версия PHP ' . $currentPHPVersionNumber);
    ShowMessage('Внимание! Для продолжения установки модуля обновите версию PHP до 5.4 или более поздней версии.');

    return;
}
?>

<form action="<?= $APPLICATION->GetCurPage() ?>" name="sharingbasket" id="sharingbasket" method="POST">

    <?= bitrix_sessid_post() ?>

    <h3>Выберите тип хранилища для корзин пользователей</h3>
    <br>
    <input type="radio" name="typestorage" value="iblock">Инфоблок<br>
    <input type="radio" name="typestorage" value="highloadblock" checked>Bitrix ХайлоадБлок<br>
    <input type="radio" name="typestorage" value="mysql">Отдельная таблица в MySQL<br>
    <input type="radio" name="typestorage" value="reddis" disabled>Reddis<br>
    <input type="radio" name="typestorage" value="mongodb" disabled>MongoDB<br>
    <input type="radio" name="typestorage" value="riak" disabled>Riak<br>
    <input type="radio" name="typestorage" value="couchdb" disabled>CouchDB<br>

    <input type="hidden" name="id" value="codeblog.sharingbasket">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="hidden" name="step" value="2">
    <br>
    <input type="submit" name="submit" value="Подтвердить">
</form>

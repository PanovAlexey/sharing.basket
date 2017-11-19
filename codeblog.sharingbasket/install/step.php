<? if (!check_bitrix_sessid()) {
    return;
}

use Bitrix\Main\Localization\Loc;

$currentPHPVersion       = explode('.', PHP_VERSION);
$currentPHPVersionNumber = (float)($currentPHPVersion[0] . '.' . $currentPHPVersion[1]);

if ($currentPHPVersionNumber < 5.4) {

    ShowMessage(Loc::getMessage('CODEBLOG_BASKET_SHARING_YOUR_VERSION_PHP') . ' ' . $currentPHPVersionNumber);
    ShowMessage(Loc::getMessage('CODEBLOG_BASKET_SHARING_YOUR_IS_OLD_VERSION_PHP'));

    return;
}
?>
<form action="<?= $APPLICATION->GetCurPage() ?>" name="sharingbasket" id="sharingbasket" method="POST">
    <?= bitrix_sessid_post() ?>
    <h3><?= Loc::getMessage('CODEBLOG_BASKET_SHARING_CHOOSE_STORAGE_BASKET') ?></h3>
    <br>
    <input type="radio" name="typestorage"
           value="iblock"><?= Loc::getMessage('CODEBLOG_BASKET_SHARING_STORAGE_IBLOCK_VALUE') ?><br>
    <input type="radio" name="typestorage" value="highloadblock"
           checked><?= Loc::getMessage('CODEBLOG_BASKET_SHARING_STORAGE_HIGHLOAD_IBLOCK_VALUE') ?><br>
    <input type="radio" name="typestorage" value="mysql"
           disabled><?= Loc::getMessage('CODEBLOG_BASKET_SHARING_STORAGE_MYSQL_TABLE_VALUE') ?> <?= Loc::getMessage('CODEBLOG_BASKET_SHARING_IN_FULL_VERSION_VALUE') ?><br>
    <input type="radio" name="typestorage" value="mongodb" disabled>MongoDB <?= Loc::getMessage('CODEBLOG_BASKET_SHARING_IN_FULL_VERSION_VALUE') ?><br>
    <input type="hidden" name="id" value="codeblog.sharingbasket">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="hidden" name="step" value="2">
    <br>
    <input type="submit" name="submit" value="<?= Loc::getMessage('CODEBLOG_BASKET_SHARING_FORM_SUBMIT_VALUE') ?>">
</form>
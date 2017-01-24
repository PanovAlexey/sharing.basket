<? if (!check_bitrix_sessid()) {
	return;
}

use Bitrix\Main\Localization\Loc; ?>

<?= CAdminMessage::ShowNote(Loc::getMessage('MOD_INST_OK')); ?>

<form action="<?= $APPLICATION->GetCurPage() ?>" method="POST">
	<?= bitrix_sessid_post() ?>

	<input type="hidden" name="id" value="sharingbasket">
	<input type="hidden" name="install" value="Y">
	<input type="hidden" name="lang" value="<?= LANG ?>">
	<input type="hidden" name="step" value="3">
	<input type="submit" name="" value="<?= Loc::getMessage('MOD_BACK') ?>">
</form>

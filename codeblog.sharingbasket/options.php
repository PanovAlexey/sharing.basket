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

if (!$USER->CanDoOperation('view_other_settings') && !$USER->CanDoOperation('edit_other_settings')) {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
}

$CAT_RIGHT = $APPLICATION->GetGroupRight($module_id);

if (check_bitrix_sessid() && $CAT_RIGHT == 'W') {
    
}

if ($CAT_RIGHT >= 'R') {

    include_once($GLOBALS['DOCUMENT_ROOT'] . '/bitrix/modules/' . $module_id . '/include.php');

    $arTabs = array(array('DIV'   => 'edit1',
                          'TAB'   => Loc::getMessage('MAIN_TAB_SET'),
                          'ICON'  => 'codeblog_sharing_basket_settings',
                          'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_SET'),),
                    array('DIV'   => 'edit2',
                          'TAB'   => Loc::getMessage('MAIN_TAB_RIGHTS'),
                          'ICON'  => 'codeblog_sharing_basket_rights',
                          'TITLE' => Loc::getMessage('MAIN_TAB_TITLE_RIGHTS'),),);

    $tabControl = new \CAdminTabControl('tabControl', $arTabs);

    $tabControl->Begin();
    ?>
    <form method="POST"
          action="<?= $APPLICATION->GetCurPage() ?>?mid=<?= htmlspecialchars($mid) ?>&lang=<?= LANG ?>">
        <?= bitrix_sessid_post(); ?>
        <? $tabControl->BeginNextTab(); // SETTINGS?>
        <tr class="heading">
            <td colspan="2"><b><?= Loc::getMessage("CODEBLOG_SHARING_BASKET_OPT") ?></b></td>
        </tr>
        <tr>
            <td width="50%" class="adm-detail-content-cell-l">
                <label for="null"><?= Loc::getMessage('CODEBLOG_SHARING_BASKET_NULL') ?>:</label>
            </td>
            <td width="50%" class="adm-detail-content-cell-r">
                <input type="text"
                       size="30"
                       maxlength="255"
                       name="null"
                       value="<?= Option::get($module_id, 'null', '') ?>">
            </td>
        </tr>
        <? $tabControl->BeginNextTab(); // RIGHTS?>
        <? require_once($_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/admin/group_rights.php'); ?>
        <? $tabControl->Buttons(); ?>
        <input type="submit" <? if ($CAT_RIGHT < 'W')
            echo "disabled" ?> name="Update" value="<?= Loc::getMessage('MAIN_SAVE') ?>">
        <input type="hidden" name="Update" value="Y">
        <input type="reset" name="reset" value="<?= Loc::getMessage('MAIN_RESET') ?>">
    </form>
    <? $tabControl->End();

}
<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div id="codeblog_basket_notification">

</div>

<div id="codeblog_basket_answer">
    <p><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_SAVED_BASKET_VALUE') ?></p>
    <a href="#" id="enter_code_show"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_VALUE') ?></a>
    <br><br>
    <? if (!$arResult['STATUS']['BASKET']['IS_EMPTY']) { ?>
        <p><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_WANT_SAVE_VALUE') ?></p>

        <? if ($arResult['CAPTCHA']['SHOW']) { ?>
            <form name="<?= $arResult['CAPTCHA']['FORM']['NAME'] ?>" method="post">
                <input type="hidden" name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME'] ?>"
                       value="<?= $arResult['CAPTCHA']['CODE'] ?>">
                <br>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA']['CODE'] ?>" alt="CAPTCHA">
                <br>
                <input type="text" name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME'] ?>" value="">
            </form>
        <? } ?>

        <a href="#"
           id="codeblog_basket_save_basket"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_SAVE_VALUE') ?></a>

    <? } ?>
</div>

<div id="codeblog_basket_saving_completed" class="g-popup">
    <p class="save-basket-text"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SAVED_SUCCESSFUL_VALUE') ?>:</p>
    <p id="save-basket-number">0</p>
    <div class="send-choice"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_CODE_VALUE') ?>:</div>
    <form class="js-save-basket-form" method="post">
        <?= bitrix_sessid_post() ?>
        <div class="form-control">
            <label for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?> e-mail</label>
            <input class="js-email" name="email"
                   id="email"
                   placeholder="mymail@mail.com"
                   type="text">
        </div>
        <div class="form-control">
            <label
                for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?>
                <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PHONE_VALUE') ?></label>
            <input class="js-phone" name="phone"
                   id="phone"
                   placeholder="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_NEED_AUTH_VALUE') ?>"
                   type="text">
        </div>
        <div class="form-control">
            <input class="js-print-saved-cart"
                   value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PRINT_VALUE') ?>" type="button">
            <input class="js-submit-button"
                   value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_VALUE') ?>" type="submit">
        </div>
    </form>
</div>

<div id="codeblog_basket_showing_enter_code" class="g-popup">
    <p><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_PLEASE_VALUE') ?></p>
    <form class="js-saved-basket-number-form" method="post">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" id="component_path" value="<?= $componentPath ?>">
        <div class="form-control">
            <label for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_CODE_VALUE') ?></label>
            <input id="saved-basket-id" name="saved-basket-id" placeholder="xxxxxx" type="text">
        </div>
        <div class="form-control">
            <input id="enter_code_apply" class="js-submit-button" value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_VALUE') ?>" type="submit">
        </div>
    </form>
</div>

<script>
    var captchaIsShow = "<?=($arResult['CAPTCHA']['SHOW']) ? 'true' : 'false';?>";
    if (captchaIsShow) {
        var captchaSidName = "<?=$arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME']?>";
        var captchaWordName = "<?=$arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME']?>";
    }
</script>
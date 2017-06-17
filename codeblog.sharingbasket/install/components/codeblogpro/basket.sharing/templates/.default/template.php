<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;
?>
<div class="codeblog-basket-notification js-basket-notification-saving">
    <a class="codeblog-basket-close-icon js-codeblog-notification-close" href="#"></a>
    <? if ($arResult['CAPTCHA']['SHOW']) { ?>
        <div style="clear: both"></div>
        <div class="codeblog-basket-captcha-container">
            <div class="bx-block-title">Введите слово</div>
            <div class="bx-subscribe">
                <form class="codeblog-basket-captcha-form" name="<?= $arResult['CAPTCHA']['FORM']['NAME'] ?>"
                      method="post">
                    <input name="sessid" id="sessid" value="0556ab097900b3d8b29ddb58dcc2ab01" type="hidden">
                    <input type="hidden" name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME'] ?>"
                           value="<?= $arResult['CAPTCHA']['CODE'] ?>">
                    <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA']['CODE'] ?>" alt="CAPTCHA">
                    <div class="bx-input-group">
                        <input class="bx-form-control"
                               name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME'] ?>" value=""
                               title="Введите код с картинки" placeholder="Введите код с картинки" type="text">
                    </div>
                    <button class="sender-btn btn-captcha js-class-codeblog-basket-save">Подтвердить</button>
                </form>
            </div>
        </div>
        <div style="clear: both"></div>
    <? } ?>
    <div class="codeblog-basket-hidden js-codeblog-basket-saving-completed">
        <p class="title-basket-text"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SAVED_SUCCESSFUL_VALUE') ?>:</p>
        <p class="save-basket-number js-save-basket-number"></p>
        <div class="send-choice"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_CODE_VALUE') ?>:</div>
        <br>
        <p class="js-codeblog-basket-notification-error"></p>
        <form class="js-save-basket-form basket-form-control-form" method="post">
            <?= bitrix_sessid_post() ?>
            <div class="basket-form-control">
                <label class="codeblog-basket-input-button-label" for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?> e-mail</label>
                <input class="js-basket-send-email codeblog-basket-input" name="email"
                       placeholder="mymail@mail.com"
                       type="text">
            </div>
            <?/*
            <div class="basket-form-control">
                <label
                    for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?>
                    <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PHONE_VALUE') ?></label>
                <input class="js-basket-send-phone" name="phone"
                       id="phone"
                       placeholder="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_NEED_AUTH_VALUE') ?>"
                       type="text">
            </div>*/?>
            <div class="basket-form-control">
                <input class="js-print-saved-cart codeblog-basket-input-button"
                       value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PRINT_VALUE') ?>" type="button">
                <input class="js-submit-send-button codeblog-basket-input-button"
                       value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_VALUE') ?>" type="button">
            </div>
        </form>
    </div>
</div>

<div class="codeblog-basket-answer js-codeblog-basket-answer">
    <h4 class="basket-sharing-title"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_SAVED_BASKET_VALUE') ?></h4>
    <div>
        <a href="#" class="basket-sharing-answer-link basket-sharing-left js-enter-code-show"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_VALUE') ?></a>
        <? if (!$arResult['STATUS']['BASKET']['IS_EMPTY']) { ?>
            <a href="#"
               class="basket-sharing-answer-link basket-sharing-right <? if (empty($arResult['CAPTCHA']['SHOW'])) {?> js-class-codeblog-basket-save<?} else { ?> js-class-codeblog-basket-saving-show<? }?>">
                <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_WANT_SAVE_VALUE') ?>
                <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_SAVE_VALUE') ?></a>
        <? } ?>
        <div style="clear: both"></div>
    </div>
</div>

<div class="codeblog-basket-notification codeblog-basket-hidden js-codeblog-basket-showing-enter-code">
    <a class="codeblog-basket-close-icon js-codeblog-notification-close" href="#"></a>
    <p class="title-basket-text"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_PLEASE_VALUE') ?></p>
    <p><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PRODUCTS_REPLACE_VALUE') ?></p>
    <p class="js-codeblog-basket-notification-error"></p>
    <form class="js-saved-basket-number-form" method="post">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" id="component_path" value="<?= $componentPath ?>">
        <div class="basket-form-control">
            <input class="codeblog-basket-input js-saved-basket-id" name="saved-basket-id" placeholder="xxxxxx" type="text">
        </div>
        <div class="basket-form-control">
            <input class="js-submit-code-button codeblog-basket-input-button"
                   value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_VALUE') ?>" type="submit">
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
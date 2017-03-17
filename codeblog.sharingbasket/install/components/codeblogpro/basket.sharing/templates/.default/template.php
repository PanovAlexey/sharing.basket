<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div id="codeblog_basket_notification">
    <a class="codeblog-basket-close-icon" href="#"></a>
    <? if ($arResult['CAPTCHA']['SHOW']) { ?>
        <div style="clear: both"></div>
        <div class="codeblog-basket-captcha-container">
            <div class="bx-block-title">Введите слово</div>
            <div class="bx-subscribe">
                <form id="codeblog-basket-captcha-form" name="<?= $arResult['CAPTCHA']['FORM']['NAME'] ?>"
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
    <div id="codeblog_basket_saving_completed">
        <p class="save-basket-text"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SAVED_SUCCESSFUL_VALUE') ?>:</p>
        <p id="save-basket-number">0</p>
        <div class="send-choice"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_CODE_VALUE') ?>:</div>
        <br>
        <form class="js-save-basket-form" method="post">
            <?= bitrix_sessid_post() ?>
            <div class="basket-form-control">
                <label for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?> e-mail</label>
                <input class="js-basket-send-email" name="email"
                       id="email"
                       placeholder="mymail@mail.com"
                       type="text">
            </div>
            <div class="basket-form-control">
                <label
                    for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_VALUE') ?>
                    <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PHONE_VALUE') ?></label>
                <input class="js-basket-send-phone" name="phone"
                       id="phone"
                       placeholder="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_NEED_AUTH_VALUE') ?>"
                       type="text">
            </div>
            <div class="basket-form-control">
                <input class="js-print-saved-cart"
                       value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_PRINT_VALUE') ?>" type="button">
                <input class="js-submit-button"
                       value="<?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_VALUE') ?>" type="submit">
            </div>
        </form>
    </div>
</div>

<div id="codeblog-basket-answer">
    <h4 id="basket-sharing-title"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_SAVED_BASKET_VALUE') ?></h4>

    <div>
        <a href="#" class="basket-sharing-answer-link"
           id="enter_code_show"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_VALUE') ?></a>

        <? if (!$arResult['STATUS']['BASKET']['IS_EMPTY']) { ?>
            <a href="#"
               class="basket-sharing-answer-link<? if (empty($arResult['CAPTCHA']['SHOW'])) {?> js-class-codeblog-basket-save<?}?>"
               id="codeblog_basket_save_basket"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_IS_WANT_SAVE_VALUE') ?>
                <?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_TO_SAVE_VALUE') ?></a>
        <? } ?>
        <div style="clear: both"></div>
    </div>

</div>


<div id="codeblog_basket_showing_enter_code">
    <p><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_ENTER_CODE_PLEASE_VALUE') ?></p>
    <form class="js-saved-basket-number-form" method="post">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" id="component_path" value="<?= $componentPath ?>">
        <div class="form-control">
            <label for="name"><?= Loc::getMessage('CODEBLOGPRO_COMPONENT_BASKET_SEND_NOTICE_CODE_VALUE') ?></label>
            <input id="saved-basket-id" name="saved-basket-id" placeholder="xxxxxx" type="text">
        </div>
        <div class="form-control">
            <input id="enter_code_apply" class="js-submit-button"
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
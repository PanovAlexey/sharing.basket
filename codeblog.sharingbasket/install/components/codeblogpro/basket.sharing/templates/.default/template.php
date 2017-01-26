<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

/**
 * @TODO: Вынести фразы в языковые файлы
 */
?>

<div id="codeblog_basket_notification">

</div>

<div id="codeblog_basket_answer">
    <p>У вас есть сохраненная корзина? Хотите ввести номер?</p>
    <a href="#" id="enter_code_show">Да, ввести номер</a><br><br>
    <? if (!$arResult['STATUS']['BASKET']['IS_EMPTY']) { ?>
        <p>Нет, хочу сохранить эту</p>

        <? if ($arResult['CAPTCHA']['SHOW']) { ?>
            <form name="<?= $arResult['CAPTCHA']['FORM']['NAME'] ?>" method="post">
                <input type="hidden" name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['SID']['NAME'] ?>"
                       value="<?= $arResult['CAPTCHA']['CODE'] ?>">
                <br>
                <img src="/bitrix/tools/captcha.php?captcha_sid=<?= $arResult['CAPTCHA']['CODE'] ?>"
                     alt="CAPTCHA">
                <br>
                <input type="text" name="<?= $arResult['CAPTCHA']['FORM']['INPUT']['WORD']['NAME'] ?>"
                       value="">
            </form>
        <? } ?>

        <a href="#" id="codeblog_basket_save_basket">Сохранить корзину</a>


    <? } ?>
</div>

<div id="codeblog_basket_saving_completed" class="g-popup">
    <p class="save-basket-text">Корзина успешно сохранена под номером:</p>
    <p id="save-basket-number">0</p>
    <div class="send-choice">Отправить код:</div>
    <form class="js-save-basket-form" method="post">
        <?= bitrix_sessid_post() ?>
        <div class="form-control">
            <label for="name">на e-mail</label>
            <input class="js-email" name="email"
                   id="email"
                   placeholder="mymail@mail.com"
                   type="text">
        </div>
        <div class="form-control">
            <label for="name">на телефон</label>
            <input class="js-phone" name="phone"
                   id="phone"
                   placeholder="Необходима авторизация"
                   type="text">
        </div>
        <div class="form-control">
            <input class="js-print-saved-cart" value="Распечатать" type="button">
            <input class="js-submit-button" value="Отправить" type="submit">
        </div>
    </form>
</div>

<div id="codeblog_basket_showing_enter_code" class="g-popup">
    <p>Введите код сохраненной корзины . Внимание, если сейчас в корзине есть товары, они будут заменены</p>
    <form class="js-saved-basket-number-form" method="post">
        <?= bitrix_sessid_post() ?>
        <input type="hidden" id="component_path" value="<?= $componentPath ?>">
        <div class="form-control">
            <label for="name">Отправить код</label>
            <input id="saved-basket-id" name="saved-basket-id" placeholder="xxxxxx" type="text">
        </div>
        <div class="form-control">
            <input id="enter_code_apply" class="js-submit-button" value="Отправить" type="submit">
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
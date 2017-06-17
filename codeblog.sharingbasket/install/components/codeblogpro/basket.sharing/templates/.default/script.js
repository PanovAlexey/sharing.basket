$(document).ready(function () {

    $(".js-submit-code-button").click(function () {
        savedBAsketId = $(".js-saved-basket-id").val();

        var data = "saved_basket_id=" + savedBAsketId + "&basket_sharing_ajax=y";

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: data,
            success: function (responseMessage) {
                if (typeof(responseMessage) == "number") {
                    $(".js-submit-code-button").html(responseMessage);
                }
                else {
                    $(".js-codeblog-basket-notification-error").html(responseMessage);
                    errorShow = setTimeout(function() {
                        $(".js-codeblog-basket-notification-error").html('');
                        clearTimeout(errorShow);
                    }, 5000)
                }
            }
        });

        return false;
    });

    $(".js-submit-send-button").click(function () {
        email = $('.js-basket-send-email').val();
        //phone = $('.js-basket-send-phone').val();
        code = $('.js-save-basket-number').text();

        var data = "email=" + email /*+ "&phone=" + phone*/ + "&send_basket=y" + "&basket_code=" + code;

        if (email /*|| phone*/) {
            $.ajax({
                type: "POST",
                url: window.location.href,
                data: data,
                success: function (responseMessage) {
                    if (responseMessage) {

                    }
                    else {

                    }

                }
            });
        }

        return false;
    });

    $(".js-enter-code-show").click(function () {
        $(".js-codeblog-basket-showing-enter-code").fadeIn();
        $(".js-codeblog-basket-answer").hide();

        return false;
    });

    $(".js-codeblog-notification-close").click(function () {
        $(this).parents('.codeblog-basket-notification').fadeOut();
        $('.js-codeblog-basket-answer').fadeIn();

        return false;
    });

    $(".js-class-codeblog-basket-save").click(function () {

        $('.js-basket-notification-saving').fadeIn();
        $('.codeblog-basket-captcha-container').fadeIn();
        $(".js-codeblog-basket-answer").hide();
        $('.js-codeblog-basket-saving-completed').fadeIn();

        var data = "save_basket=y" + "&basket_sharing_ajax=y";

        if (captchaIsShow == 'true') {
            data = data + "&" + captchaSidName + "=" + $("input[name='" + captchaSidName + "']").val() + "&" +
                captchaWordName + "=" + $("input[name='" + captchaWordName + "']").val();
        }

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: data,
            success: function (responseMessage) {
                if (responseMessage * 1 > 0) {
                    $(".js-basket-notification-saving .js-save-basket-number").html(responseMessage);
                    $('.codeblog-basket-captcha-container').fadeOut();
                }
                else {
                    $(".js-basket-notification-saving").html(responseMessage);
                }

            }
        });

        return false;
    });

    $('.js-class-codeblog-basket-saving-show').click(function () {

        $('.js-basket-notification-saving').fadeIn();
        $('.codeblog-basket-captcha-container').fadeIn();
        $(".js-codeblog-basket-answer").hide();

        return false;
    });
});
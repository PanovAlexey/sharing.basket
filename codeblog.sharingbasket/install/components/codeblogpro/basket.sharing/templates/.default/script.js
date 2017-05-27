$(document).ready(function () {

    $("#enter_code_apply").click(function () {

        savedBAsketId = $("#saved-basket-id").val();

        var data = "saved_basket_id=" + savedBAsketId + "&basket_sharing_ajax=y";

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: data,
            success: function (responseMessage) {
                if (typeof(responseMessage) == "number") {
                    $("#enter_code_apply").html(responseMessage);
                }
                else {
                    $("#codeblog_basket_notification").html(responseMessage);
                }
            }
        });

        return false;
    });

    $(".js-submit-button").click(function () {
        email = $('.js-basket-send-email').val();
        //phone = $('.js-basket-send-phone').val();
        code = $('#save-basket-number').text();

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

    $("#enter_code_show").click(function () {
        $("#codeblog_basket_showing_enter_code").fadeIn();
        $("#codeblog-basket-answer").hide();

        return false;
    });
    $(".codeblog-basket-close-icon").click(function () {
        $(this).parents('#codeblog_basket_notification').fadeOut();
    });

    $("#codeblog_basket_save_basket").click(function () {
        $('#codeblog_basket_notification').fadeIn();
        $('.codeblog-basket-captcha-container').fadeIn();

        return false;

    });

    $(".js-class-codeblog-basket-save").click(function () {

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
                    $("#codeblog_basket_notification #save-basket-number").html(responseMessage);
                    $('.codeblog-basket-captcha-container').fadeOut();
                    $('#codeblog_basket_saving_completed').fadeIn();

                    $("#codeblog-basket-answer").hide();
                }
                else {
                    $("#codeblog_basket_notification").html(responseMessage);
                }

            }
        });

        return false;
    });
});
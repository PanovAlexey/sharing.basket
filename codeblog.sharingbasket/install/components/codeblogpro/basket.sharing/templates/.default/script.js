$(document).ready(function () {

    $("#enter_code_apply").click(function () {

        savedBAsketId = $("#saved-basket-id").val();

        var data = "saved_basket_id=" + savedBAsketId + "&basket_sharing_ajax=y";

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: data,
            success: function (responseMessage) {
                if (responseMessage != 'error') {
                    $("#enter_code_apply").html(responseMessage);
                }
                else {
                    $("#codeblog_basket_notification").html('Корзина с указанным кодом не найдена');
                }
            }
        });

        return false;
    });

    $("#enter_code_show").click(function () {
        $("#codeblog_basket_showing_enter_code").fadeIn();
        $("#codeblog_basket_answer").hide();

        return false;
    });

    $("#codeblog_basket_save_basket").click(function () {

        var data = "save_basket=y" + "&basket_sharing_ajax=y";

        $.ajax({
            type: "POST",
            url: window.location.href,
            data: data,
            success: function (responseMessage) {
                if (responseMessage != 'error') {
                    $("#codeblog_basket_saving_completed #save-basket-number").text(responseMessage);
                    $("#codeblog_basket_saving_completed").fadeIn();
                    $("#codeblog_basket_answer").hide();
                }
            }
        });

        return false;
    });
});
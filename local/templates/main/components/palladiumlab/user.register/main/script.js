$(function () {
    $(document).on('submit', 'form.registration-form', function (e) {
        e.preventDefault();

        sendAjaxForm(this, '/').then(function (result) {
            result.success ? location.reload() : console.error(result);
        }).catch(function (result) {
            $('.error').remove();
            $('form.registration-form').find(".btn.submit.btn-full").before("<p class='error'>" + result.error + "</p>");
        });
    });
    $(".receive-code").on('click', function (e) {
        e.preventDefault();
        $("#phone-block-reg").hide();
        $("#code-block-reg").show();
    })
});

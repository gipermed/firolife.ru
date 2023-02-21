$(function () {
    $(document).on('submit', 'form.enter-form', function (e) {
        e.preventDefault();

        sendAjaxForm(this, '/').then(function (result) {
            result.success ? location.reload() : console.error(result);
        });
    });
});

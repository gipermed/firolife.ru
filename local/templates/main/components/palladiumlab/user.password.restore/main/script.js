$(function () {
    $(document).on('submit', 'form.restore-password-form', function (e) {
        e.preventDefault();

        sendAjaxForm(this, '/').then(function (result) {
            result.success ? location.reload() : console.error(result);
        });
    });
});

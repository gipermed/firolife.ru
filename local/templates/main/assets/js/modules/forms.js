export function sendAjaxForm(form, url = '/ajax/') {
    return new Promise((resolve, reject) => {

        let $form = $(form),
            $submit = $form.find('[type=submit]');

        $submit.attr('disabled', 'disabled');

        let previousSubmitText = $submit.text();

        $submit.text('Ожидайте');

        let formData = new FormData(form);

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success(result) {
                $submit.removeAttr('disabled');
                $submit.text(previousSubmitText);

                if (result.success) {
                    resolve(result);
                } else {
                    reject(result);
                }
            }
        });

    });
}

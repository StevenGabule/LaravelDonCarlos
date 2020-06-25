$(document).ready(function () {
    $('#contactForm').on('submit', function (e) {
        e.preventDefault();
        const formData = $(this).serialize();
        let html = '';
        const x = $("#btnSubmit");
        $.ajax({
            url: '/contact',
            method: 'GET',
            data: formData,
            processData: false,
            beforeSend: () => {
                x.attr('disabled', true);
                x.html(`<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true"></span>Sending...`)
            },
            success: ({success, errors, data}) => {
                if (success) {
                    html = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Well done!</strong> You successfully sending your request. We will contact you later.
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                </div>`;
                }
                if (errors.length > 0) {
                    html = '<div class="alert alert-danger">';
                    for (let count = 0; count < errors.length; count++) {
                        html += '<p class="mb-0">' + errors[count] + '</p>';
                    }
                    html += '</div>';
                }

                $("#form_result").html(`<br /><br />${html}`);
                x.attr('disabled', false);
                x.html(`<i class="far fa-paper-plane mr-2"></i> Send`)
            }

        }).fail((err) => console.log(err))
    })
})

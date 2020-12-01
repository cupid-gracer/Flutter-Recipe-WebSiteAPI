$(document).ready(function () {
    $("#EmailSettingForm").validate({
        ignore: [],
        rules: {
            smtp_host: {
                required: true,
            },
            smtp_username: {
                required: true,
            },
            smtp_port: {
                required: true,
            },
            smtp_password: {
                required: true,
            },
            smtp_secure: {
                required: true,
            },
            email_from_name: {
                required: true
            }
        },
    });

    $("#EmailSettingForm").submit(function () {
        if ($("#EmailSettingForm").valid()) {
            $('#loader').show();
        }
    });
    $("#TestEmailSettingForm").validate({
        ignore: [],
        rules: {
            subject: {
                required: true,
            },
            message: {
                required: true,
            },
            to_email: {
                required: true,
                email: true
            }
        },
    });

    $("#TestEmailSettingForm").submit(function () {
        if ($("#TestEmailSettingForm").valid()) {
            $('#loader').show();
        }
    });
});
$(document).ready(function () {
    if ($("#LoginForm").length > 0) {
        $("#LoginForm").validate({
            ignore: [],
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true
                }
            }
        });

        $("#LoginForm").submit(function () {
            if ($("#LoginForm").valid()) {
                $('#loader').show();
            }
        });
    }


    if ($("#forgotPassForm").length > 0) {
        $("#forgotPassForm").validate({
            ignore: [],
            rules: {
                email: {
                    required: true
                }
            },
        });
    }

    if ($("#forgotPassForm").length > 0) {
        $("#forgotPassForm").submit(function () {
            if ($("#forgotPassForm").valid()) {
                $('#loader').show();
            }
        });
    }

    if ($("#confPassForm").length > 0) {
        $("#confPassForm").validate({
            ignore: [],
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                conf_password: {
                    required: true,
                    equalTo: "#password",
                }
            },
        });

        $("#confPassForm").submit(function () {
            if ($("#confPassForm").valid()) {
                $('#loader').show();
            }
        });
    }

});

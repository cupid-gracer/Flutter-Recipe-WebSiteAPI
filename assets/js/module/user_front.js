$(document).ready(function () {
    if ($("#UserRegisterForm").length > 0) {
        $("#UserRegisterForm").validate({
            ignore: [],
            rules: {
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                email: {
                    required: true,
                    remote: {
                        type: "post",
                        url: base_url + "check-user-email",
                        data: {
                            user_id: function () {
                                return $("#user_id").val();
                            },
                            email: function () {
                                return $("#email").val();
                            },
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                },
                conf_password: {
                    required: true,
                    equalTo: '#password'
                }
            },
            messages: {
                email: {
                    remote: "Email already exist.",
                }
            },
        });
        $("#UserRegisterForm").submit(function () {
            if ($("#UserRegisterForm").valid()) {
                $("#loader").show();
            }
        });
    }


    if ($("#UserProfileForm").length > 0) {
        $("#UserProfileForm").validate({
            ignore: [],
            rules: {
                firstname: {
                    required: true
                },
                lastname: {
                    required: true
                },
                profile_image: {
                    required: false,
                    accept: 'image/*',
                    extension: "jpg|jpeg|png|gif",
                },
                phone: {
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true,
                    required: true,
                    remote: {
                        type: "post",
                        url: base_url + "check-user-email",
                        data: {
                            user_id: function () {
                                return $("#user_id").val();
                            },
                            email: function () {
                                return $("#email").val();
                            },
                        }
                    }
                }
            },
            messages: {
                email: {
                    remote: "Email already exist.",
                }
            },
        });

        $("#UserProfileForm").submit(function () {
            if ($("#UserProfileForm").valid()) {
                $('#loader').show();
            }
        });
    }
});

function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}
function deleteImage(e) {
    var id = $(e).data('id');
    $.ajax({
        type: 'post',
        url: base_url + "delete-user-profile-image/" + id,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();
            if (data) {
                $('img' + '#profile_image').attr('src', '<?php echo base_url() . NO_USER_PATH; ?>');
                $("#hidden_image").val('');
            }
        }
    });
}
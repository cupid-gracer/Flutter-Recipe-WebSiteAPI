$(document).ready(function () {

    if ($("#ChangePasswordForm").length > 0) {
        $("#ChangePasswordForm").validate({
            ignore: [],
            rules: {
                current_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 8
                },
                confirm_password: {
                    required: true,
                    equalTo: "#new_password",
                },
            },
        });

        $("#ChangePasswordForm").submit(function () {
            if ($("#ChangePasswordForm").valid()) {
                $('#loader').show();
            }
        });
    }



    if ($("#ContactForm").length > 0) {
        $("#ContactForm").validate({
            ignore: [],
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },
                message: {
                    required: true
                },
            },
        });
        $("#ContactForm").submit(function () {
            if ($("#ContactForm").valid()) {
                $("#loader").show()
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
        $("#forgotPassForm").submit(function () {
            if ($("#forgotPassForm").valid()) {
                $('#loader').show();
            }
        });
    }

    if ($("#resetPasswordFrom").length > 0) {
        $("#resetPasswordFrom").validate({
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
        $("#resetPasswordFrom").submit(function () {
            if ($("#resetPasswordFrom").valid()) {
                $('$loader').show();
            }
        });
    }


    if ($("#LoginForm").length > 0) {
        $("#LoginForm").validate({
            ignore: [],
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true
                },
            },
        });
        $("#LoginForm").submit(function () {
            $('.catch-message').removeClass("error-message").empty();
            if ($("#LoginForm").valid()) {
                $("#loader").show();
            }
        });
    }

    $('.catch-message').removeClass("error-message").empty();
    /*log in modal*/
    if ($("#ModalLoginForm").length > 0) {
        $("#ModalLoginForm").validate({
            ignore: [],
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true
                },
            },
        });
    }

    $("#login-modal-button").on('click', function () {
        $('.catch-message').removeClass("error-message").empty();
        if ($("#ModalLoginForm").valid()) {
            $.ajax({
                url: base_url + "modal-login-action",
                type: 'post',
                data: $("#ModalLoginForm").serialize(),
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (data) {
                    $("#loader").hide();
                    var res = jQuery.parseJSON(data)
                    if (res.status) {
                        $("#LoginModal").modal('hide');
                        $('.catch-message').addClass("error-message").empty();
                        $("#email").val("");
                        $("#password").val("");
                        window.location.reload();
                    } else {
                        $('.catch-message').addClass("error-message").html(res.message);
                        $("#password").val("");
                    }
                }
            });
        }
    });

// open login modal if user not login and submit comment
    $(".openLoginModal").on('click', function () {
        $("#LoginModal").modal('show');
    })
    // Add smooth scrolling to all links
    $(".slides .entry-button").on('click', function (event) {
        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });

    $("body").on('hidden.bs.modal', function (event) {
        $('.catch-message').removeClass("error-message").empty();
    });

});
function bookmark(e) {
    $("#bookmarkme").toggleClass("active");
    var user_id = user_idval;
    var recipe_id = $(e).data('id');
    $.ajax({
        type: 'post',
        url: base_url + "bookmark-save",
        data: {user_id: user_id, recipe_id: recipe_id},
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();
            var res = jQuery.parseJSON(data)
            if (res.status) {
                $("#bookmark_message").html(res.message);
                $("#bookmark_message").show();
                if (res.code == 1) {
                    $(e).closest(".bookmark-text").html("REMOVE BOOKMARK");
                } else {
                    $(e).closest(".bookmark-text").html("BOOKMARK RECIPE");
                }
                setTimeout(function () {
                    $("#bookmark_message").fadeOut(2000)
                }, 3000);
            } else {
            }
        }
    });
}
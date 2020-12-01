$(document).ready(function () {
    $("#CustomerForm").validate({
        ignore: [],
        rules: {
            firstname: {
                required: true,
            },
            lastname: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                minlength: 10,
                maxlength: 10,
            },
            profile_image: {
                required: false,
                accept: "image/*",
                extension: "jpg|jpeg|png|gif"
            }
        },
    });

    $("#CustomerForm").submit(function () {
        if ($("#CustomerForm").valid()) {
            $('#loader').show();
        }
    });
})

// image url
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
        url: base_url + "admin/delete-user-image/" + id,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();

            if (data) {
                $('img' + '#profile_image').attr('src', NO_USER_PATH);
                $("#hidden_image").val('');
            }
        }
    });
}
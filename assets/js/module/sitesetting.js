$(document).ready(function () {
    $("#SiteSettingForm").validate({
        ignore: [],
        rules: {
            site_name: {
                required: true,
            },
            site_email: {
                required: true,
            },
            site_phone: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            site_logo: {
                accept: "image/*",
                extension: "jpg|jpeg|png|gif"
            },
            site_favicon: {
                required: false,
                accept: "image/*",
                extension: "jpg|jpeg|png|gif|ico"
            },
            time_zone: {
                required: true
            }
        },
    });

    $("#SiteSettingForm").submit(function () {
        if ($("#SiteSettingForm").valid()) {
            $('#loader').show();
        }
    });
})

function logoURL(input) {
    var id = $(input).attr("id");
    var image = '#' + 'site_logo_url';
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    reader.onload = function (e) {
        $('img' + image).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
}


function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "ico" || ext == "png" || ext == "jpeg" || ext == "jpg"))
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
        url: base_url + "admin/delete-favicon-image/" + id,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();
            if (data) {
                $('img' + '#site_favicon').attr('src', NO_IMAGE_PATH);
                $("#hidden_favicon").val('');
            }
        }
    });
}

function changeColor(e) {
    $('#color_code').val($(e).val())
}
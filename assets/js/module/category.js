$(document).ready(function () {
    $("#CategoryForm").validate({
        ignore: [],
        rules: {
            category_name: {
                required: true,
                remote: {
                    url: base_url + "admin/check-category-name",
                    type: "post",
                    data: {
                        category_name: function () {
                            return $("#category_name").val();
                        },
                        cid: function () {
                            return $("#cid").val();
                        }
                    },
                }
            },
            category_image: {
                required: false,
                accept: "image/*",
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            category_name: {
                remote: "Please enter unique value.",
            }
        },
    });

    $("#CategoryForm").submit(function () {
        if ($("#CategoryForm").valid()) {
            $('#loader').show();
        }
    });

    //  delete record
    $('#DeleteCategory').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: base_url + "admin/delete-category/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $('#loader').show();
            },
            success: function () {
                window.location.reload();
            }
        });
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
// delete record
function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    $("#record_id").val(id);
}
function deleteImage(e) {
    var id = $(e).data('id');
    $.ajax({
        type: 'post',
        url: base_url + "admin/delete-category-image/" + id,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (data) {
            $("#loader").hide();
            if (data) {
                $('img' + '#category_image').attr('src', NO_IMAGE_PATH);
                $("#hidden_image").val('');
            }
        }
    });
}
$(document).ready(function () {
    var wrapper = $(".input_fields_wrap"); //Fields wrapper

    $(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
        e.preventDefault();
        $(this).closest('.ingredients_field').remove();
        x--;
    })


    // add direction field

    var y = 1;
    $(".add_direction_button").click(function (e) {
        e.preventDefault();
        $(".direction_field").append('<div class="direction_field_edit"><input type="text" name="direction[]" class="form-control mt-2" placeholder="Direction" required><span class="mt-2 ml-2"><button class="remove_direction btn btn-danger" type="button" title="Remove"><i class="fa fa-minus-circle"></i></button></span></div>'); //add input box
        y++;
    });

    $(".direction_field").on("click", ".remove_direction", function (e) {
        e.preventDefault();
        $(this).closest('div').remove();
        y--;
    })

    // add more file
    var z = 1;
    $(".add-more-image").click(function (e) {
        e.preventDefault();
        $("#input_file_block").append('<div class="custom-file mt-2"><input type="file" class="custom-file-input"  name="recipes_image[]" id="recipes_image' + z + '" readonly accept="image/*" onchange="readURL(this)" /><label class="custom-file-label" for="recipes_image' + z + '">Choose file</label></div>');
        z++;
    });
    $("#DeleteImage").on('click', function () {
        var id = $("#delete_id").val();
        var key = $("#key").val();
        var value = $("#value").val();
        $.ajax({
            type: 'post',
            url: base_url + "admin/delete-recipe-image",
            data: {id: id, key: key, value: value},
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide();
                if (data) {
                    window.location.reload();
                }
            }
        });
    });

    $("#RecipesForm").validate({
        // ignore: [],
        rules: {
            recipes_heading: {
                required: true,
            },
            'recipes_image[]': {
                accept: "image/*",
                extension: "jpg|jpeg|png|gif",
            },
            recipes_time: {
                required: true,
                digits: true,
                min: 1
            },
            cid: {
                required: true
            },
            summary: {
                required: true
            },
            serving_person: {
                required: true,
                digits: true,
                min: 1
            },
            "direction[]": {
                required: true
            },
            "ingredient_name[]": {
                required: true,
            },
            "quantity[]": {
                required: true
            },
            "weight[]": {
                required: true
            }

        },
        messages: {
            'recipes_image[]': {
                accept: 'Please enter a value with a valid extension(jpg,gif,jpeg,png).'
            }
        }
    });

    $("#RecipesForm").submit(function (e) {
        if ($("#RecipesForm").valid()) {
            $('#loader').show();
        }
    });

    $('#DeleteRecipes').on('click', function () {
        var id = $("#record_id").val();
        $.ajax({
            url: base_url + "admin/delete-recipes/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                window.location.href = base_url + "recipes";
            }
        });
    });
});

function DeleteRecord(element) {
    var id = $(element).attr('data-id');
    $("#record_id").val(id);
}


function deleteImage(e) {
    var id = $(e).data('id');
    var image = "#" + id;
    $(image).parent("div").remove();
    $(image).remove();
    $("li" + image).remove();
    $("img" + image).remove();
}

// delete image from json_string from database
function deleteImageEdit(e) {
    var id = $(e).data('id');
    var key = $(e).data('key');
    var value = $(e).data('value');
    $("#delete_id").val(id);
    $("#key").val(key);
    $("#value").val(value);
}

function readURL(input) {
    var id = $(input).attr("id");
    var image = '#' + id;
    var ext = input.files[0]['name'].substring(input.files[0]['name'].lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg"))
        var reader = new FileReader();
    $("li" + image).remove();
    $("img" + image).remove();
    reader.onload = function (e) {
        var fileName = $(input).val().split("\\").pop();
        $(input).siblings(".custom-file-label").addClass("selected").html(fileName);
        if (id == "recipes_image") {
            $($.parseHTML("<li class='list-inline-item'><div><img class='mt-2' src='" + event.target.result + "' id='" + id + "' height='100px' width='100px'></div></li>")).appendTo("#append-img");
            $("#add_more_image_btn").removeClass('d-none');
        } else {
            $($.parseHTML("<li class='list-inline-item' id='" + id + "'><div class='image-block-recipe'><img class='mt-2' src='" + event.target.result + "' id='" + id + "' height='100px' width='100px'><a href='javaScript:void(0)' data-id='" + id + "' onclick='deleteImage(this)' class='delete-icon-on-hover-recipe'><i class='fa fa-trash'></i></a></div></li>")).appendTo("#append-img");
            $("#add_more_image_btn").removeClass('d-none');
        }

    }
    reader.readAsDataURL(input.files[0]);
}





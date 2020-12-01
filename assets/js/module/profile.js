$(document).ready(function () {
    $("#ProfileForm").validate({
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
                accept:'image/*',
                extension: "jpg|jpeg|png|gif",
            },
            phone: {
                required: true,
                minlength: 10,
                maxlength:10
            },
            email: {
                required: true
            }
        },
    });

    $("#ProfileForm").submit(function () {
        if ($("#ProfileForm").valid()) {
            $('#loader').show();
        }
    });
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

function deleteImage(e){
    var id =$(e).data('id');
    $.ajax({
        type:'post',
        url:base_url + "admin/delete-profile-image/" +id,
        beforeSend :function(){
          $("#loader").show();
        },
        success:function(data){
            $("#loader").hide();
           if(data){
            $('img' + '#profile_image').attr('src',NO_USER_PATH);
            $("#hidden_image").val('');
           }
        }
    });
}
$(document).ready(function(){
	$("#CarouselForm").validate({
        ignore: [],
        rules: {
            title: {
				required: true,
				remote: {
                    url: base_url + "admin/check-carousel-title",
                    type: "post",
                    data: {
                        title: function () {
                            return $("#title").val();
                        },
                        id: function () {
                            return $("#id").val();
                        }
                    },
                }
            },
            sub_title:{
                required:true
            },
            image:{
                accept:"image/*",
                extension:"jpg|jpeg|png|gif"
            }
		 },
		 messages: {
            title:{
				remote:"Please enter unique value.",
			} 
        },
    });

    $("#CarouselForm").submit(function () {
        if ($("#CarouselForm").valid()) {
                $('#loader').show();
        }
    });	

    //  delete record
    $('#DeleteCarousel').on('click', function () {
        var id = $("#delete_carousel_id").val();
        $.ajax({
            url: base_url + "admin/delete-carousel/" + id,
            type: "post",
            data: {token_id: csrf_token_name},
            beforeSend: function () {
                $('#loader').show();
            },
            success: function (data) {
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
    $("#delete_carousel_id").val(id);
}

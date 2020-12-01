$(document).ready(function () {

    $('.toggle.btn').click(function(){
        var f = document.getElementById('today-recipe').checked;
        var rid = $("#today-recipe").data("id");
        var url = "admin/";
        if(!f){
            url += "settodayrecipe";
        }else{
            url += "deltodayrecipe";
        }
        $.ajax({
            url: base_url + url,
            data: {
                "rid": rid
            },
            dataType : "json",
            type: "POST",
            success: function(){
                alert("ok");
            }
        });
    });

    
});

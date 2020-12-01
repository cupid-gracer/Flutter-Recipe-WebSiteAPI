$(document).ready(function () {
    var rid = $("#ridh").val();
    var user_id = $("#user_idh").val();

    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars').on('mouseover', 'li', function () {
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function (e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });

    }).on('mouseout', 'li', function () {
        $(this).parent().children('li.star').each(function (e) {
            $(this).removeClass('hover');
        });
    });


    /* 2. Action to perform on click */
    $('#stars').on('click', 'li', function () {
        if (user_id == '') {
            $("#LoginModal").modal('show');
        } else {
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
            var stars = $(this).parent().children('li.star');

            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }

            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }

            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
            $.ajax({
                url: base_url + "rating",
                type: 'post',
                data: {rid: rid, user_id: user_id, ratingValue: ratingValue},
                beforeSend: function () {
                    $("#loader").show();
                },
                success: function (data) {
                    $("#loader").hide();
                    if (data) {
                        var res = jQuery.parseJSON(data)
                        var icon_array = res.user_rating.split("</i>");
                        var li_str = "";
                        var title_array = ['Poor', 'Fair', 'Good', 'Excellent', 'WOW!!!'];
                        var value_array = ['1', '2', '3', '4', '5'];
                        for (var i = 0; i < icon_array.length; i++) {
                            if (i <= 4) {
                                li_str += '<li class="star mr-2" title="' + title_array[i] + '" data-value="' + value_array[i] + '"> ' + icon_array[i] + '</i>' + '</li>';
                            }
                        }
                        $("#stars").html(li_str);
                        $("#display_review").html(res.total_rating);
                        $(".average_rating").html(res.rating);
                        var msg = "";
                        if (ratingValue > 1) {
                            msg = "Thanks! You rated this " + ratingValue + " stars.";
                        } else {
                            msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
                        }
                        $("#thanks_msg").html(msg);
                        $("#thanks_star").html(res.user_rating)
                        $("#RatingDoneModal").modal('show');
                    }
                }
            });
        }
    });


//  comment form 
    $("#CommentForm").validate({
        ignore: [],
        rules: {
            comment: {
                required: true
            }
        }
    });
// comment reply form
    $("#ReplyCommentForm").validate({
        ignore: [],
        rules: {
            reply_comment: {
                required: true
            }
        }
    });
    $(document).on('click', '.comment-reply .close', function () {
        $("#reply_comment_id").val("");
        $(".reply_comment_error").html("");
        $(this).parent().remove();
    });
});
function commentReply(e) {
    var rid = $("#ridh").val();
    var user_id = $("#user_idh").val();

    $("#reply_comment_id").val("");
    $("#reply_comment").val("");
    $(".reply_comment_error").html("");
    $('.comment-content .comment-reply').remove();
    var comment_id = $(e).attr('data-id');
    $("#reply_comment_id").val(comment_id);
    var html_form = '<div class="comment-reply">' +
            '<button class="close">&times;</button>' +
            '<div class="">' +
            '<h3 class="heading">REPLY TO THIS COMMENT</h3>' +
            '</div>' +
            '<form name="ReplyCommentForm" id="ReplyCommentForm">' +
            '<input type="hidden" id="reply_comment_id" name="reply_comment_id" value="' + comment_id + '">' +
            '<input type="hidden" id="recipe_id" name="recipe_id" value="' + rid + '">' +
            '<input type="hidden" id="user_id" name="user_id" value="' + user_id + '">' +
            '<div class="form-group">' +
            '<label for="">Comment :<small class="text-red">*</small></label>' +
            '<textarea name="reply_comment" id="reply_comment" cols="30" rows="5" onkeyup="onChangeComment(this)"></textarea>' +
            '<span class="reply_comment_error error"></span>' +
            '</div>' +
            '<div class="form-group submit-group">' +
            '<button type="button" disabled="true" onclick="replyCommentSubmit(this)" id="replyCommentButton" class="ht-button view-more-button">' +
            '<i class="fa fa-arrow-left"></i> SUBMIT <i class="fa fa-arrow-right"></i>' +
            '</button>' +
            '</div>' +
            '</form>' +
            '</div>'
    $(e).parentsUntil("ol").find('.comment-content').first().append(html_form).end();

}
function onChangeComment(e) {
    if (e.value == '') {
        $("#replyCommentButton").attr("disabled", true);
        $("#commentButton").attr("disabled", true);
    } else {
        $("#replyCommentButton").attr("disabled", false);
        $("#commentButton").attr("disabled", false);
    }
}
function replyCommentSubmit(e) {
    if ($('#ReplyCommentForm').valid()) {
        var comment_id = $("#reply_comment_id").val();
        $.ajax({
            type: 'post',
            url: base_url + "reply-comment-action",
            data: $("#ReplyCommentForm").serialize(),
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide();
                var res = jQuery.parseJSON(data)
                if (res.status) {
                    $(".total-comment").html(res.total_comment)

                    if ($(e).closest("li").find(".children").length > 0) {
                        // first child append
                        $(e).closest("li").find(".children").append(res.data)
                    } else {
                        // second child append
                        $(e).closest(".children").append(res.data)
                    }
                    $("#reply_comment_id").val("");
                    $("#reply_comment").val("");
                    $(".reply_comment_error").html("");
                    $("#commentButton").attr("disabled", true);
                    $('.comment-content .comment-reply').remove();
                } else {
                    $(".reply_comment_error").html(res.data);
                }
            }
        });
    }
}
function commentSubmit(e) {
    if ($('#CommentForm').valid()) {
        $.ajax({
            type: 'post',
            url: base_url + "comment-action",
            data: $("#CommentForm").serialize(),
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide()
                var res = jQuery.parseJSON(data)
                if (res.status) {
                    $(".total-comment").html(res.total_comment)
                    $(".comment-list").append(res.data);
                    $("#comment").val("");
                    $(".comment_error").html("");
                    $("#commentButton").attr("disabled", true);
                } else {
                    $(".comment_error").html(res.data);
                }
            }
        });
    }
}
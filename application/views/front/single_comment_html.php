<li class="<?php echo isset($comment_type) && $comment_type =="C" ? "comment even depth-1 parent" : "" ;?>">
    <div class="comment-body">
        <footer class="comment-meta">
             <div class="comment-author">
                    <?php 
                    $comment_img =get_user_profile_image($user->profile_image);
                    $date_timestamp = strtotime($comment_date);
                    $time = date('h:i:a', $date_timestamp);  
                    $month = date('F', $date_timestamp);  
                    $year = date('Y', $date_timestamp);  
                    $day = date('j', $date_timestamp);  
                    ?>
                    <img alt="" src="<?php echo $comment_img ;?>" class="avatar">
            </div>
            <div class="comment-metadata">
                <a href="javascript:void(0)" rel="external nofollow" class="author"><?php echo $user->firstname ." ".$user->lastname;?></a>
                <time class="time"><?php echo $month ." ".$day.",".$year." at ".$time?></time>
                <div class="action">
                     <span><a class="comment-reply-link"  onclick="commentReply(this)" href="javascript:void(0)" data-id="<?php echo isset($comment_id) ? $comment_id :'';?>">Reply</a></span>
                </div>
            </div>
        </footer>
        <div class="comment-content">
            <p>
            <?php echo isset($comment) ? $comment:'';?>
            </p>
        </div>
        <?php if(isset($comment_type) && $comment_type =="C"){ ?>
        <ol class="children">
        </ol>
        <?php }?>
    </div>
</li>
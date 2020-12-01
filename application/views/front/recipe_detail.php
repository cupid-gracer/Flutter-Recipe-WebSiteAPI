<?php include VIEWPATH . "front/templates/header.php"; ?>
<input type="hidden" id="ridh" name="rid" value="<?php echo isset($recipe->rid) ? $recipe->rid : ""; ?>"/>
<input type="hidden" id="user_idh" name="user_id" value="<?php echo isset($user_id) ? $user_id : ""; ?>"/>

<div class="ht-page-header" style="background-image: url('<?php echo base_url() . front_img_path; ?>parallax/2.jpg')">
    <div class="overlay" style="background: rgba(0,0,0,.5)"></div>
    <div class="container">
        <div class="inner">
            <h2 class="heading">Recipe</h2>
            <ol class="ht-breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li>Recipe detail</li>
            </ol>
        </div>
        <!-- / .inner -->
    </div>
    <!-- / .container -->
</div>
<!-- / .ht-page-header -->

<section class="ht-section hs-recipe single">
    <header class="hs-header">
        <div class="container">
            <p class="entry-meta">
                <span class="meta-level master">CATEGORY: <span><?php echo ucfirst($recipe->category_name); ?></span></span>
                <span class="meta-time">TIME: <?php echo $recipe->recipes_time; ?>  Minutes</span>
            </p>
            <h2 class="heading"><?php echo ucfirst($recipe->recipes_heading); ?></h2>
            <p class="entry-meta meta-author">
                <?php
                if ($recipe->profile_image != '' && file_exists(FCPATH . uploads_path . "profile/" . $recipe->profile_image)) {
                    $profile_image = base_url() . uploads_path . "profile/" . $recipe->profile_image;
                } else {
                    $profile_image = base_url() . NO_USER_PATH;
                }
                ?>
                <img src="<?php echo $profile_image; ?>" alt="<?php echo ucfirst($recipe->created_by); ?>" height="36px" width="36px">
                Post by <?php echo ucfirst($recipe->created_by); ?>
            </p>
        </div>
    </header>
    <!-- / .hs-header -->
    <div class="hs-content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <div class="entry entry-media">
                        <div id="flexslider-1" class="flexslider sync" data-sync="#sync-carousel-1" data-auto="true" data-effect="slide" data-navi="true" data-pager="false" data-slide-speed="7000" data-animation-speed="1000">
                            <ul class="slides">
                                <?php
                                $image_array = json_decode($recipe->recipes_image);
                                if (isset($image_array) && count($image_array) > 0) {
                                    foreach ($image_array as $key => $value) {
                                        if ($image_array[0] != '' && file_exists(FCPATH . uploads_path . "recipes/" . $value)) {
                                            $img_url = base_url() . uploads_path . "recipes/" . $value;
                                        } else {
                                            $img_url = base_url() . NO_IMAGE_PATH;
                                        }
                                        ?>
                                        <li>
                                            <img src="<?php echo $img_url; ?>">
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <div id="sync-carousel-1" class="flexslider-sync-carousel">
                            <ul class="slides">
                                <?php
                                $image_array = json_decode($recipe->recipes_image);
                                if (isset($image_array) && count($image_array) > 0) {
                                    foreach ($image_array as $key => $value) {
                                        if ($image_array[0] != '' && file_exists(FCPATH . uploads_path . "recipes/" . $value)) {
                                            $img_url = base_url() . uploads_path . "recipes/" . $value;
                                        } else {
                                            $img_url = base_url() . NO_IMAGE_PATH;
                                        }
                                        ?>
                                        <li>
                                            <img src="<?php echo $img_url; ?>" alt="" width="60px" height='60px'>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- / .entry-media -->
                    <div class="entry entry-action">
                        <?php
                        if (isset($user_id) && $user_id != '') {
                            $bookmark = get_bookmark($recipe->rid, $user_id);
                            ?>
                            <a id="bookmarkme" href="javascript:void(0)" onclick="bookmark(this)" data-id="<?php echo $recipe->rid; ?>" title="Bookmark" class="action action-bookmark <?php echo isset($bookmark) && $bookmark != '' ? 'active' : ''; ?>">
                                <i class="fa fa-bookmark"></i>
                                <p>BOOKMARK</p>
                            </a>	
                        <?php } else { ?>
                            <a id="bookmarkme" href="javascript:void(0)" class="openLoginModal action action-bookmark" title="Bookmark">
                                <i class="fa fa-bookmark"></i>
                                <p>BOOKMARK</p>
                            </a>
                        <?php } ?>
                        <span  class="action action-print">
                            <span> <?php echo $recipe->serving_person; ?></span>
                            <p>SERVING PERSON</p>
                        </span>
                        <div class="action action-share">
                            <span><?php echo $recipe->calories; ?> kcal</span>
                            <p>CALORIES</p>
                        </div>
                        <div class="action entry-rate" style="float:right">
                            <span id="display_review">
                                <?php
                                $rating = round(get_average_rating($recipe->rid), 1);
                                $html = get_star($rating);
                                ?>
                                <?php echo $html; ?>
                            </span>
                            <p><span class="average_rating"><?php echo isset($rating) && $rating != 0 ? $rating : 'NO'; ?></span> AVERAGE RATINGS</p>
                        </div>
                    </div>
                    <!-- / .entry-action -->
                    <div class="entry entry-description">
                        <h4 class="entry-title">Summary</h4>
                        <p><?php echo $recipe->summary; ?></p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <div class="entry entry-ingredient">
                        <h4 class="entry-title">Ingredients</h4>
                        <table class="table table-tripped">
                            <tbody>
                                <tr class="section-title">
                                    <td>Ingredients</td>
                                </tr>
                                <?php
                                if (isset($ingredients) && !empty($ingredients)) {
                                    foreach ($ingredients as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $row->qty . " " . $row->weight . " " . $row->ingredient_name; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>			
                            </tbody>
                        </table>
                    </div>
                    <!-- / .entry-action -->
                    <div class="entry entry-instruction">
                        <h4 class="entry-title">Instruction</h4>
                        <dl class="dl-horizontal">
                            <?php
                            $direction = json_decode($recipe->direction);
                            if (isset($direction) && !empty($direction)) {
                                foreach ($direction as $key => $value) {
                                    ?>
                                    <dt><?php echo $key + 1; ?></dt>
                                    <dd><?php echo $value; ?></dd>
                                    <?php
                                }
                            }
                            ?>
                        </dl>
                    </div>
                    <!-- rating -->
                    <!-- / .entry-instruction -->
                    <section class='rating-widget'>
                        <h4 class="text-center">Your valuable rating</h4>
                        <?php
                        $user_rating = round(get_user_rating($recipe->rid, $user_id), 1);
                        $user_rat = get_star($user_rating);
                        $user_rat_arr = explode("</i>", $user_rat);
                        $title_array = array('Poor', 'Fair', 'Good', 'Excellent', 'WOW!!!');
                        $value_array = array('1', '2', '3', '4', '5');
                        ?>
                        <?php if (isset($user_rating) && $user_rating != 0) { ?>	
                            <div class='rating-stars text-center'>
                                <ul id='stars'>
                                    <?php
                                    foreach ($user_rat_arr as $key => $value) {
                                        if ($key > 4) {
                                            break;
                                        }
                                        ?>
                                        <li class='star' title='<?php echo $title_array[$key]; ?>' data-value='<?php echo $value_array[$key]; ?>'>
                                            <?php echo $value . "</i>"; ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <!-- Rating Stars Box -->
                        <div class='rating-stars text-center <?php echo isset($user_rating) && $user_rating != 0 ? 'd-none' : ''; ?>'>
                            <ul id='stars'>
                                <li class='star' title='Poor' data-value='1'>
                                    <i class='fa fa-star'></i>
                                </li>
                                <li class='star' title='Fair' data-value='2'>
                                    <i class='fa fa-star'></i>
                                </li>
                                <li class='star' title='Good' data-value='3'>
                                    <i class='fa fa-star'></i>
                                </li>
                                <li class='star' title='Excellent' data-value='4'>
                                    <i class='fa fa-star'></i>
                                </li>
                                <li class='star' title='WOW!!!' data-value='5'>
                                    <i class='fa fa-star'></i>
                                </li>
                            </ul>
                        </div>
                    </section>
                </div>
            </div>
            <!-- / .row -->
        </div>
        <!-- / .container -->
    </div>
    <!-- / .hs-content -->
</section>

<div class="ht-section hs-recipe related">
    <div class="container">
        <div class="row">
            <!-- thêm col-sm-offset-2 khi ở recipe_single-->
            <div class="col-sm-1 col-xs-12"></div>
            <div class="col-xs-12 col-sm-10">
                <div class="border-top"></div>

                <header class="hs-header">
                    <h2 class="heading">YOU MAY ALSO LIKE</h2>
                </header>
                <div class="hs-content">
                    <?php
                    if (isset($recent_recipes) && !empty($recent_recipes)) {
                        foreach ($recent_recipes as $row) {
                            $recent_image_array = json_decode($row->recipes_image);
                            if (isset($recent_image_array) && count($recent_image_array) > 0) {
                                if ($recent_image_array[0] != '' && file_exists(FCPATH . uploads_path . "recipes/" . $recent_image_array[0])) {
                                    $recent_img_url = base_url() . uploads_path . "recipes/" . $recent_image_array[0];
                                } else {
                                    $recent_img_url = base_url() . NO_IMAGE_PATH;
                                }
                            } else {
                                $recent_img_url = base_url() . NO_IMAGE_PATH;
                            }
                            $date_timestamp = strtotime($row->created_on);
                            $month = date('F', $date_timestamp);
                            $year = date('Y', $date_timestamp);
                            $day = date('j', $date_timestamp);
                            ?>
                            <a href="<?php echo base_url('recipe-detail/' . $row->rid); ?>" class="entry">
                                <div class="entry-media">
                                    <img src="<?php echo $recent_img_url; ?>" alt="">
                                </div>
                                <div class="entry-content">
                                    <p class="meta-cat"><?php echo $row->category_name; ?></p>
                                    <h3 class="entry-title">
                                        <?php
                                        $related_recipe_chars = strlen($row->recipes_heading);
                                        if ($related_recipe_chars > RECIPE_NAME_CHAR_LIMIT) {
                                            echo ucfirst(substr($row->recipes_heading, 0, RECIPE_NAME_CHAR_LIMIT)) . '...';
                                        } else {
                                            echo ucfirst($row->recipes_heading);
                                        }
                                        ?>
                                    </h3>
                                    <p class="meta-date">Posted On <?php echo $month . "  " . $day . ", " . $year; ?></p>
                                </div>
                            </a>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-1 col-xs-12"></div>
            <!-- / .columns -->
        </div>
        <!-- / .row -->
    </div>
    <!-- /.container -->
</div>
<!-- / .hs-recipes-related -->
<!-- comment section -->
<div class="ht-section hs-comment related">
    <div class="container">
        <div class="row">
            <div class="col-sm-1 col-xs-12"></div>
            <div class="col-xs-12 col-sm-10">
                <div class="border-top"></div>
                <?php
                $total_comments = get_total_comments($recipe->rid);
                $comment = get_comments($recipe->rid);
                ?>
                <header class="hs-header">
                    <h2 class="heading"><span class="total-comment"><?php echo isset($total_comments) && $total_comments != 0 ? $total_comments : 'No'; ?></span> Comments</h2>
                </header>
                <div class="hs-content">
                    <ol class="comment-list">
                        <?php
                        if (isset($comment) && !empty($comment)) {
                            foreach ($comment as $key => $row) {
                                ?>
                                <!-- user/parent comment -->
                                <li class="comment even depth-1 parent">
                                    <div class="comment-body">
                                        <footer class="comment-meta">
                                            <div class="comment-author">
                                                <?php
                                                $comment_img = get_user_profile_image($row['profile_image']);
                                                $old_date_timestamp = strtotime($row['created_on']);
                                                $time = date('h:i:a', $old_date_timestamp);
                                                $month = date('F', $old_date_timestamp);
                                                $year = date('Y', $old_date_timestamp);
                                                $day = date('j', $old_date_timestamp);
                                                ?>
                                                <img alt="" src="<?php echo $comment_img; ?>" class="avatar">
                                            </div>

                                            <div class="comment-metadata">
                                                <a href="javascript:void(0)" rel="external nofollow" class="author"><?php echo $row['comment_by']; ?></a>
                                                <time class="time"><?php echo $month . " " . $day . "," . $year . " at " . $time ?></time>
                                                <div class="action">
                                                    <?php if (isset($user_id) && $user_id != '') { ?>
                                                        <span><a class="comment-reply-link" onclick="commentReply(this)" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Reply</a></span>
                                                    <?php } else { ?>
                                                        <span><a href="javascript:void(0)" class="openLoginModal">Reply</a></span>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </footer><!-- .comment-meta -->

                                        <div class="comment-content">
                                            <p>
                                                <?php echo nl2br($row['comment']); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <!-- .comment-body -->
                                    <ol class="children">					
                                        <?php
                                        $child_comment = get_reply_comments($recipe->rid, $row['id']);
                                        if (isset($child_comment) && !empty($child_comment)) {
                                            foreach ($child_comment as $child_key => $child_row) {
                                                ?>
                                                <li>
                                                    <div class="comment-body">
                                                        <footer class="comment-meta">
                                                            <div class="comment-author">
                                                                <?php
                                                                $child_comment_img = get_user_profile_image($child_row['profile_image']);
                                                                $child_date_timestamp = strtotime($child_row['created_on']);
                                                                $child_time = date('h:i:a', $child_date_timestamp);
                                                                $child_month = date('F', $child_date_timestamp);
                                                                $child_year = date('Y', $child_date_timestamp);
                                                                $child_day = date('j', $child_date_timestamp);
                                                                ?>
                                                                <img alt="" src="<?php echo $child_comment_img; ?>" class="avatar">
                                                            </div>
                                                            <div class="comment-metadata">
                                                                <a href="javascript:void(0)" rel="external nofollow" class="author"><?php echo $child_row['comment_by']; ?></a>
                                                                <time class="time"><?php echo $child_month . " " . $child_day . "," . $child_year . " at " . $child_time ?></time>
                                                                <div class="action">
                                                                    <?php if (isset($user_id) && $user_id != '') { ?>
                                                                        <span><a class="comment-reply-link" onclick="commentReply(this)" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>">Reply</a></span>
                                                                    <?php } else { ?>
                                                                        <span><a href="javascript:void(0)" class="openLoginModal">Reply</a></span>
                                                                    <?php } ?>											
                                                                </div>
                                                            </div>
                                                        </footer>
                                                        <div class="comment-content">
                                                            <p>
                                                                <?php echo $child_row['comment']; ?>
                                                            </p>
                                                        </div><!-- .comment-content -->
                                                    </div><!-- .comment-body -->
                                                </li><!-- #comment-## -->
                                                <?php
                                            }
                                        }
                                        ?>
                                    </ol><!-- .children-over-->
                                </li>
                                <!--user/parent comment-over -->
                                <?php
                            }
                        }
                        ?>
                    </ol>
                    <!-- / .comment-list-over -->

                    <!-- Comment box -->
                    <div class="ht-form-block col-xs-12">
                        <div class="text-center">
                            <h3 class="heading">LEAVE A COMMENT HERE</h3>
                            <p class="sub-heading">Your email address will not be published.</p>
                        </div>
                        <?php
                        $attribute = array("id" => "CommentForm", "name" => "CommentForm");
                        echo form_open("", $attribute);
                        ?>
                        <input type="hidden" name="recipe_id" value="<?php echo isset($recipe) && !empty($recipe) ? $recipe->rid : ''; ?>">
                        <input type="hidden" name="user_id" value="<?php echo isset($user_id) && $user_id != '' ? $user_id : ''; ?>">
                        <div class="form-group">
                            <label>Comment :<small class="text-red">*</small></label>
                            <textarea  id="comment" name="comment" cols="30" rows="10" onkeyup="onChangeComment(this)"  required></textarea>
                            <span class="comment_error error"></span>
                        </div>
                        <div class="form-group submit-group">
                            <?php if (isset($user_id) && $user_id != '') { ?>
                                <button type="button" disabled="true" onclick="commentSubmit(this)" id="commentButton"  class="ht-button view-more-button">
                                    <i class="fa fa-arrow-left"></i> SUBMIT <i class="fa fa-arrow-right"></i>
                                </button>
                            <?php } else { ?>
                                <button type="button" class="ht-button view-more-button openLoginModal">
                                    <i class="fa fa-arrow-left"></i> SUBMIT <i class="fa fa-arrow-right"></i>
                                </button>
                            <?php } ?>
                        </div>
                        <?php echo form_close(); ?>			
                    </div>
                    <!-- Comment box-over -->
                </div>
            </div>
            <div class="col-sm-1 col-xs-12"></div>
            <!-- / columns -->
        </div>
        <!-- / .row -->
    </div>
    <!-- / .container -->
</div>
<!-- / .hs-recipe -->
<script src="<?php echo base_url() . js_path; ?>module/recipe_detail.js" type="text/javascript"></script>
<?php include VIEWPATH . "front/templates/footer.php"; ?>
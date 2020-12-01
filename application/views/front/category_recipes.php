<?php include VIEWPATH . "front/templates/header.php"; ?>
<section class="ht-section hs-recipes grid height-home margin-top"  id="recent_recipe">
    <header class="hs-header">
        <div class="container">
            <h2 class="heading"><?php echo isset($category_name) && $category_name != '' ? ucfirst($category_name) : ''; ?> recipes</h2>
        </div>
    </header>
    <div class="hs-content">
        <div class="container">
            <div class="row message-row-height-home">
                <div class="isotope-grid">
                    <?php
                    if (isset($recipes) && !empty($recipes)) {
                        foreach ($recipes as $row) {
                            ?>
                            <div class="entry col-xs-12 col-sm-4 col-md-3">
                                <div class="entry-inner">
                                    <div class="entry-media">
                                        <?php
                                        $image_array = json_decode($row->recipes_image);
                                        if (isset($image_array) && count($image_array) > 0) {
                                            if ($image_array[0] != '' && file_exists(FCPATH . uploads_path . "recipes/" . $image_array[0])) {
                                                $img_url = base_url() . uploads_path . "recipes/" . $image_array[0];
                                            } else {
                                                $img_url = base_url() . NO_IMAGE_PATH;
                                            }
                                        }
                                        ?>
                                        <img src="<?php echo $img_url; ?>" alt=""/>
                                        <div class="entry-action">
                                            <div class="entry-action-inner">
                                                <span>
                                                    <a href="<?php echo base_url('recipe-detail/' . $row->rid); ?>">VIEW RECIPE</a>
                                                </span>
                                                <span>
                                                    <?php
                                                    if (isset($user_id) && $user_id != '') {
                                                        $bookmark = get_bookmark($row->rid, $user_id);
                                                        ?>
                                                        <a href="javascript:void(0)" onclick="bookmark(this)" class="bookmark-text" data-id="<?php echo $row->rid; ?>"> <?php echo isset($bookmark) && $bookmark != '' ? 'REMOVE BOOKMARK' : 'BOOKMARK RECIPE'; ?></a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0)" class="openLoginModal">BOOKMARK RECIPE</a>
                                                    <?php } ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-wrapper">
                                        <h3 class="entry-name">
                                            <a href="<?php echo base_url('recipe-detail/' . $row->rid); ?>">
                                                <?php
                                                $chars = strlen($row->recipes_heading);
                                                if ($chars > RECIPE_NAME_CHAR_LIMIT) {
                                                    echo ucfirst(substr($row->recipes_heading, 0, RECIPE_NAME_CHAR_LIMIT)) . '...';
                                                } else {
                                                    echo ucfirst($row->recipes_heading);
                                                }
                                                ?>
                                            </a>
                                        </h3>
                                        <p class="entry-author">By
                                            <?php
                                            $name_chars = strlen($row->created_by);
                                            if ($name_chars > CREATE_BY_CHAR_LIMIT) {
                                                echo ucfirst(substr($row->created_by, 0, CREATE_BY_CHAR_LIMIT)) . '...';
                                            } else {
                                                echo ucfirst($row->created_by);
                                            }
                                            ?>
                                        </p>
                                        <div class="entry-meta">
                                            <div class="foo-wrapper">
                                                <span class="meta-difficulty easy" title="">Easy</span>
                                                <span class="meta-time"><?php echo $row->recipes_time; ?>  Minutes</span>
                                            </div>
                                            <?php
                                            $rating = round(get_average_rating($row->rid), 1);
                                            $html = get_star($rating);
                                            ?>
                                            <div class="meta-rate">
                                                <?php echo $html; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.entry-inner -->
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='text-center vertical-center-home'>No recipe available</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.ht-products.grid -->
</section>
<!-- /.ht-section -->
<?php include VIEWPATH . "front/templates/footer.php"; ?>

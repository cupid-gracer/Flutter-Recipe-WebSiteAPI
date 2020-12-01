<?php include VIEWPATH . "front/templates/header.php"; ?>
<?php if ($search == '') { ?>
    <section class="hs-slider single flexslider basic carousel-mt"
             data-auto="true"
             data-effect="fade"
             data-navi="true"
             data-pager="true"
             data-slide-speed="5000"
             data-animation-speed="1000"
             style="overflow:hidden;"
             >
        <ul class="slides">
            <?php
            $carousel = get_carousel();
            if (isset($carousel) && !empty($carousel)) {
                foreach ($carousel as $row) {
                    if ($row['image'] != '' && file_exists(FCPATH . uploads_path . "carousel/" . $row['image'])) {
                        $carousel_img = base_url() . uploads_path . "carousel/" . $row['image'];
                    } else {
                        $carousel_img = base_url() . NO_IMAGE_PATH;
                    }
                    ?>
                    <li style="background-image: url('<?php echo $carousel_img; ?>')" >
                        <div class="overlay"></div>
                        <div class="slide-content-wrapper container">
                            <div class="slide-content">
                                <h3 class="entry-big"><?php echo $row['title']; ?></h3>
                                <p class="entry-small"><?php echo $row['sub_title']; ?></p>
                                <a class="entry-button" href="#recent-recipe">SEE ALL RECIPES</a>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    </section>
<?php } ?>
<section class="ht-section hs-recipes grid height-home <?php echo isset($search) && $search != '' ? 'margin-top' : ''; ?>"  id="recent-recipe">
    <header class="hs-header">
        <div class="container">
            <?php if ($search == '') { ?>
                <h2 class="heading">Recent recipes</h2>
            <?php } elseif ($search != '' && isset($recipes) && !empty($recipes)) { ?>
                <h2 class="heading">Search result</h2>
            <?php } ?>
        </div>
        <?php if ($search == '') { ?>
            <ul class="isotope-filter" data-target="#grid-1">
                <li class="<?php echo isset($cid) && $cid != '' ? '' : 'is-filtered'; ?>">
                    <a href="javascript:void(0)" data-filter="*">ALL</a>
                </li>
                <?php
                if (isset($category) && !empty($category)) {
                    $j = 0;
                    foreach ($category as $row) {
                        if ($j > 4) {
                            break;
                        }
                        ?>
                        <li class="<?php echo isset($cid) && $cid != '' && $cid == $row->cid ? 'is-filtered' : ''; ?>">
                            <a href="javascript:void(0)" class="text-uppercase" data-filter=".category-<?php echo $row->cid; ?>"><?php echo $row->category_name; ?></a>
                        </li>
                        <?php
                        $j++;
                    }
                }
                ?>
            </ul>
        <?php } ?>
    </header>
    <div class="hs-content">
        <div class="container">
            <div class="row message-row-height-home">
                <div class="isotope-grid" id="grid-1">
                    <?php
                    if (isset($recipes) && !empty($recipes)) {
                        $i = 0;
                        foreach ($recipes as $row) {
                            if ($i >= 40) {
                                break;
                            }
                            ?>
                            <div class="entry col-xs-12 col-sm-4 col-md-3 category-<?php echo $row->cid; ?>">
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
                                        <h3 class="entry-name" title="<?php echo $row->recipes_heading; ?>">
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
                            $i++;
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

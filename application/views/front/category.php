<?php include VIEWPATH . "front/templates/header.php" ?>
<div class="ht-page-header" style="background-image: url('<?php echo base_url() . front_img_path; ?>parallax/2.jpg')">
    <div class="overlay" style="background: rgba(0,0,0,.5)"></div>
    <div class="container">
        <div class="inner">
            <h2 class="heading">Categories</h2>
            <ol class="ht-breadcrumb">
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li>Categories</li>
            </ol>
        </div>
        <!-- / .inner -->
    </div>
    <!-- / .container -->
</div>
<!-- / .ht-page-header -->
<section class="category-page-wrap padding-top-80 padding-bottom-50">
    <div class="container minimum-height">
        <div class="row message-row-height">
            <?php
            if (isset($category) && !empty($category)) {
                foreach ($category as $row) {
                    if ($row['category_image'] != '' && file_exists(FCPATH . uploads_path . "category/" . $row['category_image'])) {
                        $img_url = base_url() . uploads_path . "category/" . $row['category_image'];
                    } else {
                        $img_url = base_url() . NO_CATEGORY_IMAGE;
                    }
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                        <a href="<?php echo base_url('category/' . $row['cid']); ?>">
                            <div class="category-box-layout1">
                                <div class="item-figure">
                                    <img src="<?php echo $img_url; ?>" alt="category" class="category_image">
                                </div>
                                <div class="item-content">
                                    <h3 class="item-title"><?php echo ucfirst($row['category_name']); ?></h3>
                                    <span class="sub-title"> <?php echo isset($row['total_recipes']) && $row['total_recipes'] > 0 ? $row['total_recipes'] : 'No'; ?> Recipes</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='text-center vertical-center'>No category available</div>";
            }
            ?>
        </div>
    </div>
</section>
<?php include VIEWPATH . "front/templates/footer.php" ?>
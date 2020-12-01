<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title Page-->
    <!-- <title>Your Recipes App</title> -->
    <title><?php echo get_site_name(); ?> | <?php echo isset($title) && $title != '' ? $title : ''; ?></title>

    <!-- Favicons-->
    <link rel="icon" href="<?php echo get_favicon() ?>" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="<?php echo get_favicon() ?>">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="<?php echo get_favicon() ?>">

    <!-- Custom fonts for this template-->
    <link href="<?php echo base_url() . vendor_path; ?>fontawesome-free/css/all.min.css" rel="stylesheet"
          type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">
    <script src="<?php echo base_url() . js_path; ?>jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() . js_path; ?>jquery.validate.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url() . js_path; ?>additional-methods.js" type="text/javascript"></script>

    <!-- Custom styles for this template-->
    <link href="<?php echo base_url() . css_path; ?>sb-admin-2.min.css" rel="stylesheet">
    <link href="<?php echo base_url() . css_path; ?>style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script>
        var base_url = '<?php echo base_url() ?>';
        var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        var NO_USER_PATH = '<?php echo base_url() . NO_USER_PATH;?>';
    </script>

</head>
<?php

$url_segment = trim($this->uri->segment(2));
$categoryArr = array("category", "category-save", 'add-category', 'edit-category');
$measurementArr = array("measurement", "measurement-save", 'add-measurement', 'edit-measurement');
$carouselArr = array("carousel", "carousel-save", 'add-carousel', 'edit-carousel');
$recipesArr = array("recipes", "recipes-save", 'add-recipes', 'edit-recipes', 'recipes-detail');
$site_settingArr = array("sitesetting", "sitesetting-save");
$email_settingArr = array("email-setting", "email-setting-action", "test-email-action");
$userArr = array("user", "user-save", 'add-user', 'edit-user');

if (isset($url_segment) && in_array($url_segment, $categoryArr)) {
    $category_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $recipesArr)) {
    $recipes_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $measurementArr)) {
    $measurement_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $site_settingArr)) {
    $site_setting_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $email_settingArr)) {
    $email_setting_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $carouselArr)) {
    $carousel_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, array("social-login"))) {
    $social_active = "active";
} elseif (isset($url_segment) && in_array($url_segment, $userArr)) {
    $user_active = "active";
} else {
    $dashboard_active = "active";
}
$background_color = get_header_color();

?>
<body id="page-top">
<div id="loader"></div>
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
        style="background:<?php echo isset($background_color) ? $background_color : '#232323'; ?>">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center site-logo"
           href="<?php echo base_url('admin/dashboard'); ?>">
            <div class="sidebar-brand-text mx-auto"><img src="<?php echo get_logo(); ?>"
                                                         style="object-fit: contain !important;" width="100px"
                                                         height="61px" alt="<?php echo get_site_name(); ?>"/></div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?php echo isset($dashboard_active) ? $dashboard_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Interface
        </div>
        <li class="nav-item <?php echo isset($carousel_active) ? $carousel_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/carousel'); ?>">
                <i class="fas fa-fw fa-sliders-h"></i>
                <span>Carousel</span>
            </a>
        </li>
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item <?php echo isset($category_active) ? $category_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/category'); ?>">
                <i class="fas fa-fw fa-table"></i>
                <span>Category</span>
            </a>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item <?php echo isset($recipes_active) ? $recipes_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/recipes'); ?>">
                <i class="fas fa-fw fa-utensils"></i>
                <span>Recipes</span>
            </a>
        </li>
        <li class="nav-item <?php echo isset($measurement_active) ? $measurement_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/measurement'); ?>">
                <i class="fas fa-fw fa-utensils"></i>
                <span>Measurements</span>
            </a>
        </li>
        <li class="nav-item <?php echo isset($user_active) ? $user_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/user'); ?>">
                <i class="fas fa-fw fa-user"></i>
                <span>Users</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Setting
        </div>
        <!-- Nav Item - Charts -->
        <li class="nav-item <?php echo isset($site_setting_active) ? $site_setting_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/sitesetting'); ?>">
                <i class="fas fa-fw fa-cog"></i>
                <span>Site setting</span>
            </a>
        </li>
        <li class="nav-item <?php echo isset($social_active) ? $social_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/social-login'); ?>">
                <i class="fas fa-fw fa-info-circle"></i>
                <span>Social Login</span>
            </a>
        </li>
        <li class="nav-item <?php echo isset($email_setting_active) ? $email_setting_active : ""; ?>">
            <a class="nav-link" href="<?php echo base_url('admin/email-setting'); ?>">
                <i class="fas fa-fw fa-envelope"></i>
                <span>Email setting</span>
            </a>
        </li>
        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo base_url('admin/logout'); ?>">
                <i class="fas fa-fw fa-power-off"></i>
                <span>Logout</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <?php $admin = get_AdminDetail($this->session->userdata('ADMIN_ID')); ?>
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle" id="userDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin['firstname'] . " " . $admin['lastname']; ?></span>
                            <?php if ($admin['profile_image'] != '' && file_exists(FCPATH . uploads_path . "profile/" . $admin['profile_image'])) {
                                $profile_image = base_url() . uploads_path . "profile/" . $admin['profile_image'];
                            } else {
                                $profile_image = base_url() . NO_USER_PATH;
                            } ?>
                            <img class="img-profile rounded-circle" src="<?php echo $profile_image ?>">
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                             aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('admin/admin-setting'); ?>">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('admin/change-password'); ?>">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Change password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal"
                               data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

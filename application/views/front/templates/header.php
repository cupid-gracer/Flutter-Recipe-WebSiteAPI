<!DOCTYPE html>
<head>
    <!-- Basic need -->
    <title><?php echo get_site_name(); ?> | <?php echo isset($title) && $title != '' ? $title : ''; ?></title>
    <meta charset="UTF-8">
    <!-- og tag start-->
    <?php
    $image_array = isset($recipe) ? json_decode($recipe->recipes_image) : '';
    if (isset($image_array) && !empty($image_array) && file_exists(FCPATH . uploads_path . "recipes/" . $image_array[0])) {
        $og_img_url = base_url() . uploads_path . "recipes/" . $image_array[0];
    } else {
        $og_img_url = "";
    }
    $og_recipe_id = isset($recipe->rid) && $recipe->rid != '' ? $recipe->rid : '';
    $og_title = isset($recipe->recipes_heading) && $recipe->recipes_heading != '' ? $recipe->recipes_heading : '';
    $og_category = isset($recipe->category_name) && $recipe->category_name != '' ? $recipe->category_name : '';
    $og_url = isset($og_recipe_id) && $og_recipe_id != '' ? base_url() . 'recipe-detail/' . $og_recipe_id : '';
    ?>
    <meta property="og:title" content="<?php echo isset($og_title) && $og_title != '' ? $og_title : $og_category; ?>" />
    <meta property="og:category" content="<?php echo isset($og_category) ? $og_category : ''; ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:site_name" content="<?php echo get_site_name(); ?>" />
    <meta property="og:url" content="<?php echo $og_url ?>" />
    <meta property="og:image" content="<?php echo isset($og_img_url) ? $og_img_url : ''; ?>"/>
    <link rel="shortcut icon" href="<?php echo get_favicon(); ?>">

    <!-- Mobile specific meta -->
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="format-detection" content="telephone-no">

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:300,400,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Dosis:700' rel='stylesheet' type='text/css'>

    <!-- CSS files -->
    <link rel="stylesheet" href="<?php echo base_url() . front_css_path; ?>plugins.css">
    <link rel="stylesheet" href="<?php echo base_url() . front_css_path; ?>style.css">
    <link rel="stylesheet" href="<?php echo base_url() . front_css_path; ?>mystyle.css">

    <!-- JS files -->
    <?php
    $site_data = get_site_data();
    if (isset($site_data['head_script']) && $site_data['head_script'] != '') {
        echo $site_data['head_script'];
    }
    ?>
    <script src="<?php echo base_url() . front_js_path; ?>jquery.js"></script>
    <script type="text/javascript" src="<?php echo base_url() . js_path; ?>jquery.validate.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js" type="text/javascript"></script>
    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/6.4.1/firebase-app.js"></script>
    <!-- facebook developer  -->
    <?php if ((isset($get_setting['is_facebook_login']) && $get_setting['is_facebook_login'] == 'Y')): ?>
        <script>
            window.fbAsyncInit = function () {
                FB.init({
                    appId: '',
                    xfbml: true,
                    version: 'v2.6'
                });
            };

            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    <?php endif; ?>
    <!-- fitrebase  -->
    <script src="https://www.gstatic.com/firebasejs/4.1.3/firebase.js"></script>
    <script>
        var base_url = '<?php echo base_url() ?>';
        var csrf_token_name = '<?php echo $this->security->get_csrf_hash(); ?>';
        var user_idval = '<?php echo $this->session->userdata('USER_ID'); ?>';

        var apiKey = "<?php echo isset($site_data['apikey']) ? $site_data['apikey'] : ""; ?>";
        var authDomain = "<?php echo isset($site_data['authdomain']) ? $site_data['authdomain'] : ""; ?>";
        var databaseURL = "<?php echo isset($site_data['databaseurl']) ? $site_data['databaseurl'] : ""; ?>";
        var storageBucket = "<?php echo isset($site_data['storagebucket']) ? $site_data['storagebucket'] : ""; ?>";
    </script>
</head>
<?php
$search = $this->input->get('search');
$user_id = $this->session->userdata('USER_ID');

$url_segment = trim($this->uri->segment(1));
$categoryArr = array("categories");
$profileArr = array("profile", "register-action");
$change_passwordArr = array("change-password", "change-password-action");
$loginArr = array("login", "login-action", "forgot-password", "forgot-password-action");
$registerArr = array("register", "register-action");
$contactArr = array("contact", "contact-action");
$bookmarkArr = array("my-bookmark");

if (isset($url_segment) && in_array($url_segment, $categoryArr)) {
    $category_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $profileArr)) {
    $profile_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $profileArr)) {
    $profile_setting_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $change_passwordArr)) {
    $change_password_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $loginArr)) {
    $login_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $registerArr)) {
    $register_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $contactArr)) {
    $contact_active = "current-menu-item";
} elseif (isset($url_segment) && in_array($url_segment, $bookmarkArr)) {
    $bookmark_active = "current-menu-item";
} else {
    $home_active = "current-menu-item";
}

$user_array = array('login', 'register', 'register-action', 'login-action', 'change-password', 'forgot-password', 'change-password-action', 'forgot-password-action', 'profile', 'contact', 'contact-save', 'modal-login-action', 'my-bookmark');
$background_color = get_header_color();
?>
<body class="smooth-scroll">
    <div id="loader"></div>
    <div class="ht-page-wrapper">
        <!-- BEGIN | Header -->
        <header id="ht-header" class="">
            <div class="mobile-control-toggle">
                <div class="container">
                    <button type="button" class="mobile-nav-toggle" data-target="#menu-list">
                        <span class="sr-only">Toggle mobile menu</span>
                        <span class="icon-bar icon-bar-1"></span>
                        <span class="icon-bar icon-bar-2"></span>
                        <span class="icon-bar icon-bar-3"></span>
                    </button>
                </div>
            </div>
            <!-- ./mobile-panels-control -->
            <div class="mobile-nav">
                <?php if (!in_array($url_segment, $user_array)) { ?>
                    <form class="ht-search-form">
                        <input type="text" name="search" autocomplete="off" id="search" placeholder="Type keyword ..." value="<?php echo isset($search) && $search != '' ? $search : ''; ?>"/>
                        <button type="submit" class="ht-search-form-toggle">
                            <span class="sr-only">Toggle search</span>
                            <i class="fa fa-search"></i>
                        </button>
                    </form>
                <?php } ?>
                <ul>
                    <?php
                    if (isset($user_id) && $user_id != '') {
                        $admin = get_AdminDetail($user_id);
                        $profile_image = get_user_profile_image($admin['profile_image']);
                        ?>
                        <li class="menu-item-has-children profile-img-mobile">
                            <a href="javascript:void(0)">
                                <img class="img-profile rounded-circle" src="<?php echo $profile_image ?>"> <?php echo ucfirst($admin['firstname']) . " " . ucfirst($admin['lastname']); ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="<?php echo base_url(); ?>" class="<?php echo isset($home_active) ? $home_active : ''; ?>"><i class="fa fa-home mr-2"></i> Home</a>
                    </li>
                    <li>
                        <a class="<?php echo isset($category_active) ? $category_active : ''; ?>" href="<?php echo base_url('categories'); ?>" ><i class="fa fa-list mr-2"></i>Categories</a>
                    </li>
                    <li>
                        <a class="<?php echo isset($bookmark_active) ? $bookmark_active : ''; ?>" href="<?php echo base_url('my-bookmark'); ?>" ><i class="fa fa-bookmark mr-2"></i>Bookmark</a>
                    </li>
                    <li>
                        <a class="<?php echo isset($contact_active) ? $contact_active : ''; ?>" href="<?php echo base_url('contact'); ?>"><i class="fa fa-users mr-2"></i>Contact</a>
                    </li>
                    <?php if (isset($user_id) && $user_id != '') { ?>
                        <li>
                            <a class="<?php echo isset($profile_active) ? $profile_active : ''; ?>" href="<?php echo base_url('profile'); ?>"><i class="fa fa-user mr-2"></i>Profile</a>
                        </li>
                        <?php if ($admin['register_type'] == GENERAL) { ?>
                            <li>
                                <a class="<?php echo isset($change_password_active) ? $change_password_active : ''; ?>" href="<?php echo base_url('change-password'); ?>"><i class="fa fa-cog mr-2"></i>Change password</a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url('logout'); ?>"><i class="fa fa-power-off mr-2"></i>Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="<?php echo isset($login_active) ? $login_active : ''; ?>">
                            <a href="<?php echo base_url('login'); ?>"><i class="fa fa-sign-in mr-2"></i>Login</a>
                        </li>
                        <li class="<?php echo isset($register_active) ? $register_active : ''; ?>">
                            <a href="<?php echo base_url('register'); ?>"><i class="fa  fa-plus-square-o mr-2"></i>Register</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- / .mobile-nav -->
            <!-- available classes: logo-center, logo-left -->
            <div class="ht-main-navbar logo-left sticky-nav scroll-up-nav" style="background:<?php echo isset($background_color) ? $background_color : '#232323'; ?>">
                <div class="container">
                    <div class="inner">
                        <div id="ht-logo" class="ht-main-nav-wrapper2">
                            <a href="<?php echo base_url(); ?>">
                                <img src="<?php echo get_logo(); ?>" alt="logo" >
                            </a>
                        </div>
                        <!-- / #logo -->
                        <div class="ht-main-nav-wrapper">
                            <nav id="ht-main-nav">
                                <ul>
                                    <li class="<?php echo isset($home_active) ? $home_active : ''; ?>">
                                        <a href="<?php echo base_url(); ?>">HOME</a>
                                    </li>
                                </ul>
                                <ul>
                                    <li class="<?php echo isset($category_active) ? $category_active : ''; ?>" >
                                        <a href="<?php echo base_url('categories'); ?>">CATEGORIES</a>
                                    </li>
                                    <?php if (isset($user_id) && $user_id != '') { ?>
                                        <li class="<?php echo isset($bookmark_active) ? $bookmark_active : ''; ?>" >
                                            <a href="<?php echo base_url('my-bookmark'); ?>">BOOKMARK</a>
                                        </li>
                                    <?php } ?>
                                    <li class="<?php echo isset($contact_active) ? $contact_active : ''; ?>" >
                                        <a href="<?php echo base_url('contact'); ?>">CONTACT</a>
                                    </li>
                                    <?php
                                    if (isset($user_id) && $user_id != '') {
                                        $admin = get_AdminDetail($user_id);
                                        $profile_image = get_user_profile_image($admin['profile_image']);
                                        ?>
                                        <li class="menu-item-has-children dropdown-menu <?php echo isset($profile_active) ? $profile_active : ''; ?><?php echo isset($change_password_active) ? $change_password_active : ''; ?>">
                                            <a href="javascript:void(0)">
                                                <span class="mr-2 user-name"><?php echo ucfirst($admin['firstname']) . " " . ucfirst($admin['lastname']); ?></span>
                                                <img class="img-profile rounded-circle" src="<?php echo $profile_image ?>">
                                            </a>
                                            <ul>
                                                <li class="<?php echo isset($profile_active) ? $profile_active : ''; ?>">
                                                    <a href="<?php echo base_url('profile'); ?>"><i class="fa fa-user mr-2"></i>Profile</a>
                                                </li>
                                                <?php if ($admin['register_type'] == GENERAL) { ?>
                                                    <li class="<?php echo isset($change_password_active) ? $change_password_active : ''; ?>">
                                                        <a href="<?php echo base_url('change-password'); ?>"><i class="fa fa-cog mr-2"></i>Change password</a>
                                                    </li>
                                                <?php } ?>
                                                <li>
                                                    <a href="<?php echo base_url('logout'); ?>"><i class="fa fa-power-off mr-2"></i>Logout</a>
                                                </li>
                                            </ul>
                                        </li>
                                    <?php } else { ?>
                                        <li class="<?php echo isset($login_active) ? $login_active : ''; ?>">
                                            <a href="<?php echo base_url('login'); ?>">LOGIN</a>
                                        </li>
                                        <li class="<?php echo isset($register_active) ? $register_active : ''; ?>">
                                            <a href="<?php echo base_url('register'); ?>">REGISTER</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                            <!-- / #ht-main-nav -->
                        </div>
                        <!-- / .pull-right -->
                    </div>
                    <!-- / .inner -->
                </div>
                <!-- / .container -->
                <?php if (!in_array($url_segment, $user_array)) { ?>
                    <button type="button" class="search-toggle" data-toggle="modal" data-target="#ht-search-form">
                        <span class="inner">
                            <i class="fa fa-search"></i>
                        </span>
                    </button>
                    <!-- ./ button#ht-search-form -->
                <?php } ?>
            </div>
            <!-- / .ht-container -->
        </header>
        <!-- END | Header -->
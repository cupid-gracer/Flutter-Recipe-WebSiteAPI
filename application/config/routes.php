<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'front';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// admin content
$route['admin'] = 'dashboard';
$route['admin/dashboard'] = 'dashboard';
$route['admin/login'] = "content/login";
$route['admin/logout'] = "content/logout";
$route['admin/login-action'] = "content/login_action";
$route['admin/change-password'] = "content/change_password";
$route['admin/change-password-action'] = "content/change_password_action";
$route['admin/forgot-password'] = "content/forgot_password";
$route['admin/forgot-password-action'] = 'content/forgot_password_action';
$route['admin/reset-password/(:any)'] = 'content/reset_password_user/$1';
$route['admin/reset-password-action'] = 'content/reset_password_action';

// carousel
$route['admin/carousel'] = 'carousel';
$route['admin/add-carousel'] = "carousel/add_carousel";
$route['admin/carousel-save'] = "carousel/carousel_save";
$route['admin/edit-carousel/(:any)'] = "carousel/edit_carousel/$1";
$route['admin/delete-carousel/(:num)'] = "carousel/delete_carousel/$1";
$route['admin/check-carousel-title'] = "carousel/check_carousel_title";

// category
$route['admin/category'] = 'category';
$route['admin/add-category'] = "category/add_category";
$route['admin/category-save'] = "category/category_save";
$route['admin/edit-category/(:any)'] = "category/edit_category/$1";
$route['admin/delete-category/(:num)'] = "category/delete_category/$1";
$route['admin/delete-category-image/(:num)'] = "category/delete_category_image/$1";
$route['admin/check-category-name'] = "category/check_category_name";

// measurement
$route['admin/measurement'] = 'measurement';
$route['admin/add-measurement'] = "measurement/add_measurement";
$route['admin/measurement-save'] = "measurement/measurement_save";
$route['admin/edit-measurement/(:any)'] = "measurement/edit_measurement/$1";
$route['admin/delete-measurement/(:num)'] = "measurement/delete_measurement/$1";
$route['admin/delete-measurement-image/(:num)'] = "measurement/delete_measurement_image/$1";
$route['admin/check-measurement-name'] = "measurement/check_measurement_name";

// recipes
$route['admin/recipes'] = 'recipes';
$route['admin/add-recipes'] = "recipes/add_recipes";
$route['admin/recipes-save'] = "recipes/recipes_save";
$route['admin/edit-recipes/(:any)'] = "recipes/edit_recipes/$1";
$route['admin/delete-recipes/(:num)'] = "recipes/delete_recipes/$1";
$route['admin/delete-recipe-image'] = "recipes/delete_recipe_image";
$route['admin/settodayrecipe'] = "recipes/settodayrecipe";
$route['admin/deltodayrecipe'] = "recipes/deltodayrecipe";


// customer list
$route['admin/user'] = 'customer';
$route['admin/add-user'] = "customer/add_user";
$route['admin/user-save'] = "customer/user_save";
$route['admin/edit-user/(:any)'] = "customer/edit_user/$1";
$route['admin/delete-user/(:num)'] = "customer/delete_user/$1";
$route['admin/delete-user-image/(:num)'] = "customer/delete_user_image/$1";

// admin-setting
$route['admin/admin-setting'] = "admin_setting";
$route['admin/profile-save'] = "admin_setting/update_profile";
$route['admin/delete-profile-image/(:num)'] = 'admin_setting/delete_profile_image/$1';

// sitesetting
$route['admin/sitesetting'] = "sitesetting";
$route['admin/sitesetting-save'] = "sitesetting/sitesetting_save";
$route['admin/delete-favicon-image/(:num)'] = "sitesetting/delete_favicon_image/$1";

// email setting
$route['admin/email-setting'] = "sitesetting/email_setting";
$route['admin/social-login'] = "sitesetting/social_login";
$route['admin/social-login-credential'] = "sitesetting/social_login_credential";
$route['admin/email-setting-action'] = "sitesetting/email_setting_save";
$route['admin/test-email'] = "sitesetting/test_email";
$route['admin/test-email-action'] = "sitesetting/test_email_save";


// front side

$route['front'] = "front";
$route['recipe-detail/(:any)'] = "front/recipe_detail/$1";
$route['categories'] = "front/category";
$route['category/(:any)'] = 'front/category_recipes/$1';
$route['rating'] = "front/user_rating";
$route['comment-action'] = "front/comment_save";
$route['reply-comment-action'] = "front/reply_comment_save";
$route['contact'] = "front/contact";
$route['contact-action'] = "front/contact_save";
$route['bookmark-save'] = "front/bookmark_save";
$route['my-bookmark'] = "front/bookmark_recipe";


// user route

// content
$route['login'] = "user_content/login";
$route['logout'] = "user_content/logout";
$route['login-action'] = "user_content/login_action";
$route['forgot-password'] = "user_content/forgot_password";
$route['forgot-password-action'] = 'user_content/forgot_password_action';
$route['reset-password/(:any)'] = 'user_content/reset_password/$1';
$route['reset-password-action'] = 'user_content/reset_password_action';

//  login modal
$route['modal-login-action'] = "user_content/modal_login_action";
$route['change-password'] = "user_content/change_password";
$route['change-password-action'] = "user_content/change_password_action";

// profile
$route['register'] = "user/register";
$route['register-action'] = "user/register_save";
$route['profile'] = "user/profile";
$route['account-delete'] = "user/delete_account";
$route['delete-user-profile-image/(:num)'] = "user/delete_profile_image/$1";
$route['check-user-email'] = "user/check_user_email";
$route['verify-email/(:any)/(:any)'] = "user/verify_email/$1/$2";
$route['resend-verify-link/(:any)'] = "user/resend_verify_link/$1";
$route['social-login'] = "user/social_login";

// API routes
$route['single-sign-on'] = "api/recipes/login";
$route['sign-in'] = "api/recipes/login";
$route['sign-up'] = "api/recipes/register";
$route['recipe'] = "api/recipes/recipes";
$route['get-category'] = "api/recipes/category";
$route['rate'] = "api/recipes/rate";
$route['comment'] = "api/recipes/comment";
$route['get-comment'] = "api/recipes/comments";
$route['update-user-detail'] = "api/recipes/update_profile";
$route['bookmark'] = "api/recipes/bookmark";
$route['password-change'] = "api/recipes/change_password";
$route['password-forgot'] = "api/recipes/forgot_password";
$route['delete-account'] = "api/recipes/account";
$route['get-setting'] = "api/recipes/get_setting";


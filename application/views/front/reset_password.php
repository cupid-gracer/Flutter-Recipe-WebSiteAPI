<!DOCTYPE html>
<html lang="zxx" class="js">
    <!-- Mirrored from demo.themenio.com/tokenwiz/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 04 Jun 2019 13:24:45 GMT -->

    <head>
        <!-- Basic need -->
        <title><?php echo get_site_name(); ?> | <?php echo isset($title) ? $title : ''; ?></title>
        <meta charset="UTF-8">
        <!-- og tag start-->
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
        <script src="<?php echo base_url() . front_js_path; ?>jquery.js"></script>
        <script type="text/javascript" src="<?php echo base_url() . js_path; ?>jquery.validate.min.js"></script>
        <link href="<?php echo base_url() . css_path; ?>login.css" rel="stylesheet"/>
    <body>
        <div id="loader"></div>
        <div class="ht-page-wrapper">  
            <section class="ht-section hs-recipes grid minimum-height-home">
                <div class="hs-content">
                    <div class="container">
                        <div class="row message-row-height-home">
                            <div class="register-form col-md-offset-3 col-md-6">
                                <?php
                                $attribute = array("method" => "post", "id" => "resetPasswordFrom", "name" => "resetPasswordFrom");
                                echo form_open('reset-password-action', $attribute);
                                ?>  
                                <div class="text-center">
                                    <a href="<?php echo base_url(); ?>">
                                        <img src="<?php echo get_logo(); ?>"  alt="logo" >
                                    </a>
                                </div>
                                <div class="reset-password">
                                    <h2>Reset password</h2>
                                </div>  
                                <?php $this->load->view("message"); ?>  
                                <input type="hidden" name="uniq_id" id="uniq_id" value="<?php echo isset($uniq_id) ? $uniq_id : ''; ?>">    
                                <p>
                                    <label>Password</label>
                                    <input type="password"  autocomplete="off" id="password" name="password" placeholder="Password" class="input-bordered">
                                    <?php echo form_error('password'); ?>
                                </p>
                                <p>
                                    <label>Confirm password</label>
                                    <input type="password"  autocomplete="off" id="conf_password" name="conf_password" placeholder="Confirm password" class="input-bordered">
                                    <?php echo form_error('conf_password'); ?>
                                </p>
                                <p>
                                    <input type="submit" value="Save" id="rest-password" class="button-primary">
                                </p>    
                                <?php echo form_close(); ?>    
                            </div>
                        </div>
                    </div><!--./container-->
                </div><!--./hs-content-->
            </section>
        </div>
        <script src="<?php echo base_url() . js_path; ?>module/front.js" type="text/javascript"></script>
    </body>
</html>
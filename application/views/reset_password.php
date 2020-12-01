<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?php echo get_site_name(); ?> | <?php echo isset($title) && $title != '' ? $title : ''; ?></title>
        <!-- Favicons-->
        <link rel="icon" href="<?php echo get_favicon() ?>" sizes="32x32">
        <!-- Favicons-->
        <link rel="apple-touch-icon-precomposed" href="<?php echo get_favicon() ?>">
        <!-- For iPhone -->
        <meta name="msapplication-TileColor" content="#00bcd4">
        <meta name="msapplication-TileImage" content="<?php echo get_favicon() ?>">
        <!-- For Windows Phone -->
        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url() . vendor_path; ?>fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <script src="<?php echo base_url() . vendor_path; ?>jquery/jquery.min.js"></script>

        <script type="text/javascript" src="<?php echo base_url() . js_path; ?>jquery.validate.min.js"></script>

        <!-- Custom styles for this template-->
        <link href="<?php echo base_url() . css_path; ?>sb-admin-2.min.css" rel="stylesheet">
        <link href="<?php echo base_url() . css_path; ?>login.css" rel="stylesheet">
        <?php $background_color = get_header_color(); ?>
    </head>

    <body style="background:<?php echo isset($background_color) ? $background_color : '#232323'; ?>">
        <div id="loader"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="p-md-5 p-2">
                                        <div class="text-center mb-4">
                                            <img src="<?php echo get_logo() ?>" style="object-fit: contain !important;" width="100px" height="61px">
                                        </div>
                                        <div class="text-center">
                                            <h2>Reset password</h2>
                                        </div>  
                                        <?php $this->load->view('message'); ?>
                                        <?php
                                        $attributes = array('id' => 'confPassForm', 'name' => 'confPassForm', 'method' => "post", "class" => "user");
                                        echo form_open('admin/reset-password-action', $attributes);
                                        ?>
                                        <input type="hidden" name="uniq_id" id="uniq_id" value="<?php echo isset($uniq_id) ? $uniq_id : ''; ?>">    
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" autocomplete="off" id="password" name="password"  placeholder="Password...">
                                            <?php echo form_error('password'); ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" autocomplete="off" id="conf_password" name="conf_password"  placeholder="Confirm password...">
                                            <?php echo form_error('conf_password'); ?>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Save	
                                        </button>
                                        <?php echo form_close() ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="<?php echo base_url() . vendor_path; ?>bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?php echo base_url() . vendor_path; ?>jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?php echo base_url() . js_path; ?>sb-admin-2.min.js"></script>
        <script src="<?php echo base_url() . js_path; ?>module/global.js" type="text/javascript"></script>
    </body>
</html>
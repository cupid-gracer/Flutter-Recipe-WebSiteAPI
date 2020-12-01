<?php
include VIEWPATH . "front/templates/header.php";
$get_setting = get_setting();
?>
<section class="ht-section hs-recipes grid minimum-height-login">
    <div class="hs-content">
        <div class="container">
            <div class="row message-row-height-home">
                <div class="login-form col-md-offset-3 col-md-6">
                    <h2>Login</h2>
                    <?php if (isset($link_expire) && $link_expire != '') { ?>
                        <div class="alert alert-danger">
                            <P><?php echo isset($verification_message) ? $verification_message : ''; ?> <a href="<?php echo base_url('resend-verify-link/' . $link_expire); ?>" style="color:blue">Resend verification link?</a></P>
                        </div>
                    <?php } ?>
                    <?php
                    $attribute = array("name" => "LoginForm", "id" => "LoginForm");
                    echo form_open('login-action', $attribute);
                    ?>
                    <?php $this->load->view('message'); ?>

                    <div class="catch-message"></div>
                    <p class="login-username">
                        <label>Email</label>
                        <input type="email" autocomplete="off" name="email" id="email" placeholder="Email" value="<?php echo $this->input->post("email"); ?>" class="input">
                        <?php echo form_error('email'); ?>
                    </p>
                    <p class="login-password">
                        <label>Password</label>
                        <input type="password" autocomplete="off" name="password" id="password" placeholder="Password" class="input">
                        <?php echo form_error('password'); ?>
                    </p>
                    <p class="login-submit">
                        <span class="forgot-password"><a href="<?php echo base_url('forgot-password'); ?>">Forgot password?</a></span>
                    </p>
                    <p>
                        <button type="submit" name="wp-submit" id="wp-submit" class="button-primary btn-block">Log In</button>
                    </p>
                    <?php if ((isset($get_setting['is_facebook_login']) && $get_setting['is_facebook_login'] == 'Y') || (isset($get_setting['is_google_login']) && $get_setting['is_google_login'] == 'Y')): ?>
                        <div class="single-sign-on">
                            <?php if (isset($get_setting['is_facebook_login']) && $get_setting['is_facebook_login'] == 'Y'): ?>
                                <p><button type="button" onclick="facebookSignin(this)" class="button-secondary btn-block"><i class="fa fa-facebook mr-2"></i>Login with Facebook</button></p>
                            <?php endif; ?>

                            <?php if (isset($get_setting['is_google_login']) && $get_setting['is_google_login'] == 'Y'): ?>
                                <p><button type="button" onclick="googleSignin(this)" class="button-info btn-block"><i class="fa fa-google mr-2"></i>Login with Google</button></p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <p class="text-center">
                        <span class="text-center">If yo don't have account ? <a href="<?php echo base_url('register'); ?>">Register here!</a></span>
                    </p>
                    <?php echo form_close(); ?>
                </div>
            </div><!--./row-->
        </div><!--./container-->
    </div><!--./hs-content-->
</section>

<?php include VIEWPATH . "front/templates/footer.php"; ?>
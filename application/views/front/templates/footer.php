<div id="bookmark_message"></div>
<footer id="ht-footer" style="background:<?php echo isset($background_color) ? $background_color : '#232323'; ?>">
    <div class="container">
        <p class="copyright">COPYRIGHT © <?php echo date('Y'); ?> <?php echo get_site_name(); ?></p>
        <ul class="footer-nav">
            <li><a href="<?php echo base_url(); ?>">HOME</a></li>
            <li><a href="<?php echo base_url('categories'); ?>">CATEGORY</a></li>
            <li><a href="<?php echo base_url('contact'); ?>">CONTACT</a></li>
        </ul>
    </div>
</footer>
<!-- Modal -->
<div class="modal fade" id="ht-search-form" tabindex="-1" role="dialog" aria-labelledby="ht-search-form" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form>
                    <input type="text" id="search" name="search" autocomplete="off" placeholder="Type keyword ..." autofocus value="<?php echo isset($search) && $search != '' ? $search : ''; ?>"/>
                    <button class="search-button" type="submit">
                        <span class="sr-only">Toggle search</span>
                        <i class="fa fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / .hs-footer-widget -->
<!-- login modal -->
<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="LoginModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Log in</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php
                $attribute = array("name" => "ModalLoginForm", "id" => "ModalLoginForm");
                echo form_open('', $attribute);
                ?>
                <div class="catch-message"></div>
                <p class="login-username">
                    <label>Email</label>
                    <input autocomplete="off" type="email" name="email" id="email" placeholder="Email" class="input">
                    <?php echo form_error('email'); ?>
                </p>
                <p class="login-password">
                    <label>Password</label>
                    <input autocomplete="off" type="password" name="password" id="password" placeholder="Password" class="input">
                    <?php echo form_error('password'); ?>
                </p>
                <p class="login-submit">
                    <span class="forgot-password"><a href="<?php echo base_url('forgot-password'); ?>">Forgot password?</a></span>
                </p>
                <p>
                    <button type="button" name="wp-submit" id="login-modal-button" class="button-primary btn-block">Log In</button>
                </p>
                <div class="single-sign-on">
                    <?php if ((isset($get_setting['is_facebook_login']) && $get_setting['is_facebook_login'] == 'Y')): ?>
                        <p>
                            <button type="button" onclick="facebookSignin(this)"  class="button-secondary btn-block modal-google-login"><i class="fa fa-facebook mr-2"></i>Login with Facebook</button>
                        </p>
                    <?php endif; ?>

                    <?php if ((isset($get_setting['is_google_login']) && $get_setting['is_google_login'] == 'Y')): ?>
                        <p>
                            <button type="button" onclick="googleSignin(this)"  class="button-info btn-block modal-google-login"><i class="fa fa-google mr-2"></i>Login with Google</button>
                        </p>
                    <?php endif; ?>
                </div>
                <p class="text-center">
                    <span class="text-center">If you don't have account ? <a href="<?php echo base_url('register'); ?>">Register here!</a></span>
                </p>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<!-- thankful modal when give review -->
<div class="modal fade" id="RatingDoneModal" tabindex="-1" role="dialog" aria-labelledby="RatingDoneModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Success!!</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center">
                <div class="done_icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <span id="thanks_star"></span>
                <h2 id="thanks_msg"></h2>
            </div>
        </div>
    </div>
</div>
<!-- ./ht-page-wrapper -->

<!-- Account delete modal  -->
<div class="modal fade" id="AccountDeleteModal" tabindex="-1" role="dialog" aria-labelledby="AccountDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Delete account</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="login-username">
                    Are you sure want to delete account?
                </p>
                <p class="login-submit">
                    <button type="button" name="wp-submit"  class="button-primary">
                        <a href="<?php echo base_url('account-delete'); ?>">Confirm</a>
                    </button>
                    <button type="button" name="wp-submit" data-dismiss="modal" class="button-secondary">Cancel</button>
                </p>
            </div>
        </div>
    </div>
</div>
<?php if ((isset($get_setting['is_facebook_login']) && $get_setting['is_facebook_login'] == 'Y') || (isset($get_setting['is_google_login']) && $get_setting['is_google_login'] == 'Y')): ?>
    <script src="<?php echo base_url() . front_js_path; ?>single_sign_on.js"></script>
<?php endif; ?>
<script src="<?php echo base_url() . front_js_path; ?>plugins.js"></script>
<script src="<?php echo base_url() . front_js_path; ?>custom.js"></script>
<script src="<?php echo base_url() . js_path; ?>module/front.js" type="text/javascript"></script>
</body>
</html>
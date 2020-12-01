<?php
include VIEWPATH . "front/templates/header.php";
?>
<section class="ht-section hs-recipes grid minimum-height-login">
    <div class="hs-content">
        <div class="container">
            <div class="row message-row-height-home">
                <div class="register-form col-md-offset-3 col-md-6">
                    <div class="title">
                        <h2><?php echo $title; ?></h2>
                    </div>
                    <?php
                    $attribute = array("name" => "forgotPassForm", "id" => "forgotPassForm");
                    echo form_open("forgot-password-action", $attribute);
                    ?>	  
                    <div class="reset-password">
                        <span>If you forgot your password, well, then we’ll email you instructions to reset your password.</span>
                    </div>  
                    <?php $this->load->view("message"); ?>      
                    <p>
                        <label>Email</label>
                        <input  autocomplete="off" type="email" name="email" id="email" placeholder="Email" class="input">
                        <?php echo form_error('email'); ?>
                    </p>
                    <p>
                        <input type="submit" value="Send Reset Link" id="register" class="button-primary">
                        <span class="register-here"><a href="<?php echo base_url('login'); ?>">Back to login!</a></span>
                    </p>    
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div><!--./container-->
    </div><!--./hs-content-->
</section>
</div>
<?php
include VIEWPATH . "front/templates/footer.php";
?>
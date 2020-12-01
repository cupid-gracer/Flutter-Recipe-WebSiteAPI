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
                    $attribute = array("name" => "ChangePasswordForm", "id" => "ChangePasswordForm");
                    echo form_open("change-password-action", $attribute);
                    ?>	
                    <?php $this->load->view("message"); ?>
                    <p>
                        <label>Current password</label>	
                        <input  autocomplete="off"  type="password" name="current_password" id="current_password" placeholder="Current password"  class="input">
                        <?php echo form_error('current_password'); ?>
                    </p>
                    <p>
                        <label>New password</label>	
                        <input  autocomplete="off"  type="password" name="new_password" id="new_password" placeholder="New password"  class="input">
                        <?php echo form_error('new_password'); ?>
                    </p>
                    <p>
                        <label>Confirm password</label>
                        <input   autocomplete="off" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" class="input">
                        <?php echo form_error('confirm_password'); ?>
                    </p>
                    <p>
                        <input type="submit" value="Update" id="Update" class="button-primary">
                        <a class="button-secondary" href="<?php echo base_url(); ?>">Cancel</a>
                    </p>    
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div><!--./container-->
    </div><!--./hs-content-->
</section>
<?php include VIEWPATH . "front/templates/footer.php"; ?>


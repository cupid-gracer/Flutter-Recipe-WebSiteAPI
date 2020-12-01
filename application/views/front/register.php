<?php include VIEWPATH . "front/templates/header.php"; ?>
<section class="ht-section hs-recipes grid minimum-height-login">
    <div class="hs-content">
        <div class="container">
            <div class="row message-row-height-home">
                <div class="register-form col-md-offset-3 col-md-6">
                    <div class="title">
                        <h2>Register</h2>
                    </div>
                    <?php
                    $attribute = array("name" => "UserRegisterForm", "id" => "UserRegisterForm");
                    echo form_open("register-action", $attribute);
                    ?>	
                    <?php $this->load->view("message"); ?>	 
                    <input type="hidden" name="user_id" id="user_id" value=""/>           
                    <p>
                        <label>Firstname</label>	
                        <input type="text"  autocomplete="off" name="firstname" id="firstname" value="<?php echo $this->input->post("firstname"); ?>"  placeholder="Firstname" class="input">
                        <?php echo form_error('firstname'); ?>
                    </p>
                    <p>
                        <label>Lastname</label>	
                        <input type="text"  autocomplete="off" name="lastname" id="lastname" value="<?php echo $this->input->post("lastname"); ?>" placeholder="Lastname" class="input">
                        <?php echo form_error('lastname'); ?>
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="email"  autocomplete="off" name="email" id="email" value="<?php echo $this->input->post("email"); ?>" placeholder="Email" class="input">
                        <?php echo form_error('email'); ?>
                    </p>
                    <p class="login-password">
                        <label>Password</label>
                        <input type="password"  autocomplete="off" name="password" id="password" placeholder="Password" class="input" >
                        <?php echo form_error('password'); ?>
                    </p>
                    <p class="login-password">
                        <label>Confirm password</label>
                        <input type="password"  autocomplete="off" name="conf_password" id="conf_password" placeholder="Confirm password" class="input">
                        <?php echo form_error('conf_password'); ?>
                    </p>
                    <p>
                        <input type="submit" value="Register" id="register" class="button-primary">
                        <span class="register-here"><a href="<?php echo base_url('login'); ?>">Back to login!</a></span>
                    </p>    
                    <?php echo form_close(); ?>    
                </div>
            </div>
        </div><!--./container-->
    </div><!--./hs-content-->
</section>
<script src="<?php echo base_url() . js_path; ?>module/user_front.js" type="text/javascript"></script>
<?php include VIEWPATH . "front/templates/footer.php"; ?>
  

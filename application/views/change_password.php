<?php
include "templates/header.php";
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "ChangePasswordForm", "method" => "post");
                echo form_open("admin/change-password-action", $attribute);
                ?>
                <div class="row">						             
                    <div class="form-group col-md-12">
                        <label>Current Password:<small class="error">*</small></label>
                        <input class="form-control" type="password" name="current_password"  placeholder="Current Password" id="current_password" value="" />
                        <?php echo form_error('current_password'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>New Password:<small class="error">*</small></label>
                        <input class="form-control" type="password" name="new_password" placeholder="New Password" id="new_password" value="" />
                        <?php echo form_error('new_password'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Confirm Password:<small class="error">*</small></label>
                        <input  class="form-control"type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" value="" />
                        <?php echo form_error('confirm_password'); ?>
                    </div>
                    <div class="form-group col-md-12 mb-0 text-right">
                        <a class="btn btn-info" href="<?php echo ('dashboard'); ?>">Cancel</a>
                        <button class="btn btn-primary" type="submit" name="btnChange">Update</button>
                    </div>
                </div>  
                <?php echo form_close(); ?> 
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() . js_path; ?>module/change-password.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>


<?php
include "templates/header.php";
$id = isset($email_data) && $email_data->id != '' ? $email_data->id : '';
$smtp_username = isset($email_data) && $email_data->smtp_username != '' ? $email_data->smtp_username : $this->input->post('smtp_username');
$smtp_password = isset($email_data) && $email_data->smtp_password != '' ? $email_data->smtp_password : $this->input->post('smtp_password');
$smtp_host = isset($email_data) && $email_data->smtp_host != '' ? $email_data->smtp_host : $this->input->post('smtp_host');
$smtp_port = isset($email_data) && $email_data->smtp_port != '' ? $email_data->smtp_port : $this->input->post('smtp_port');
$smtp_secure = isset($email_data) && $email_data->smtp_secure != '' ? $email_data->smtp_secure : $this->input->post('smtp_secure');
$email_from_name = isset($email_data) && $email_data->email_from_name != '' ? $email_data->email_from_name : $this->input->post('email_from_name');
$message = $this->input->post('message');
$subject = $this->input->post('subject');
$to_email = $this->input->post('to_email');
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "EmailSettingForm", "name" => "EmailSettingForm", "method" => "post");
                echo form_open("admin/email-setting-action", $attribute);
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>SMTP Host:<small class="error">*</small></label>
                        <input class="form-control" type="text" autocomplete="off" name="smtp_host" id="smtp_host" placeholder="SMTP host" value="<?php echo $smtp_host; ?>" />
                        <?php echo form_error('smtp_host'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>SMTP Username:<small class="error">*</small></label>
                        <input class="form-control" type="text" autocomplete="off" name="smtp_username" id="smtp_username" placeholder="SMTP username" value="<?php echo $smtp_username; ?>"/>
                        <?php echo form_error('smtp_username'); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="smtp_port" class="input-item-label">SMTP Port :</label>
                        <input class="form-control" autocomplete="off" type="text" id="smtp_port" name="smtp_port" placeholder="SMTP port" value="<?php echo isset($smtp_port) ? $smtp_port : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label>SMTP Password:<small class="error">*</small></label>
                        <input class="form-control" autocomplete="off" type="password" name="smtp_password" id="smtp_password" placeholder="SMTP password" value="<?php echo $smtp_password; ?>"/>
                        <?php echo form_error('smtp_password'); ?>
                    </div>

                </div>  
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="input-item-label">SMTP Secure :</label>
                        <div class="select-wrapper">
                            <select class="form-control" id="smtp_secure" name="smtp_secure">
                                <option value="" selected disabled>Select</option>
                                <option value="tls" <?php echo $smtp_secure == "tls" ? 'selected' : ''; ?>>TLS</option>
                                <option value="ssl" <?php echo $smtp_secure == "ssl" ? 'selected' : ''; ?>>SSL</option>
                            </select>
                            <?php echo form_error('smtp_secure'); ?>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email_from_name" class="input-item-label">Email From Name :</label>
                        <input class="form-control" type="text" id="email_from_name" name="email_from_name"  placeholder="Email from name" value="<?php echo isset($email_from_name) ? $email_from_name : ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12 mb-0 text-left">
                        <button class="btn btn-primary" type="submit">Update</button>
                        <a class="btn btn-info" href="<?php echo base_url('admin/dashboard'); ?>">Cancel</a>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<h1 class="h3 mb-2 mt-5 text-gray-800">Test Email</h1>
<div class="row  mb-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('test_email_message');
                $attribute = array("class" => "form-group", "id" => "TestEmailSettingForm", "name" => "TestEmailSettingForm", "method" => "post");
                echo form_open("admin/test-email-action", $attribute);
                ?>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Subject:<small class="error">*</small></label>
                        <input class="form-control" type="text" name="subject" id="subject" placeholder="Subject" value="<?php echo isset($subject) ? $subject : ''; ?>" />
                        <?php echo form_error('subject'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="to_email" class="input-item-label">To Email :</label>
                        <input class="form-control" type="email" id="to_email" name="to_email" placeholder="To Email" value="<?php echo isset($to_email) ? $to_email : ''; ?>">
                    </div>                       
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Message:<small class="error">*</small></label>
                        <textarea class="form-control" name="message" id="message" placeholder="Message" rows="2"><?php echo isset($message) ? $message : ''; ?></textarea>
                        <?php echo form_error('message'); ?>
                    </div>                    
                </div>
                <div class="row">
                    <div class="form-group col-md-12 mb-0 text-left">
                        <button class="btn btn-primary" type="submit">Send</button>
                    </div>
                </div>

                <?php echo form_close(); ?>
                <?php if (isset($status) && isset($response_message)) { ?>
                    <p class="alert alert-<?php echo isset($status) && $status == "True" ? "success" : "danger"; ?>"><?php echo $response_message; ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>    
<script src="<?php echo base_url() . js_path; ?>module/email.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>


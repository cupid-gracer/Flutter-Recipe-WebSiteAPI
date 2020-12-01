<?php
include "templates/header.php";
$status = isset($site_data) && $site_data->is_facebook_login  != '' ? $site_data->is_facebook_login  : $this->input->post('is_facebook_login');
$gstatus = isset($site_data) && $site_data->is_google_login  != '' ? $site_data->is_google_login  : $this->input->post('is_google_login');

$apikey = isset($site_data) && $site_data->apikey  != '' ? $site_data->apikey  : $this->input->post('apikey');
$authdomain = isset($site_data) && $site_data->authdomain  != '' ? $site_data->authdomain  : $this->input->post('authdomain');
$databaseurl = isset($site_data) && $site_data->databaseurl  != '' ? $site_data->databaseurl  : $this->input->post('databaseurl');
$storagebucket = isset($site_data) && $site_data->storagebucket  != '' ? $site_data->storagebucket  : $this->input->post('storagebucket');

$active = $inactive = '';
if ($status == "N") {
    $inactive = "checked";
} else {
    $active = "checked";
}

$gactive = $ginactive = '';
if ($gstatus == "N") {
    $ginactive = "checked";
} else {
    $gactive = "checked";
}
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title;?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "CarouselForm", "name" => "CarouselForm", "method" => "post");
                echo form_open_multipart("admin/social-login", $attribute);
                ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Facebook</label><br/>
                        <input type="radio" name="is_facebook_login" id="active" value="Y" <?php echo $active; ?>/>
                        <label for="active">Yes</label>
                        <span class="mr-2"></span>
                        <input type="radio" name="is_facebook_login" id="inactive" value="N" <?php echo $inactive; ?>/>
                        <label for="inactive">No</label>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Google</label><br/>
                        <input type="radio" name="is_google_login" id="is_google_login_active" value="Y" <?php echo $gactive; ?>/>
                        <label for="is_google_login_active">Yes</label>
                        <span class="mr-2"></span>
                        <input type="radio" name="is_google_login" id="is_google_login_inactive" value="N" <?php echo $ginactive; ?>/>
                        <label for="is_google_login_inactive">No</label>
                    </div>

                    <div class="form-group col-md-12 mb-0 text-left">
                        <button class="btn btn-primary" name="social_login" value="1" type="submit"><?php echo isset($id) && $id !='' ? "Update" : "Save" ;?></button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <br/>
        <h2>Firebase credential for Single Sign on</h2>
        <div class="card">
            <div class="card-body">
                <?php
                $attribute = array("class" => "form-group", "id" => "CarouselForm", "name" => "CarouselForm", "method" => "post");
                echo form_open_multipart("admin/social-login-credential", $attribute);
                ?>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>API Key</label><br/>
                        <input type="text" class="form-control" name="apikey" id="apikey" value="<?php echo $apikey; ?>"/>
                        <?php echo form_error('apikey'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Auth Domain</label><br/>
                        <input type="text" class="form-control"  name="authdomain" id="authdomain" value="<?php echo $authdomain; ?>"/>
                        <?php echo form_error('authdomain'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Database URL</label><br/>
                        <input type="text"  class="form-control" name="databaseurl" id="databaseurl" value="<?php echo $databaseurl; ?>"/>
                        <?php echo form_error('databaseurl'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Storage Bucket</label><br/>
                        <input type="text" class="form-control"  name="storagebucket" id="storagebucket" value="<?php echo $storagebucket; ?>"/>
                        <?php echo form_error('storagebucket'); ?>
                    </div>
                    <div class="form-group col-md-12 mb-0 text-left">
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                    <p>Please follow steps from <a href="https://firebase.google.com/docs/web/setup" target="_blank">https://firebase.google.com/docs/web/setup</a> to know how to get above details.</p>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php include "templates/footer.php"; ?>


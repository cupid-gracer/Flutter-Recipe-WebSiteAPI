<?php
include "templates/header.php";
$id = isset($site_data) && $site_data->id != '' ? $site_data->id : '';
$site_name = isset($site_data) && $site_data->site_name != '' ? $site_data->site_name : '';
$site_phone = isset($site_data) && $site_data->site_phone != '' ? $site_data->site_phone : $this->input->post('site_phone');
$site_email = isset($site_data) && $site_data->site_email != '' ? $site_data->site_email : $this->input->post('site_email');
$site_logo = isset($site_data) && $site_data->site_logo != '' ? $site_data->site_logo : '';
$site_favicon = isset($site_data) && $site_data->site_favicon != '' ? $site_data->site_favicon : '';
$head_script = isset($site_data) && $site_data->head_script != '' ? $site_data->head_script : $this->input->post('head_script');
$header_color = isset($site_data) && $site_data->header_color != '' ? $site_data->header_color : $this->input->post('header_color');
$time_zone = isset($site_data) && $site_data->time_zone != '' ? $site_data->time_zone : $this->input->post('time_zone');
$facebook_url = isset($site_data) && $site_data->facebook_url != '' ? $site_data->facebook_url : $this->input->post('facebook_url');
$google_url = isset($site_data) && $site_data->google_url != '' ? $site_data->google_url : $this->input->post('google_url');
$instagram_url = isset($site_data) && $site_data->instagram_url != '' ? $site_data->instagram_url : $this->input->post('instagram_url');
$twitter_url = isset($site_data) && $site_data->twitter_url != '' ? $site_data->twitter_url : $this->input->post('twitter_url');

if ($site_logo != '' && file_exists(FCPATH . uploads_path . $site_logo)) {
    $original_logo = str_replace("_thumb", "", $site_logo);
    $site_logo_url = base_url() . uploads_path . $original_logo;
} else {
    $site_logo_url = base_url() . SITE_LOGO;
}
if ($site_favicon != '' && file_exists(FCPATH . uploads_path . $site_favicon)) {
    $site_favicon_url = base_url() . uploads_path . $site_favicon;
} else {
    $site_favicon_url = base_url() . FAVICONE_152;
}
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "SiteSettingForm", "name" => "SiteSettingForm", "method" => "post");
                echo form_open_multipart("admin/sitesetting-save", $attribute);
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                <input type="hidden" name="hidden_logo" id="hidden_logo" value="<?php echo $site_logo; ?>"/>
                <input type="hidden" name="hidden_favicon" id="hidden_favicon" value="<?php echo $site_favicon; ?>"/>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Site name:<small class="error">*</small></label>
                        <input class="form-control" autocomplete="off"  type="text" name="site_name" id="site_name" placeholder="Site name" value="<?php echo $site_name; ?>"/>
                        <?php echo form_error('site_name'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email:<small class="error">*</small></label>
                        <input class="form-control" autocomplete="off" type="email" name="site_email" id="site_email" placeholder="Email" value="<?php echo $site_email; ?>" />
                        <?php echo form_error('site_email'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Phone:<small class="error">*</small></label>
                        <input class="form-control" autocomplete="off" type="number" name="site_phone" id="site_phone" placeholder="Phone" value="<?php echo $site_phone; ?>"/>
                        <?php echo form_error('site_phone'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="input-item-label">Time zone :</label>
                        <div class="select-wrapper">
                            <select class="form-control" id="time_zone" name="time_zone">
                                <option value="" selected disabled>Select time zone</option>
                                <?php foreach (tz_list() as $t) { ?>
                                    <option value="<?php echo $t['zone']; ?>" <?php echo $time_zone == $t['zone'] ? 'selected' : ''; ?>><?php echo $t['diff_from_GMT'] . ' - ' . $t['zone']; ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('time_zone'); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="file-field form-group">
                            <label>Logo:<small class="error">*</small></label>
                            <div class="custom-file">
                                <input type="file" autocomplete="off" <?php echo (isset($site_logo) && $site_logo != "") ? "" : "required"; ?> class="custom-file-input" name="site_logo" id="site_logo" value="<?php echo $site_logo; ?>"  onchange="logoURL(this)" accept="image/*" >
                                <label class="custom-file-label" for="site_logo"><?php echo isset($site_logo) && $site_logo != '' ? $site_logo : 'Choose file'; ?></label>
                                <?php echo form_error('site_logo'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <img id="site_logo_url" src="<?php echo $site_logo_url; ?>" alt="<?php echo $site_name; ?>" style="object-fit:contain!important"  width="100px" height="100px">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <div class="file-field form-group">
                            <label>Favicon Icon:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="site_favicon" id="site_favicon" value="<?php echo $site_favicon; ?>"  onchange="readURL(this)" accept="image/*" >
                                <label class="custom-file-label" for="site_favicon"><?php echo isset($site_favicon) && $site_favicon != '' ? $site_favicon : 'Choose file'; ?></label>
                                <?php echo form_error('site_favicon'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="<?php echo isset($id) && $id != '' && $site_favicon != '' ? 'image-block' : ''; ?>">               
                            <img id="site_favicon" src="<?php echo $site_favicon_url; ?>" alt="<?php echo $site_name; ?>"  style="object-fit:contain!important" width="100px" height="100px">
                            <a href="javaScript:void(0)" data-id="<?php echo $id; ?>" onclick="deleteImage(this)" class="delete-icon-on-hover"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>      
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="facebook_url" class="input-item-label">Facebook URL :</label>
                        <input class="form-control" autocomplete="off" type="url" id="facebook_url" name="facebook_url"  placeholder="Facebook url" value="<?php echo isset($facebook_url) ? $facebook_url : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="twitter_url" class="input-item-label">Tweeter URL :</label>
                        <input class="form-control" autocomplete="off" type="url" id="twitter_url" name="twitter_url" placeholder="Tweeter url" value="<?php echo isset($twitter_url) ? $twitter_url : ''; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="google_url" class="input-item-label">Google+ URL :</label>
                        <input class="form-control" type="url" autocomplete="off" id="google_url" name="google_url" placeholder="Google+ url" value="<?php echo isset($google_url) ? $google_url : ''; ?>">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="instagram_url" class="input-item-label">Instagram URL :</label>
                        <input class="form-control" type="url" autocomplete="off" id="instagram_url" name="instagram_url" placeholder="Instagram url" value="<?php echo isset($instagram_url) ? $instagram_url : ''; ?>">
                    </div>
                </div> 
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="head_script" class="input-item-label">Head script :</label>
                        <textarea class="form-control" id="head_script" name="head_script" rows="4" placeholder="Head script"><?php echo isset($head_script) ? $head_script : ''; ?></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="header_color" class="input-item-label">Header color:</label>
                        <input type="color" onchange="changeColor(this)" name="header_color" id="header_color" value="<?php echo $header_color; ?>">      
                        <input type="text" class="form-control" id="color_code" readonly value="<?php echo $header_color; ?>">  
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
<script src="<?php echo base_url() . js_path; ?>module/sitesetting.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>


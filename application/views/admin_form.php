<?php
include "templates/header.php";
$id = isset($admin_data) && $admin_data['id'] != '' ? $admin_data['id'] : "";
$firstname = isset($admin_data) && $admin_data['firstname'] != '' ? $admin_data['firstname'] : $this->input->post('firstname');
$lastname = isset($admin_data) && $admin_data['lastname'] != '' ? $admin_data['lastname'] : $this->input->post('lastname');
$image = isset($admin_data) && $admin_data['profile_image'] != '' ? $admin_data['profile_image'] : "";
$phone = isset($admin_data) && $admin_data['phone'] != '' ? $admin_data['phone'] : $this->input->post('phone');
$email = isset($admin_data) && $admin_data['email'] != '' ? $admin_data['email'] : $this->input->post('email');
if ($image != '' && file_exists(FCPATH . uploads_path . "profile/" . $image)) {
    $img_url = base_url() . uploads_path . "profile/" . $image;
} else {
    $img_url = base_url() . NO_USER_PATH;
}
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "ProfileForm", "method" => "post");
                echo form_open_multipart("admin/profile-save", $attribute);
                ?>
                <input type="hidden" id="hidden_image" name="hidden_image" value="<?php echo isset($image) ? $image : ''; ?>">
                <input type="hidden" id="id" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>First name:<small class="error">*</small></label>
                        <input class="form-control" type="text" autocomplete="off" name="firstname" id="firstname" placeholder="First name" value="<?php echo $firstname; ?>"/>
                        <?php echo form_error('firstname'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Last name:<small class="error">*</small></label>
                        <input class="form-control" type="text" autocomplete="off" name="lastname" id="lastname" placeholder="Last name" value="<?php echo $lastname; ?>"/>
                        <?php echo form_error('lastname'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Phone:<small class="error">*</small></label>
                        <input class="form-control" type="number" autocomplete="off" name="phone" id="phone" placeholder="Phone" value="<?php echo $phone; ?>"/>
                        <?php echo form_error('phone'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email:<small class="error">*</small></label>
                        <input class="form-control" type="email" autocomplete="off" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="file-field form-group">
                            <label>Image:</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="profile_image" id="profile_image"  onchange="readURL(this)" accept="image/*" >
                                <label class="custom-file-label" for="profile_image">Choose file</label>
                                <?php echo form_error('profile_image'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="<?php echo isset($id) && $id != '' && $image != '' ? 'image-block' : ''; ?>">               
                            <img id="profile_image" class="rounded-circle" style="object-fit: cover;" src="<?php echo $img_url; ?>" alt="No Image"  width="100" height="100">
                            <a href="javaScript:void(0)" data-id="<?php echo $id; ?>" onclick="deleteImage(this)" class="delete-icon-on-hover"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
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
<script src="<?php echo base_url() . js_path; ?>module/profile.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>


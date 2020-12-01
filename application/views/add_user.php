<?php
include "templates/header.php";

$id = isset($user) && $user->id != '' ? $user->id : '';
$image = isset($user) && $user->profile_image != '' ? $user->profile_image : "";
$firstname = isset($user) && $user->firstname != '' ? $user->firstname : $this->input->post('firstname');
$lastname = isset($user) && $user->lastname != '' ? $user->lastname : $this->input->post('lastname');
$email = isset($user) && $user->email != '' ? $user->email : $this->input->post('email');
$phone = isset($user) && $user->phone != '' ? $user->phone : $this->input->post('phone');
$status = isset($user) && $user->status != '' ? $user->status : '';
if ($image != '' && file_exists(FCPATH . uploads_path . "profile/" . $image)) {
    $img_url = base_url() . uploads_path . "profile/" . $image;
} else {
    $img_url = base_url() . NO_IMAGE_PATH;
}
?>

<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php
                    $attributes = array('id' => 'CustomerForm', 'name' => 'CustomerForm', 'class' => "col-md-12", 'method' => "post");
                    echo form_open_multipart('admin/user-save', $attributes);
                    ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                    <input type="hidden" name="hidden_image" id="hidden_image" value="<?php echo $image; ?>"/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>First Name:<small class="error">*</small></label>
                                    <input type="text" name="firstname" autocomplete="off" class="form-control" id="firstname" placeholder="First Name" value="<?php echo $firstname; ?>"/>
                                    <?php echo form_error('firstname'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Last Name:<small class="error">*</small></label>
                                    <input type="text" name="lastname" autocomplete="off" class="form-control" id="lastname" placeholder="Last Name" value="<?php echo $lastname; ?>"/>
                                    <?php echo form_error('lastname'); ?>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email:<small class="error">*</small></label>
                                    <input type="email" name="email" autocomplete="off" class="form-control" id="email" placeholder="Email" value="<?php echo $email; ?>"/>
                                    <?php echo form_error('email'); ?>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone:</label>
                                    <input type="number" name="phone" autocomplete="off" class="form-control" id="phone" placeholder="Phone" value="<?php echo $phone; ?>"/>
                                    <?php echo form_error('phone'); ?>
                                </div>
                            </div>        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="file-field form-group">
                                        <label>Image:</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="profile_image" id="profile_image"  onchange="readURL(this)" accept="image/*" >
                                            <label class="custom-file-label" for="profile_image"><?php echo isset($image) && $image != '' ? $image : 'Choose file'; ?></label>
                                            <?php echo form_error('profile_image'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="<?php echo isset($id) && $id != '' && $image != '' ? 'image-block' : ''; ?>">
                                            <img id="profile_image"  class="rounded-circle"  src="<?php echo $img_url; ?>" alt="No Image"  width="100" height="100">
                                            <a href="javaScript:void(0)" data-id="<?php echo $id; ?>" onclick="deleteImage(this)" class="delete-icon-on-hover"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>                                 
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Status:<small class="error">*</small></label><br/>
                                    <?php
                                    $active = $inactive = '';
                                    if ($status == "I") {
                                        $inactive = "checked";
                                    } else {
                                        $active = "checked";
                                    }
                                    ?>
                                    <input type="radio" name="status" id="active" value="A" <?php echo $active; ?>/>
                                    <label for="active">Active</label>
                                    <span class="mr-2"></span>
                                    <input type="radio" name="status" id="inactive" value="I" <?php echo $inactive; ?>/>
                                    <label for="inactive">Inactive</label>
                                </div>
                            </div>
                            <div class="form-group col-md-12 mb-0 text-right">

                                <button class="btn btn-primary" type="submit"><?php echo isset($id) && $id != '' ? 'Update' : 'Save' ?></button>
                                <a class="btn btn-info" href="<?php echo base_url('admin/user'); ?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url() . js_path; ?>module/customer.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>
	
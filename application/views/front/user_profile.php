<?php
include VIEWPATH . "front/templates/header.php";
$user_id = isset($user_data) && $user_data->id != '' ? $user_data->id : "";
$firstname = isset($user_data) && $user_data->firstname != '' ? $user_data->firstname : $this->input->post('firstname');
$lastname = isset($user_data) && $user_data->lastname != '' ? $user_data->lastname : $this->input->post('lastname');
$image = isset($user_data) && $user_data->profile_image != '' ? $user_data->profile_image : "";
$phone = isset($user_data) && $user_data->phone != '' ? $user_data->phone : $this->input->post('phone');
$email = isset($user_data) && $user_data->email != '' ? $user_data->email : $this->input->post('email');
$img_url = get_user_profile_image($image);
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
                    $attribute = array("name" => "UserProfileForm", "id" => "UserProfileForm");
                    echo form_open_multipart("register-action", $attribute);
                    ?>
                    <input type="hidden" id="hidden_image" name="hidden_image" value="<?php echo isset($image) ? $image : ''; ?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
                    <?php $this->load->view("message"); ?>
                    <p>
                        <label>First name</label>
                        <input type="text"  autocomplete="off" name="firstname" id="firstname" placeholder="Firstname" value="<?php echo isset($firstname) && $firstname != '' ? $firstname : ''; ?>" class="input">
                        <?php echo form_error('firstname'); ?>
                    </p>
                    <p>
                        <label>Last name</label>
                        <input type="text" autocomplete="off" name="lastname" id="lastname" placeholder="Lastname"  value="<?php echo isset($lastname) && $lastname != '' ? $lastname : ''; ?>" class="input">
                        <?php echo form_error('lastname'); ?>
                    </p>
                    <p>
                        <label>Email</label>
                        <input type="email" autocomplete="off" name="email" id="email" placeholder="Email" readonly  value="<?php echo isset($email) && $email != '' ? $email : ''; ?>" class="input">
                    </p>
                    <p>
                        <label>Phone</label>
                        <input type="number" autocomplete="off" name="phone" id="phone"  placeholder="Phone"  value="<?php echo isset($phone) && $phone != '' ? $phone : ''; ?>" class="input" >
                    </p>
                    <p>
                    <div class="file-field form-group">
                        <label>Image:</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="profile_image" id="profile_image"  onchange="readURL(this)" accept="image/*" >
                            <label class="custom-file-label" for="profile_image">Choose file</label>
                            <?php echo form_error('profile_image'); ?>
                        </div>
                    </div>
                    </p>
                    <p>
                    <div class="<?php echo isset($user_id) && $user_id != '' && $image != '' ? 'image-block' : ''; ?>">
                        <img id="profile_image" class="rounded-circle" style="object-fit: cover;" src="<?php echo $img_url; ?>" alt="No Image"  width="100" height="100">
                        <a href="javaScript:void(0)" data-id="<?php echo $user_id; ?>" onclick="deleteImage(this)" class="delete-icon-on-hover"><i class="fa fa-trash"></i></a>
                    </div>
                    </p>
                    <p>
                        <input type="submit" value="Update" id="Update" class="button-primary">
                        <a class="button-secondary" href="<?php echo base_url(); ?>">Cancel</a>
                        <span class="forgot-password"><a href="#AccountDeleteModal" data-toggle="modal">Delete account</a></span>
                    </p>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div><!--./container-->
    </div><!--./hs-content-->
</section>
<script src="<?php echo base_url() . js_path; ?>module/user_front.js" type="text/javascript"></script>
<?php include VIEWPATH . "front/templates/footer.php"; ?>


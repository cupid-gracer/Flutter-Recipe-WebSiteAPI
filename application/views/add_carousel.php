<?php
include "templates/header.php";
$id = isset($carousel) && $carousel->id != '' ? $carousel->id : "";
$carousel_title = isset($carousel) && $carousel->title != '' ? $carousel->title : $this->input->post('title');
$sub_title = isset($carousel) && $carousel->sub_title != '' ? $carousel->sub_title : $this->input->post('sub_title');
$image = isset($carousel) && $carousel->image != '' ? $carousel->image : "";
$status = isset($carousel) && $carousel->status != '' ? $carousel->status : $this->input->post('status');
if ($image != '' && file_exists(FCPATH . uploads_path . "carousel/" . $image)) {
    $img_url = base_url() . uploads_path . "carousel/" . $image;
} else {
    $img_url = base_url() . NO_IMAGE_PATH;
}
?>
<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php
                $this->load->view('message');
                $attribute = array("class" => "form-group", "id" => "CarouselForm", "name" => "CarouselForm", "method" => "post");
                echo form_open_multipart("admin/carousel-save", $attribute);
                ?>
                <input type="hidden" id="hidden_image" name="hidden_image" value="<?php echo isset($image) ? $image : ''; ?>">
                <input type="hidden" id="id" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Title:<small class="error">*</small></label>
                        <input class="form-control" autocomplete="off" type="text" name="title" id="title" placeholder="Title" value="<?php echo isset($carousel_title) ? $carousel_title : ''; ?>"/>
                        <?php echo form_error('title'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Sub title:<small class="error">*</small></label>
                        <input class="form-control"autocomplete="off" type="text" name="sub_title" id="sub_title" placeholder="Sub title" value="<?php echo isset($sub_title) ? $sub_title : ''; ?>"/>
                        <?php echo form_error('sub_title'); ?>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="file-field form-group">
                            <label>Image:</label>
                            <div class="custom-file">
                                <input type="file" <?php echo (isset($image) && $image != "") ? "" : "required"; ?> class="custom-file-input" name="image" id="image"  onchange="readURL(this)" accept="image/*" >
                                <label class="custom-file-label" for="image">Choose file</label>
                                <span>Upload 1920 × 1080 Dimensions image for proper view if possible.</span>
                                <?php echo form_error('image'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <img id="image" class="rounded-circle" style="object-fit: cover;" src="<?php echo $img_url; ?>" alt="No Image"  width="100" height="100">
                    </div>
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
                <div class="row">
                    <div class="form-group col-md-12 mb-0 text-left">
                        <button class="btn btn-primary" type="submit"><?php echo isset($id) && $id != '' ? "Update" : "Save"; ?></button>
                        <a class="btn btn-info" href="<?php echo base_url('admin/carousel'); ?>">Cancel</a>
                    </div>
                </div>
                <?php echo form_close(); ?> 
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() . js_path; ?>module/carousel.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>


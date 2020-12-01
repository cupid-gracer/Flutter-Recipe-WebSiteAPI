<?php
include "templates/header.php";

$cid = isset($category) && $category['cid'] != '' ? $category['cid'] : '';
$image = isset($category) && $category['category_image'] != '' ? $category['category_image'] : "";
$category_name = isset($category) && $category['category_name'] != '' ? $category['category_name'] : $this->input->post('category_name');
$status = isset($category) && $category['status'] != '' ? $category['status'] : '';
if ($image != '' && file_exists(FCPATH . uploads_path . "category/" . $image)) {  
    $img_url = base_url() . uploads_path . "category/" . $image;
} else {
    $img_url = base_url() . NO_IMAGE_PATH;
}
?>

<h1 class="h3 mb-2 text-gray-800"><?php echo $title;?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <?php
                        $attributes = array('id' => 'CategoryForm', 'name' => 'CategoryForm', 'class' => "col-md-12", 'method' => "post");
                        echo form_open_multipart('admin/category-save', $attributes);
                        ?>
                        <input type="hidden" name="cid" id="cid" value="<?php echo $cid; ?>"/>
                        <input type="hidden" name="hidden_image" id="hidden_image" value="<?php echo $image; ?>"/>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Category Name:<small class="error">*</small></label>
                                        <input type="text" autocomplete="off" name="category_name" class="form-control" id="category_name" placeholder="Category Name" value="<?php echo $category_name; ?>"/>
                                        <?php echo form_error('category_name'); ?>
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
                                    <div class="col-md-6">
                                        <div class="file-field form-group">
                                            <label>Image:</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="category_image" id="category_image"  onchange="readURL(this)" accept="image/*" >
                                                <label class="custom-file-label" for="category_image"><?php echo isset($image) && $image !='' ? $image :'Choose file';?></label>
                                                <?php echo form_error('category_image'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <div class="<?php echo isset($cid) && $cid !='' && $image !='' ? 'image-block' :'';?>">
                                                <img id="category_image"  class="rounded-circle"  src="<?php echo $img_url; ?>" alt="No Image"  width="100" height="100">
                                                <a href="javaScript:void(0)" data-id="<?php echo $cid;?>" onclick="deleteImage(this)" class="delete-icon-on-hover"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>                                 
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12 mb-0 text-left">
                                        <button class="btn btn-primary" type="submit"><?php echo  isset($cid) && $cid !='' ? 'Update': 'Save' ?></button>
                                        <a class="btn btn-info" href="<?php echo base_url('admin/category');?>">Cancel</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="<?php echo base_url() . js_path; ?>module/category.js" type="text/javascript"></script>
<script>

</script>
<?php include "templates/footer.php"; ?>
	
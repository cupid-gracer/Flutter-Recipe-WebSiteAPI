<?php
include "templates/header.php";

$rid = isset($recipes) && $recipes['rid'] !== '' ? $recipes['rid'] : '';
$recipes_heading = isset($recipes) && $recipes['recipes_heading'] !== '' ? $recipes['recipes_heading'] : $this->input->post('recipes_heading');
// $cat_id = isset($recipes) && $recipes['cat_id'] !== '' ? $recipes['cat_id'] : $this->input->post('cid');
$recipes_time = isset($recipes) && $recipes['recipes_time'] !== '' ? $recipes['recipes_time'] : $this->input->post('recipes_time');
$serving_person = isset($recipes) && $recipes['serving_person'] !== '' ? $recipes['serving_person'] : $this->input->post('serving_person');
$calories = isset($recipes) && $recipes['calories'] !== '' ? $recipes['calories'] : $this->input->post('calories');
$youtube_link = isset($recipes) && $recipes['youtube_link'] !== '' ? $recipes['youtube_link'] : $this->input->post('youtube_link');
$image = isset($recipes) && $recipes['recipes_image'] !== '' ? $recipes['recipes_image'] : "";
$direction = isset($recipes) && $recipes['direction'] !== '' ? $recipes['direction'] : $this->input->post('direction[]');
$summary = isset($recipes) && $recipes['summary'] !== '' ? $recipes['summary'] : $this->input->post('summary');
$ingredient = $this->input->post('ingredient_name[]');
$status = isset($recipes) && $recipes['status'] !== '' ? $recipes['status'] : '';
$today_recipe = isset($recipes) && $recipes['today_recipe'] !== '' ? $recipes['today_recipe'] : '';
$image_array = json_decode($image);
?>

<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>
<div class="col-md-12">
    <div class="row">
        <?php
        $attributes = array('id' => 'RecipesForm', 'name' => 'RecipesForm', 'class' => "form-group", 'method' => "post");
        echo form_open_multipart('admin/recipes-save', $attributes);
        ?>
        <input type="hidden" name="rid" id="rid" value="<?php echo $rid; ?>"/>
        <?php
        if (isset($image_array) && count($image_array) > 0) {
            foreach ($image_array as $key => $value) {
                ?>
                <input type="hidden" name="old_image[]" id="old_image" value="<?php echo $value ?>">
                <?php
            }
        }
        ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="row card-body">
                        <div class="form-group col-md-12">
                            <label>Recipe Name:
                                <small class="error">*</small>
                            </label>
                            <input type="text" autocomplete="off" name="recipes_heading" class="form-control"
                                   id="recipes_heading" placeholder="Recipe name"
                                   value="<?php echo isset($recipes_heading) ? $recipes_heading : ''; ?>"/>
                            <?php echo form_error('recipes_heading'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Cooking Time (In minutes):
                                <small class="error">*</small>
                            </label>
                            <input type="number" autocomplete="off" min="1" name="recipes_time" class="form-control"
                                   id="recipes_time" placeholder="Cooking Time"
                                   value="<?php echo isset($recipes_time) ? $recipes_time : ''; ?>"/>
                            <?php echo form_error('recipes_time'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Category:
                                <small class="error">*</small>
                            </label>
                            <!-- <select name="cid" class="form-control">
                                <option value="" selected disabled>Select category</option>
                                <?php foreach ($category as $category_data) { ?>
                                    <option value="<?php echo $category_data['cid']; ?>" <?php echo isset($cat_id) && $cat_id == $category_data['cid'] ? "selected" : ''; ?>><?php echo $category_data['category_name']; ?></option>
                                <?php } ?>
                            </select> -->
                            <?php foreach ($category as $category_data) { ?>
                                <div class="row">
                                <p class="form-group col-md-6" style="display:inline"><?php echo $category_data['category_name']; ?></p>
                                <div style="display:inline; "  class="form-group col-md-3" >
                                    <input name="cid[]" type="checkbox" value="<?php echo $category_data['cid']; ?>" <?php foreach ($cids as $cid) {   if( $cid['cid'] == $category_data['cid']) {echo "checked"; break;}} ?>  data-toggle="toggle"/>
                                </div>
                                <br>
                                </div>
                            <?php } ?>
                            <?php echo form_error('cid'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Status:
                                <small class="error">*</small>
                            </label><br/>
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
                        <div class="form-group file-field col-md-12" id="input_file_block">
                            <label>Image:
                                <small class="error">*</small>
                            </label>
                            <div class="custom-file">
                                <input type="file" <?php echo (isset($image_array) && count($image_array) > 0) ? "" : "required"; ?>
                                       class="custom-file-input" name="recipes_image[]" id="recipes_image"
                                       onchange="readURL(this)" accept="image/*">
                                <label class="custom-file-label" for="recipes_image">Choose file</label>
                                <?php echo form_error('recipes_image[]'); ?>
                            </div>
                        </div>
                        <div class="file-field  col-md-12" id="image_display_block">
                            <div class="form-group">
                                <ul class="list-inline" id="append-img">
                                    <?php
                                    if (isset($rid) && $rid != '') {
                                        if (isset($image_array) && count($image_array) > 0) {
                                            foreach ($image_array as $key => $value) {
                                                if ($image != '' && file_exists(FCPATH . uploads_path . "recipes/" . $value)) {
                                                    $img_url = base_url() . uploads_path . "recipes/" . $value;
                                                } else {
                                                    $img_url = base_url() . NO_IMAGE_PATH;
                                                }
                                                ?>
                                                <li class='list-inline-item' id="img<?php echo $key; ?>">
                                                    <div class='image-block-recipe'>
                                                        <img src="<?php echo $img_url; ?>" id="img<?php echo $key; ?>"
                                                             class="mt-2" alt="No Image" width="100" height="100">
                                                        <a href='#delete_image_modal' data-toggle="modal"
                                                           data-id="<?php echo $rid; ?>" data-key="<?php echo $key; ?>"
                                                           data-value="<?php echo $value; ?>"
                                                           onclick='deleteImageEdit(this)'
                                                           class='delete-icon-on-hover-recipe'><i
                                                                    class='fa fa-trash'></i></a>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-0 text-right d-none" id="add_more_image_btn">
                            <button type="button" class="add-more-image btn btn-primary mt-2 mb-2">Add More file
                            </button>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="input_fields_wrap">
                                <?php
                                if (isset($rid) && $rid != '') {
                                    $i = 0;
                                    $remove_class = "";
                                    foreach ($ingredients as $row) {
                                        $i++;
                                        if ($i > 1) {
                                            $remove_class = "ingredients_field mt-2";
                                        }
                                        ?>
                                        <div class="row <?php echo isset($remove_class) ? $remove_class : ''; ?>">
                                            <div class="col-md-4">
                                                <label>Ingredients:
                                                    <small class="error">*</small>
                                                </label>
                                                <input type="text" autocomplete="off" class="form-control"
                                                       name="ingredient_name[]" placeholder="Ingredient"
                                                       value="<?php echo $row['ingredient_name']; ?>">
                                                <?php echo form_error("ingredient_name[]"); ?>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Quantity:
                                                    <small class="error">*</small>
                                                </label>
                                                <input type="text" autocomplete="off" class="form-control"
                                                       name="quantity[]" placeholder="Quantity"
                                                       value="<?php echo $row['qty']; ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Weight:
                                                    <small class="error">*</small>
                                                </label>
                                                <select class="form-control" name="weight[]">
                                                    <?php foreach ($measurement as $measurement_data) { ?>
                                                        <option value="<?php echo $measurement_data['measurement_name']; ?>"
                                                            <?php echo $row['weight'] == $measurement_data['measurement_name'] ? 'selected' : ''; ?>
                                                        ><?php echo $measurement_data['measurement_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php if ($i > 1) { ?>
                                                <div class="col-md-2">
                                                    <button class="remove_field btn btn-danger remove_field_btn"
                                                            type="button" title="Remove"><i
                                                                class="fa fa-minus-circle"></i></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Ingredients:
                                                <small class="error">*</small>
                                            </label>
                                            <input type="text" autocomplete="off" class="form-control ingredient"
                                                   name="ingredient_name[]" placeholder="Ingredient"
                                                   value="<?php echo isset($ingredient) && $ingredient[0] != '' ? $ingredient[0] : ''; ?>">
                                            <?php echo form_error("ingredient_name[]"); ?>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Quantity:
                                                <small class="error">*</small>
                                            </label>
                                            <input type="text" autocomplete="off" class="form-control"
                                                   placeholder="Quantity" name="quantity[]">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Weight:
                                                <small class="error">*</small>
                                            </label>
                                            <select class="form-control" name="weight[]">
                                                <?php foreach ($measurement as $measurement_data) { ?>
                                                    <option value="<?php echo $measurement_data['measurement_name']; ?>"><?php echo $measurement_data['measurement_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-0 text-right">
                            <button type="button" class="add_field_button btn btn-info mt-2">Add More ingredient
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
                <div class="card">
                    <div class="row card-body">
                        <div class="form-group col-md-12">
                            <label>Serving for person:
                                <small class="error">*</small>
                            </label>
                            <input type="number" min="1" autocomplete="off" name="serving_person" id="serving_person"
                                   placeholder="Serving for person" class="form-control"
                                   value="<?php echo isset($serving_person) ? $serving_person : ''; ?>"/>
                            <?php echo form_error('serving_person'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Calories:
                            </label>
                            <input type="number" autocomplete="off" name="calories" id="calories"
                                   placeholder="Calories" class="form-control"
                                   value="<?php echo isset($calories) ? $calories : ''; ?>"/>
                            <?php echo form_error('calories'); ?>
                        </div>
                        <div class="form-group col-md-12">
                            <label>Youtube Link:
                            </label>
                            <input type="text" autocomplete="off" name="youtube_link" id="youtube_link"
                                   placeholder="Youtube Link" class="form-control"
                                   value="<?php echo isset($youtube_link) ? $youtube_link : ''; ?>"/>
                            <?php echo form_error('youtube_link'); ?>
                        </div>
                        <?php if ($rid) { ?>
                            <div class="form-group col-md-12 direction_field">
                                <label>Directions:
                                    <small class="error">*</small>
                                </label>
                                <?php
                                $direction_data = json_decode($direction);
                                $i = 1;
                                $class = "";
                                foreach ($direction_data as $row) {
                                    if ($row != '') {
                                        if ($i > 1) {
                                            $class = "mt-2";
                                        }
                                        ?>
                                        <div class="direction_field_edit">
                                            <input type="text" autocomplete="off" name="direction[]"
                                                   placeholder="Direction"
                                                   class="form-control <?php echo isset($class) ? $class : ''; ?>"
                                                   value="<?php echo isset($row) ? $row : ''; ?>">
                                            <?php if ($i > 1) { ?>
                                                <span class="mt-2 ml-2">
                                                    <button class="remove_direction btn btn-danger" type="button"
                                                            title="Remove"><i class="fa fa-minus-circle"></i></button>
                                                </span>
                                            <?php } ?>
                                            <?php echo form_error('direction[]'); ?>
                                        </div>
                                        <?php
                                    }
                                    $i++;
                                }
                                ?>
                            </div>
                        <?php } else {
                            ?>
                            <div class="form-group col-md-12 direction_field">
                                <label>Directions:
                                    <small class="error">*</small>
                                </label>
                                <input type="text" name="direction[]" autocomplete="off" placeholder="Direction"
                                       class="form-control"
                                       value="<?php echo isset($direction) && $direction[0] != '' ? $direction[0] : ''; ?>"/>
                                <?php echo form_error('direction[]'); ?>
                            </div>
                        <?php } ?>
                        <div class="col-md-12 text-right mb-2">
                            <button type="button" class="add_direction_button btn btn-info">Add more direction</button>
                        </div>
                        <?php if ($rid) { ?>
                        <div class="form-group col-md-12">
                            <label>Today Recipe:
                                <small class="error">*</small>
                            </label><br>
                            <input id="today-recipe" type="checkbox" data-id = "<?php echo $rid?>" <?php if ($today_recipe == 1)echo "checked"; ?> data-toggle="toggle">
                        </div>
                    <?php }?>
                        <div class="form-group col-md-12">
                            <label>Summary:
                                <small class="error">*</small>
                            </label>
                            <textarea name="summary" id="summary" class="form-control" placeholder="Summary"
                                      rows="5"><?php echo isset($summary) ? $summary : ''; ?></textarea>
                            <?php echo form_error('summary'); ?>
                        </div>

                        <div class="form-group col-md-12 mb-0 text-left">
                            <button class="btn btn-primary" type="submit"
                                    id="btnSubmit"> <?php echo isset($rid) && $rid != '' ? 'Update' : 'Publish'; ?></button>
                            <a href="<?php echo base_url('admin/recipes'); ?>" class="btn btn-info">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<div id="delete_image_modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                    <input type="hidden" id="delete_id" value=""/>
                    <input type="hidden" id="key" value=""/>
                    <input type="hidden" id="value" value=""/>
                    <p>Are you sure want to delete this image.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="DeleteImage" class="btn btn-primary" data-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() . js_path; ?>module/recipes.js" type="text/javascript"></script>
<script>
    $(function () {
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function (e) { //on add input button click
            e.preventDefault();
            $(wrapper).append('<div class="row ingredients_field mt-2"><div class="col-md-4"><label>Ingredients:<small class="error">*</small></label><input type="text" class="form-control" placeholder="Ingredient" name="ingredient_name[' + x + ']" required></div><div class="col-md-3"><label>Quantity:<small class="error">*</small></label><input type="text" placeholder="Quantity" class="form-control"  name="quantity[' + x + ']" required></div><div class="col-md-3"><label>Weight:<small class="error">*</small></label><select class="form-control"  name="weight[]">' +
                <?php foreach ($measurement as $measurement_data) {
                    echo '\'<option value="' . $measurement_data['measurement_name'] . '">' . $measurement_data['measurement_name'] . '</option>\'+';
                } ?>
                '</select></div><div class="col-md-2"><button class="remove_field btn btn-danger remove_field_btn" type="button" title="Remove"><i class="fa fa-minus-circle"></i></button></div></div>'); //add input box
            x++; //text box increment
        });
    })

    var base_url = "<?php echo base_url()?>";
</script>
<?php include "templates/footer.php"; ?>
<script src="<?php echo base_url() . js_path; ?>module/today_recipe.js" type="text/javascript"></script>


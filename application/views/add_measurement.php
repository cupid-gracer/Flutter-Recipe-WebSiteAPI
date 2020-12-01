<?php
include "templates/header.php";

$id = isset($measurement) && $measurement['id'] != '' ? $measurement['id'] : '';
$measurement_name = isset($measurement) && $measurement['measurement_name'] != '' ? $measurement['measurement_name'] : $this->input->post('measurement_name');
$status = isset($measurement) && $measurement['status'] != '' ? $measurement['status'] : '';
?>

<h1 class="h3 mb-2 text-gray-800"><?php echo $title; ?></h1>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php
                    $attributes = array('id' => 'MeasurementForm', 'name' => 'MeasurementForm', 'class' => "col-md-12", 'method' => "post");
                    echo form_open_multipart('admin/measurement-save', $attributes);
                    ?>
                    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Measurement Name:
                                        <small class="error">*</small>
                                    </label>
                                    <input type="text" autocomplete="off" name="measurement_name" class="form-control"
                                           id="measurement_name" placeholder="Measurement Name"
                                           value="<?php echo $measurement_name; ?>"/>
                                    <?php echo form_error('measurement_name'); ?>
                                </div>
                                <div class="form-group col-md-6">
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
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12 mb-0 text-left">
                                    <button class="btn btn-primary"
                                            type="submit"><?php echo isset($id) && $id != '' ? 'Update' : 'Save' ?></button>
                                    <a class="btn btn-info"
                                       href="<?php echo base_url('admin/measurement'); ?>">Cancel</a>
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

<script src="<?php echo base_url() . js_path; ?>module/measurement.js" type="text/javascript"></script>
<script>

</script>
<?php include "templates/footer.php"; ?>
	
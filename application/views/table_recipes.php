<?php
include("templates/header.php");
?>
<!-- Page Heading -->
<link href="<?php echo base_url() . vendor_path; ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<h1 class="h3 mb-2 text-gray-800">Recipes</h1>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-6 col-8 text-left">
                <h6 class="mt-2 font-weight-bold text-primary align-middle"><?php echo $title; ?></h6>
            </div>
            <div class="col-md-6 col-4 text-right">
                <a href="<?php echo base_url('admin/add-recipes'); ?>" class="btn btn-circle btn-primary" title="Add recipe"><i class="fas fa-plus"></i></a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php $this->load->view('message'); ?>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="category-table-head">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Recipes Name</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Cooking Time</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($recipes) && count($recipes) > 0) {

                        foreach ($recipes as $key => $row) {
                            // var_dump($row);die();
                            if ($row['recipe']['status'] == "A") {
                                $status = "Active";
                            } else {
                                $status = "Inactive";
                            }
                            ?>
                            <tr class="tr-shadow">
                                <td class="align-middle text-center"><?php echo $key + 1; ?></td>
                                <td class="align-middle text-center"><?php echo $row['recipe']['recipes_heading']; ?></td>
                                <td class="align-middle text-center">
                                    <?php $image_array = json_decode($row['recipe']['recipes_image']); ?>
                                    <img src="<?php echo base_url() . uploads_path . "recipes/" . $image_array[0]; ?>" class="rounded-circle recipes-image" width="60px" height="60px"/>
                                </td>
                                <td class="align-middle text-center"><?php echo $row['recipe']['recipes_time']; ?></td>
                                <td class="align-middle text-center"><?php foreach($row['cids'] as $c){ echo $c['category_name']."<br>"; } ?></td>
                                <td class="align-middle text-center text-<?php echo ($row['recipe']['status'] == "A") ? "success" : "danger"; ?>"><?php echo $status; ?></td>
                                <td class="align-middle text-center">																
                                    <a href="<?php echo base_url('admin/edit-recipes/' . $row['recipe']['rid']); ?>" title="Edit">
                                        <i class="fa fa-edit text-info"></i>
                                    </a>
                                    <a href="#delete_recipes_modal" onclick='DeleteRecord(this)' data-id="<?php echo $row['recipe']['rid']; ?>" data-toggle="modal" title="Delete" >
                                        <i class="fa fa-trash ml-1 text-danger"></i>
                                    </a>															
                                </td>
                            </tr>

                            <?php
                        }
                    } else {
                        ?>
                        <tr><td class="text-center" colspan="7"><h5>No Recipes Found!</h5></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Page level plugins -->
<script src="<?php echo base_url() . vendor_path; ?>datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url() . vendor_path; ?>datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() . js_path; ?>demo/datatables-demo.js"></script>
<script src="<?php echo base_url() . js_path; ?>module/recipes.js" type="text/javascript"></script>
<?php include("templates/footer.php"); ?>





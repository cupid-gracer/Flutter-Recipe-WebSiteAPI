<?php
include 'templates/header.php';
?>
<!-- Page Heading -->
<link href="<?php echo base_url() . vendor_path; ?>datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<h1 class="h3 mb-2 text-gray-800">Users</h1>
<div class="card shadow mb-4">     
    <div class="card-header py-3">
        <div class="row">
            <div class="col-md-6 col-8 text-left">
                <h6 class="mt-2 font-weight-bold text-primary align-middle"><?php echo $title; ?></h6>
            </div>
            <div class="col-md-6 col-4 text-right">
              <!-- <a href="<?php echo base_url('admin/add-user'); ?>" class="btn btn-circle btn-primary" title="Add category"><i class="fas fa-plus"></i></a> -->
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
                        <th class="text-center">Name</th>
                        <th class="text-center">Image</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($user) && !empty($user)) {
                        foreach ($user as $key => $row) {
                            if ($row->status == "A") {
                                $status = "Active";
                            } elseif ($row->status == "I") {
                                $status = "Inactive";
                            } else {
                                $status = "Not verify";
                            }
                            if ($row->profile_image != '' && file_exists(FCPATH . uploads_path . "profile/" . $row->profile_image)) {
                                $img_url = base_url() . uploads_path . "profile/" . $row->profile_image;
                            } else {
                                $img_url = base_url() . NO_USER_PATH;
                            }
                            ?>
                            <tr class="tr-shadow">
                                <td class="align-middle text-center"><?php echo $key + 1; ?></td>
                                <td class="align-middle text-center"><?php echo $row->firstname . " " . $row->lastname; ?></td>
                                <td class="align-middle text-center"><img src="<?php echo $img_url ?>" class="rounded-circle category-image"  width="60px" height="60px"/></td>
                                <td class="align-middle text-center text-<?php echo ($row->status == "A") ? "success" : "danger"; ?>"><?php echo $status; ?></td>
                                <td class="align-middle text-center">
                                    <a href="<?php echo base_url('admin/edit-user/' . $row->id); ?>" title="Edit">
                                        <i class="fa fa-edit text-info mr-1"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr><td class="text-center" colspan="5"><h5>No User Found!</h5></td></tr>
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
<script src="<?php echo base_url() . js_path; ?>module/customer.js" type="text/javascript"></script>
<?php include "templates/footer.php"; ?>










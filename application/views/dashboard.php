<?php include 'templates/header.php'; ?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>
<?php $this->load->view("message"); ?>
<!-- Content Row -->
<div class="row">

    <!-- category Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <a class="card-link" href="<?php echo base_url('admin/category'); ?>">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">CATEGORY</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_category; ?> Total Category</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-table fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <a class="card-link" href="<?php echo base_url('admin/recipes'); ?>">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">RECIPES LIST</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_news; ?> Total recipes</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!--  Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <a class="card-link" href="<?php echo base_url('admin/sitesetting'); ?>">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">SETTING</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Manage setting</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Content Row -->
<?php include 'templates/footer.php'; ?>
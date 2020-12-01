</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <?php echo get_site_name(); ?> <?php echo date("Y"); ?> </span>
        </div>      
        <div class="copyright text-center mt-2">
            version <?php echo VERSION; ?>
        </div>  
    </div>

</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="<?php echo base_url('admin/logout'); ?>">Logout</a>
            </div>
        </div>
    </div>
</div>

<!-- push notification-->
<div id="push-notification" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>we provide two options for push notifications service from Firebase and Onesignal, you can use one or both at once.</p>
                <p>you will be directed to web site which related with push notification services</p>
            </div>
            <div class="modal-footer">
                <a href="https://console.firebase.google.com" target="_blank" class="btn btn-light">Firebase</a>
                <a href="https://onesignal.com/" target="_blank" class="btn btn-light">OneSignal</a>
            </div>
        </div>
    </div>
</div>
<!-- delele category modal -->
<div id="delete_category_modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                    <input type="hidden" id="record_id"/>
                    <p>Category used in the recipes if you delete also deleted related recipes. Are you sure want to delete both.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="DeleteCategory" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- delele measurement modal -->
<div id="delete_measurement_modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                    <input type="hidden" id="record_id"/>
                    <p>Delete Mesaruement.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="DeleteMeasurement" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- delete recipes modal -->
<div id="delete_recipes_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button class="close" data-dismiss="modal">x</button>
            </div>
            <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                <input type="hidden" id="record_id"/>
                <div class="modal-body">
                    <p>Are sure want to delete recipe.</p>
                </div>
            </form>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <button id="DeleteRecipes" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </div> 
</div>

<!-- delete carousel modal -->
<div id="delete_carousel_modal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="DeleteRecordForm" name="DeleteRecordForm" method="post">
                    <input type="hidden" id="delete_carousel_id" name="delete_carousel_id"/>
                    <p>Are you sure want to delete carousel.</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <button id="DeleteSlider" class="btn btn-primary">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap core JavaScript-->
<script src="<?php echo base_url() . vendor_path; ?>bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?php echo base_url() . vendor_path; ?>jquery-easing/jquery.easing.min.js"></script>
<script src="<?php echo base_url() . js_path; ?>sb-admin-2.min.js"></script>
</body>
</html>

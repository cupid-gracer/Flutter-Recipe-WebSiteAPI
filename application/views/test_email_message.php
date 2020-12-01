<?php
if ($this->session->flashdata('response_class') == "success") {
    ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('response_msg'); ?>
    </div>

    <?php
} else if ($this->session->flashdata('response_class') == "failure") {
    ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('response_msg'); ?>
    </div>
    <?php
}
?>
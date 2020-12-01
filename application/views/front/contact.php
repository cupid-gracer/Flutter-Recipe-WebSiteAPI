<?php include VIEWPATH . "front/templates/header.php"; ?>
<div class="ht-section hs-contact minimum-height-login">
    <div class="container">
        <div class="row message-row-height-home">
            <div class="hs-content contact-form col-xs-12 col-sm-8 col-sm-offset-2">
                <h2>Contact</h2>
                <div class="ht-form-block">
                    <div class="text-center">
                        <h3 class="heading">SIMPLY LEAVE A MESSAGE HERE</h3>
                        <p class="sub-heading">Please fill out our form below and we'll contact you as soon as possible.</p>
                    </div>
                    <?php
                    $attribute = array("name" => "ContactForm", "id" => "ContactForm");
                    echo form_open("contact-action", $attribute);
                    ?>	
                    <?php $this->load->view("message"); ?>					
                    <div class="row">
                        <div class="form-group col-xs-12 col-sm-6">
                            <label>Name :<small class="require-mark"><i class="fa fa-asterisk"></i></small></label>
                            <input  autocomplete="off" type="text" id="name" name="name" placeholder="Name">
                            <?php echo form_error('name'); ?>
                        </div>
                        <div class="form-group col-xs-12 col-sm-6">
                            <label>Email :<small class="require-mark"><i class="fa fa-asterisk"></i></small></label>
                            <input  autocomplete="off" type="email" id="email" name="email" placeholder="Email">
                            <?php echo form_error('email'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Subject :</label>
                        <input autocomplete="off" type="text" id="subject" name="subject" placeholder="Subject">
                    </div>
                    <div class="form-group">
                        <label>Message :<small class="require-mark"><i class="fa fa-asterisk"></i></small></label>
                        <textarea id="message" name="message" placeholder="Message" cols="30" rows="10"></textarea>
                        <?php echo form_error('message'); ?>
                    </div>
                    <div class="form-group submit-group" style="padding-bottom: 30px;">
                        <button type="submit" class="ht-button view-more-button">
                            <i class="fa fa-arrow-left"></i> Send Message <i class="fa fa-arrow-right"></i>
                        </button>
                    </div>
                    <?php echo form_close(); ?>    
                </div>
                <!-- / .ht-form-block -->
            </div>
            <!-- / columns -->
        </div>
        <!-- / .row -->
    </div>
    <!-- / .container -->
</div>
<?php include VIEWPATH . "front/templates/footer.php"; ?>   

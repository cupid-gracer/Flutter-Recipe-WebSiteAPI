<!doctype html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <style>
        a:hover { text-decoration: underline !important;}
    </style>
    <body  marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f8f9;" leftmargin="0">
        <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f8f9" style="@import url(https://fonts.googleapis.com/css?family=Roboto:300,400,500); font-family: 'Roboto', sans-serif , Arial, Helvetica, sans-serif;">
            <tr>
                <td>
                    <table style="background-color: #f2f8f9; max-width:670px; margin:0 auto;" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td style="height:80px;">&nbsp;</td>
                        </tr>
                        <!-- Logo -->
                        <tr>
                            <td style="text-align:center;">
                                <a href="<?php echo base_url(); ?>" title="<?php echo get_site_name(); ?>"><img style="object-fit: contain !important;" width="100px" height="61px" src="<?php echo get_logo(); ?>" title="<?php echo get_site_name(); ?>" alt="<?php echo get_site_name(); ?>"></a>
                            </td>
                        </tr>
                        <tr>
                            <td style="height:40px;">&nbsp;</td>
                        </tr>
                        <!-- Email Content -->
                        <tr>
                            <td>
                                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px; background:#fff; border-radius:3px; -webkit-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);-moz-box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12);box-shadow:0 1px 3px 0 rgba(0, 0, 0, 0.16), 0 1px 3px 0 rgba(0, 0, 0, 0.12); padding:0 40px;">
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>

                                    <!-- Title -->
                                    <tr>
                                        <td style="padding:0 15px; text-align:center;">
                                            <h1 style="color:#3075BA; font-weight:400; margin:0;font-size:32px;">Hi,<?php echo isset($admin_name) && $admin_name!='' ? $admin_name : ""; ?></h1><br>
                                            <h1 style="color:#3075BA; font-weight:400; margin:0;font-size:32px;">You have a new contact request.</h1>
                                            <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                                        </td>
                                    </tr>
                                    <!-- Details Table -->
                                    <tr>
                                        <td>
                                            <table cellpadding="0" cellspacing="0" style="width: 100%; border: 1px solid #ededed">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de">Name:</td>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);" ><?php echo isset($name) && $name!='' ? $name : ""; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de">Email:</td>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);" ><?php echo isset($email) && $email !='' ? $email : ""; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:#171f23de">Subject:</td>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);" ><?php echo isset($subject) && $subject !='' ? $subject : "N/A"; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px;  border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:#171f23de">Message:</td>
                                                        <td style="padding: 10px; border-bottom: 1px solid #ededed; color: rgba(23,31,35,.87);"><?php echo isset($message) ? nl2br($message) : ""; ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="height:40px;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr> 
                        <tr>
                            <td style="height:20px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;">
                                <p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;"><strong>&copy;</strong> <?php echo get_site_name() . " " . date("Y"); ?></p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>

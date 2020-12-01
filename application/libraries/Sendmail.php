<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use PHPMailer\PHPMailer\PHPMailer;

include APPPATH . 'third_party/mail/PHPMailer.php';
include APPPATH . 'third_party/mail/Exception.php';
include APPPATH . "third_party/mail/SMTP.php";

class Sendmail
{

    public function send($toparam = array(), $subject, $html_body, $attachment = null, $debug = null)
    {
        try {
            $CI = &get_instance();
            $CI->db->select('*', false);
            $CI->db->from('tbl_email_setting');
            $email_data = $CI->db->get()->row_array();

            $smtp_host = isset($email_data['smtp_host']) ? $email_data['smtp_host'] : "smtp.gmail.com";
            $smtp_username = isset($email_data['smtp_username']) ? $email_data['smtp_username'] : "test@xyz.com";
            $smtp_password = isset($email_data['smtp_password']) ? $email_data['smtp_password'] : "password";
            $smtp_port = isset($email_data['smtp_port']) ? $email_data['smtp_port'] : 587;
            $smtp_secure = isset($email_data['smtp_secure']) ? $email_data['smtp_secure'] : "ssl";
            $email_from_name = isset($email_data['email_from_name']) ? $email_data['email_from_name'] : get_site_name();

            $CI = &get_instance();
            $mail = new PHPMailer;
            $mail->isSMTP();
            if ($debug) {
                $mail->SMTPDebug = 2; //enables SMTP debug information (for testing)
            } else {
                $mail->SMTPDebug = 0;
            }
            $mail->Host = $smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_username;
            $mail->Password = $smtp_password;
            $mail->SMTPSecure = $smtp_secure;
            $mail->Port = $smtp_port;
            $mail->From = $smtp_username;
            $mail->FromName = $email_from_name;
            if (isset($toparam) && count($toparam) > 0) {
                $to_email = $toparam['to_email'];
                $to_name = $toparam['to_name'];
            }

            $mail->addAddress($to_email, $to_name);
            if ($attachment != null) {
                $mail->addAttachment($attachment);
            }
            $mail->WordWrap = 50;
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $html_body;
            if (MAIL_SWITCH == true) {
                if (!$mail->send()) {
                    return (object) array("status" => false, "message" => $mail->ErrorInfo);
                } else {
                    return (object) array("status" => true);
                }
            }
        } catch (Exception $e) {
            return (object) array("status" => false, "message" => $e->getMessage());
        }
    }
}

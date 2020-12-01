<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sitesetting extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authenticate->check_admin();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }
    public function index()
    {

        $data['title'] = "Site setting";
        $site_data = $this->common_model->getTableData('tbl_site_config', array('id' => 1), '*')->row();
        $data['site_data'] = $site_data;
        $this->load->view("site_setting", $data);
    }
    public function sitesetting_save()
    {

        $id = $this->input->post("id");
        $this->form_validation->set_rules('site_name', '', 'trim|required');
        $this->form_validation->set_rules('site_phone', '', 'trim|exact_length[10]|required');
        $this->form_validation->set_rules('site_email', '', 'trim|valid_email|required');
        $this->form_validation->set_rules('time_zone', '', 'trim|required');
        $this->form_validation->set_rules('site_logo', '', 'callback_check_logo');
        $this->form_validation->set_rules('site_favicon', '', 'callback_check_favicon');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            //   logo
            $old_logo = $this->input->post('hidden_logo');
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path;
                $tmp_name = $_FILES["site_logo"]["tmp_name"];
                $temp = explode(".", $_FILES["site_logo"]["name"]);
                $logo_name = uniqid();
                $new_log_name = $logo_name . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$new_log_name");
                $this->load->library('image_lib');
                $config['image_library'] = 'gd2';
                $config['source_image'] = $uploadPath . '/' . $new_log_name;
                $config['create_thumb'] = true;
                $config['maintain_ratio'] = true;
                $config['width'] = 241;
                $config['height'] = 61;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                if ($this->image_lib->resize()) {
                    $new_log_name = $logo_name . "_thumb." . end($temp);
                }

                $rep_logo = str_replace("_thumb", "", $old_logo);
                if (isset($old_logo) && $old_logo != "") {
                    if (file_exists(FCPATH . uploads_path . $old_logo)) {
                        unlink(FCPATH . uploads_path . $old_logo);
                    }
                }
                if (isset($rep_logo) && $rep_logo != "") {
                    if (file_exists(FCPATH . uploads_path . $rep_logo)) {
                        unlink(FCPATH . uploads_path . $rep_logo);
                    }
                }
            }
            // favicon icon
            $old_favicon = $this->input->post('hidden_favicon');
            if (isset($_FILES['site_favicon']) && $_FILES['site_favicon']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path;
                $tmp_name = $_FILES["site_favicon"]["tmp_name"];
                $temp = explode(".", $_FILES["site_favicon"]["name"]);
                $new_favicon_name = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$new_favicon_name");

                if (isset($old_favicon) && $old_favicon != "") {
                    if (file_exists(FCPATH . uploads_path . $old_favicon)) {
                        unlink(FCPATH . uploads_path . $old_favicon);
                    }
                }
            }

            $update = array(
                'site_name' => $this->input->post('site_name'),
                'site_phone' => $this->input->post('site_phone'),
                'site_email' => $this->input->post('site_email'),
                'time_zone' => $this->input->post('time_zone'),
                'head_script' => $this->input->post('head_script'),
                'facebook_url' => $this->input->post('facebook_url'),
                'google_url' => $this->input->post('google_url'),
                'instagram_url' => $this->input->post('instagram_url'),
                'twitter_url' => $this->input->post('twitter_url'),
                'header_color' => $this->input->post('header_color'),
                'site_logo' => isset($new_log_name) ? $new_log_name : $old_logo,
                'site_favicon' => isset($new_favicon_name) ? $new_favicon_name : $old_favicon,
            );
            //Check for update
            if ($id > 0) {
                $this->common_model->updateTableData('tbl_site_config', array("id" => 1), $update);
                $this->session->set_flashdata('msg', "Site setting updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $this->common_model->insertTableData('tbl_site_config', $update);
                $this->session->set_flashdata('msg', "Site setting saved successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            }

            redirect(base_url()."admin/sitesetting");
        }
    }

    public function check_logo()
    {
        $id = $this->input->post('id');
        $image = '';
        if (isset($id) && $id != '') {
            $new_logo = $_FILES['site_logo']['name'];
            if (isset($new_logo) && $new_logo != '') {
                $image = $_FILES['site_logo']['name'];
            } else {
                $image = $this->input->post('hidden_logo');
            }
        } else {
            $image = $_FILES['site_logo']['name'];
        }
        if ($image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $allowed_extensions)) {
                $this->form_validation->set_message('check_logo', 'Invalid format. Only jpg / jpeg/ png /gif format allowed.');
                return false;
            }
        } else {
            $this->form_validation->set_message('check_logo', 'This field is required.');
            return false;
        }
        return true;
    }
    public function check_favicon()
    {
        $id = $this->input->post('id');
        $image = '';
        if (isset($id) && $id != '') {
            $new_logo = $_FILES['site_favicon']['name'];
            if (isset($new_logo) && $new_logo != '') {
                $image = $_FILES['site_favicon']['name'];
            } else {
                $image = $this->input->post('hidden_logo');
            }
        } else {
            $image = $_FILES['site_favicon']['name'];
        }
        if ($image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif", "ico");
            if (!in_array($extension, $allowed_extensions)) {
                $this->form_validation->set_message('check_favicon', 'Invalid format. Only jpg / jpeg/ png /gif/ico format allowed.');
                return false;
            }
        } else {
            return true;
        }
        return true;
    }
    public function delete_favicon_image($id)
    {
        $data = $this->common_model->getTableData('tbl_site_config', array('id' => $id), 'site_favicon')->row();
        if ($data->site_favicon != '') {
            $update = $this->common_model->updateTableData('tbl_site_config', array('id' => $id), array('site_favicon' => ''));
            if ($update) {
                if (file_exists(FCPATH . uploads_path . $data->site_favicon)) {
                    unlink(FCPATH . uploads_path . $data->site_favicon);
                }
                echo true;
                exit;
            }
        } else {
            echo false;
            exit;
        }
    }

    // email setting
    public function email_setting()
    {
        $data['title'] = "Email setting";
        $email_data = $this->common_model->getTableData('tbl_email_setting', array('id' => 1), '*')->row();
        $data['email_data'] = $email_data;
        $this->load->view("email_setting", $data);

    }
    public function email_setting_save()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules("smtp_username", "", "trim|required");
        $this->form_validation->set_rules("smtp_port", "", "trim|required");
        $this->form_validation->set_rules("smtp_host", "", "trim|required");
        $this->form_validation->set_rules("smtp_secure", "", "trim|required");
        $this->form_validation->set_rules("email_from_name", "", "trim|required");
        $this->form_validation->set_rules("smtp_password", "", "trim|required");
        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == false) {
            $this->email_setting();
        } else {

            $update = array(
                'smtp_username' => $this->input->post("smtp_username"),
                'smtp_port' => $this->input->post("smtp_port"),
                'smtp_host' => $this->input->post("smtp_host"),
                'smtp_secure' => $this->input->post("smtp_secure"),
                'email_from_name' => $this->input->post("email_from_name"),
                'smtp_password' => $this->input->post("smtp_password"),
            );
            if ($id) {
                $update['updated_on'] = date('Y-m-d H:i:s');
                $this->common_model->updateTableData('tbl_email_setting', array('id' => 1), $update);
                $this->session->set_flashdata('msg', "Email setting updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $this->common_model->insertTableData('tbl_email_setting', $update);
                $this->session->set_flashdata('msg', "Email setting saved successfully.");
                $this->session->set_flashdata('msg_class', 'success');

            }
            redirect('admin/email-setting');
        }

    }

    public function social_login(){
        $data['title'] = "Social Login";

        if(isset($_POST['social_login']) && $_POST['social_login']==1){
            $update = array(
                'is_facebook_login' => $this->input->post("is_facebook_login"),
                'is_google_login' => $this->input->post("is_google_login")
            );
            $this->db->update('tbl_site_config',$update);

            $this->session->set_flashdata('msg', "Social login updated successfully.");
            $this->session->set_flashdata('msg_class', 'success');

        }

        $site_data = $this->common_model->getTableData('tbl_site_config', array('id' => 1), 'apikey,authdomain,databaseurl,storagebucket,is_facebook_login,is_google_login')->row();
        $data['site_data'] = $site_data;
        $this->load->view("social_login", $data);
    }

    public function social_login_credential(){
        $this->form_validation->set_rules("apikey", "", "trim|required");
        $this->form_validation->set_rules("authdomain", "", "trim|required");
        $this->form_validation->set_rules("databaseurl", "", "trim|required");
        $this->form_validation->set_rules("storagebucket", "", "trim|required");

        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == true) {
            $update = array(
                'apikey' => $this->input->post("apikey"),
                'databaseurl' => $this->input->post("databaseurl"),
                'storagebucket' => $this->input->post("storagebucket"),
                'authdomain' => $this->input->post("authdomain")
            );
            $this->db->update('tbl_site_config',$update);
            $this->session->set_flashdata('msg', "Setting updated successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect('admin/social-login');
        }else{
            $this->social_login();
        }
    }
   public function test_email_save()
    {
        $this->form_validation->set_rules("message", "", "trim|required");
        $this->form_validation->set_rules("subject", "", "trim|required");
        $this->form_validation->set_rules("to_email", "", "trim|required|valid_email");
        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == false) {
            $this->email_setting_save();
        } else {
            $message = $this->input->post("message");
            $subject = $this->input->post("subject");
            $email = $this->input->post("to_email");

            // Send email
            $define_param['to_email'] = $email;
            $define_param['to_name'] = $email;
            $send = $this->sendmail->send($define_param, $subject, $message,"",true);
            if ($send->status) {
                $this->session->set_flashdata('response_msg', "Email sent successfully.");
                $this->session->set_flashdata('response_class', 'success');
            } else {
                $this->session->set_flashdata('response_msg', $send->message);
                $this->session->set_flashdata('response_class', 'failure');
            }
            redirect('admin/email-setting');
        }

    }

}

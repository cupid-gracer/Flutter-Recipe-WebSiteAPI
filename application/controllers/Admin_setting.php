<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_setting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->authenticate->check_admin();
        date_default_timezone_set(get_time_zone());
        $this->load->model('model_support');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    public function index() {
        $id = $this->session->userdata('ADMIN_ID');
        if ($id) {
            $data['title'] = "Profile";
            $admin_data = $this->model_support->getData('tbl_user', '*', '', 'id="' . $id . '"');
            $data['admin_data'] = $admin_data[0];
            $this->load->view("admin_form", $data);
        } else {
            redirect(base_url()."admin/login");
        }
    }

    public function update_profile() {
        $admin_id = $this->input->post('id');
        $this->form_validation->set_rules('firstname', '', 'trim|required');
        $this->form_validation->set_rules('lastname', '', 'trim|required');
        $this->form_validation->set_rules('profile_image', '', 'callback_check_image');
        $this->form_validation->set_rules('phone', '', 'trim|exact_length[10]|required');
        $this->form_validation->set_rules('email', '', 'trim|valid_email|required');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $old_image = $this->input->post('hidden_image');
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . "profile/";
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $img_name = uniqid();
                $new_image = $img_name . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$new_image");

                if (isset($old_image) && $old_image != "") {
                    unlink(FCPATH . uploads_path . "profile/" . $old_image);
                }
            }
            $insert = array(
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'firstname' => $this->input->post('firstname'),
                'user_type' => "A",
                'lastname' => $this->input->post('lastname'),
                'profile_image' => isset($new_image) ? $new_image : $old_image,
            );
            //Check for update
            if ($admin_id > 0) {
                $insert['updated_on'] = date('Y-m-d H:i:s');
                $this->model_support->update('tbl_user', $insert, "id='$admin_id'");
                $this->session->set_flashdata('msg', "Profile updated successdully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $insert['created_on'] = date('Y-m-d H:i:s');
                $this->model_support->insert('tbl_user', $insert);
                $this->session->set_flashdata('msg', "User added successdully.");
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect(base_url()."admin/admin-setting");
        }
    }

    public function check_image() {
        $image = "";
        $image = $_FILES['profile_image']['name'];
        if ($image == '') {
            $image = $this->input->post("hidden_image");
        }
        if ($image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $allowed_extensions)) {
                $this->form_validation->set_message('check_image', 'Invalid format. Only jpg / jpeg/ png /gif format allowed.');
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    public function delete_profile_image($id) {
        $admin_data = $this->model_support->getData('tbl_user', 'profile_image', '', 'id="' . $id . '"');
        if (isset($admin_data) && $admin_data[0]['profile_image'] != '') {
            $update = $this->model_support->update('tbl_user', array('profile_image' => ''), "id='$id'");
            if ($update) {
                if (file_exists(FCPATH . uploads_path . "profile/" . $admin_data[0]['profile_image'])) {
                    unlink(FCPATH . uploads_path . "profile/" . $admin_data[0]['profile_image']);
                }
                echo true;
                exit;
            }
        } else {
            echo false;
            exit;
        }
    }

}

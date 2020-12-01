<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
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
        $data['title'] = "Manage Users";
        $data['user'] = $this->common_model->getTableData('tbl_user', array("user_type"=>"C"), "*", array(),array(),array(),"","", array("id" ,"desc"))->result();
        $this->load->view("table_user", $data);
    }
    public function add_user()
    {
        $data['title'] = "Add User";
        $this->load->view("add_user", $data);
    }

    public function edit_user($id)
    {
        $id =(int) $id;
        $result = $this->common_model->getTableData('tbl_user', array("id" =>$id))->row();
        if ($result && !empty($result)) {
            $data['user'] = $result;
            $data['title'] = "Edit User";
            $this->load->view("add_user", $data);
        } else {
            $this->session->set_flashdata('msg', "User not found.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url()."admin/user");
        }
    }
    public function user_save()
    {
        $id = (int) $this->input->post('id');
        $this->form_validation->set_rules('firstname', '', 'trim|required');
        $this->form_validation->set_rules('lastname', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'trim|required|valid_email');
        $this->form_validation->set_rules('status', '', 'trim|required');
        $this->form_validation->set_rules('phone', '', 'trim|exact_length[10]');
        $this->form_validation->set_rules('profile_image', '', 'callback_check_image');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($id) {
                $this->edit_user($id);
            } else {
                $this->add_user();
            }
        } else {
            $old_image = $this->input->post('hidden_image');
            if (isset($_FILES['profile_image']) && $_FILES['profile_image']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . 'profile';
                $tmp_name = $_FILES["profile_image"]["tmp_name"];
                $temp = explode(".", $_FILES["profile_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");

                if (isset($old_image) && $old_image != "") {
                    if (file_exists(FCPATH . uploads_path . "profile/" . $old_image)) {
                        unlink(FCPATH . uploads_path . "profile/" . $old_image);
                    }
                }
            }
            $insert = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('category_name'),
                'user_type' => "C",
                'profile_image' => isset($newfilename) ? $newfilename : $old_image,
                'status' => $this->input->post('status'),
            );
            //Check for update
            if ($id > 0) {
                $insert['updated_on'] = date('Y-m-d H:i:s');
                $this->common_model->updateTableData('tbl_user',array("id" =>$id), $insert);
                $this->session->set_flashdata('msg', "User updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $insert['created_on'] = date('Y-m-d H:i:s');
                $this->common_model->insertTableData('tbl_user', $insert);
                $this->session->set_flashdata('msg', "User added successfully");
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect(base_url()."admin/user");
        }
    }
    
    public function check_image()
    {
        $id = $this->input->post('cid');
        if (isset($id) && $id != '') {
            $new_logo = $_FILES['profile_image']['name'];
            if (isset($new_logo) && $new_logo != '') {
                $image = $_FILES['profile_image']['name'];
            } else {
                $image = $this->input->post('hidden_image');
            }
        } else {
            $image = $_FILES['profile_image']['name'];
        }
        if ($image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $allowed_extensions)) {
                $this->form_validation->set_message('check_image', 'Invalid format. Only jpg / jpeg/ png /gif format allowed.');
                return false;
            }
        }
        return true;
    }

    public function delete_user_image($id)
    {
        $data = $this->common_model->getTableData('tbl_user',array("id" => $id), 'profile_image')->row();
        if (isset($data) && !empty($data)) {
            $update['profile_image'] = "";
            $res = $this->common_model->updateTableData('tbl_user', array("id" => $id) ,$update);
            if ($res) {
                if (file_exists(FCPATH . uploads_path . 'profile/' . $data->profile_image)) {
                    unlink(FCPATH . uploads_path . 'profile/' . $data->profile_image);
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

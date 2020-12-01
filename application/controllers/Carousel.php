<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Carousel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->authenticate->check_admin();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    public function index() {

        $data['title'] = "Manage Carousels";
        $carousel_data = $this->common_model->getTableData('tbl_carousel', array(), '*', array(), array(), array(), "", "", array("id", "desc"))->result();
        $data['carousel'] = $carousel_data;
        $this->load->view("table_carousel", $data);
    }

    public function add_carousel() {
        $data['title'] = "Add new carousel";
        $this->load->view("add_carousel", $data);
    }

    public function edit_carousel($id) {
        $id = (int) $id;
        $where = array("id" => $id);
        $result = $this->common_model->getTableData('tbl_carousel', $where, '*')->row();
        if ($result && !empty($result)) {
            $data['carousel'] = $result;
            $data['title'] = "Edit carousel";
            $this->load->view("add_carousel", $data);
        } else {
            $this->session->set_flashdata('msg', "Carousel not found.Please try another.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url()."admin/carousel");
        }
    }

    public function carousel_save() {

        $id = $this->input->post("id");
        $this->form_validation->set_rules('title', '', 'trim|required');
        $this->form_validation->set_rules('sub_title', '', 'trim|required');
        $this->form_validation->set_rules('status', '', 'trim|required');
        $this->form_validation->set_rules('image', '', 'callback_check_image');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($id) {
                $this->edit_carousel($id);
            } else {
                $this->add_carousel();
            }
        } else {

            $hidden_image = $this->input->post('hidden_image');
            if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . "carousel";
                $tmp_name = $_FILES["image"]["tmp_name"];
                $temp = explode(".", $_FILES["image"]["name"]);
                $new_image = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$new_image");

                if (isset($hidden_image) && $hidden_image != "") {
                    if (file_exists(FCPATH . uploads_path . "carousel/" . $hidden_image)) {
                        unlink(FCPATH . uploads_path . "carousel/" . $hidden_image);
                    }
                }
            }

            $data = array(
                'title' => $this->input->post('title'),
                'sub_title' => $this->input->post('sub_title'),
                'status' => $this->input->post('status'),
                'image' => isset($new_image) ? $new_image : $hidden_image,
            );
            //Check for data
            if ($id > 0) {
                $data['updated_on'] = date("Y-m-d h:i:s");
                $this->common_model->updateTableData('tbl_carousel', array('id' => $id), $data);
                $this->session->set_flashdata('msg', "Carousel updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            } else {
                $data['created_on'] = date("Y-m-d h:i:s");
                $this->common_model->insertTableData('tbl_carousel', $data);
                $this->session->set_flashdata('msg', "Carousel added successfully.");
                $this->session->set_flashdata('msg_class', 'success');
            }
            redirect(base_url()."admin/carousel");
        }
    }

    public function check_image() {
        $id = $this->input->post('id');
        if (isset($id) && $id != '') {
            $new_logo = $_FILES['image']['name'];
            if (isset($new_logo) && $new_logo != '') {
                $image = $_FILES['image']['name'];
            } else {
                $image = $this->input->post('hidden_image');
            }
        } else {
            $image = $_FILES['image']['name'];
        }
        if ($image) {
            $extension = pathinfo($image, PATHINFO_EXTENSION);
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            if (!in_array($extension, $allowed_extensions)) {
                $this->form_validation->set_message('check_image', 'Invalid format. Only jpg / jpeg/ png /gif format allowed.');
                return false;
            }
        } else {
            $this->form_validation->set_message('check_image', 'This field is required.');
            return false;
        }
        return true;
    }

    public function delete_carousel($id) {
        $image = $this->common_model->getTableData('tbl_carousel', array("id" => $id), 'image')->row();
        if (isset($image) && !empty($image)) {
            if (file_exists(FCPATH . uploads_path . 'carousel/' . $image->image)) {
                unlink(FCPATH . uploads_path . 'carousel/' . $image->image);
            }
        }
        $this->common_model->deleteTableData('tbl_carousel', array("id" => $id));
        $this->session->set_flashdata('msg', "Carousel deleted successfully.");
        $this->session->set_flashdata('msg_class', 'success');
        exit;
    }

    public function check_carousel_title() {
        $id = (int) $this->input->post('id');
        $title = trim($this->input->post('title'));
        if (isset($id) && $id > 0) {
            $where = array("title" => $title, "id!=" => $id);
        } else {
            $where = array("title" => $title);
        }
        $check_name = $this->common_model->getTableData("tbl_carousel", $where, "title")->result();
        if (isset($check_name) && count($check_name) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

}

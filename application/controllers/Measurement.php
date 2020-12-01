<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Measurement extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authenticate->check_admin();
        date_default_timezone_set(get_time_zone());
        $this->load->model('model_support');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    public function index()
    {
        $order = "id desc";
        $data['title'] = "Manage Measurements";
        $data['measurement'] = $this->model_support->getData('tbl_measurement', '*', "", "", $order);
        $this->load->view("table_measurement", $data);
    }

    public function add_measurement()
    {
        $data['title'] = "Add Measurement";
        $this->load->view("add_measurement", $data);
    }

    public function edit_measurement($id)
    {
        $id = (int)$id;
        $where = "id=$id";
        $result = $this->model_support->getData('tbl_measurement', '*', "", $where);
        if ($result && count($result) > 0) {
            $data['measurement'] = $result[0];
            $data['title'] = "Edit Measurement";
            $this->load->view("add_measurement", $data);
        } else {
            $this->session->set_flashdata('msg', "Measurement not found.Please try another.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url()."admin/measurement");
        }
    }

    public function measurement_save()
    {
        $measurement_id = (int)$this->input->post('id');
        $this->form_validation->set_rules('measurement_name', '', 'trim|required');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($measurement_id) {
                $this->edit_measurement($measurement_id);
            } else {
                $this->add_measurement();
            }
        } else {
            $insert = array(
                'measurement_name' => $this->input->post('measurement_name'),
                'status' => $this->input->post('status'),
            );
            //Check for update
            if ($measurement_id > 0) {
                $insert['updated_on'] = date('Y-m-d H:i:s');
                $this->model_support->update('tbl_measurement', $insert, "id='$measurement_id'");
                $this->session->set_flashdata('msg', "Measurement updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect(base_url()."admin/measurement");
            } else {
                $insert['created_on'] = date('Y-m-d H:i:s');
                $this->model_support->insert('tbl_measurement', $insert);
                $this->session->set_flashdata('msg', "Measurement added successfully");
                $this->session->set_flashdata('msg_class', 'success');
                redirect(base_url()."admin/measurement");
            }
        }
    }

    public function delete_measurement($id)
    {
        $where = "id=$id";
        $this->model_support->delete('tbl_measurement', $where);
        $this->session->set_flashdata('msg', "Measurement deleted successfully.");
        $this->session->set_flashdata('msg_class', 'success');
        exit;
    }
}

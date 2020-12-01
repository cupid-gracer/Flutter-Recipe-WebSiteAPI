<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
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
        $order = "cid desc";
        $data['title'] = "Manage Categories";
        $data['category'] = $this->model_support->getData('tbl_category', '*', "", "", $order);
        $this->load->view("table_category", $data);
    }
    public function add_category()
    {
        $data['title'] = "Add Category";
        $this->load->view("add_category", $data);
    }

    public function edit_category($cid)
    {
        $cid = (int) $cid;
        $where = "cid=$cid";
        $result = $this->model_support->getData('tbl_category', '*', "", $where);
        if ($result && count($result) > 0) {
            $data['category'] = $result[0];
            $data['title'] = "Edit Category";
            $this->load->view("add_category", $data);
        } else {
            $this->session->set_flashdata('msg', "Category not found.Please try another.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url()."admin/category");
        }
    }
    public function category_save()
    {
        $category_id = (int) $this->input->post('cid');
        $this->form_validation->set_rules('category_name', '', 'trim|required');
        $this->form_validation->set_rules('category_image', '', 'callback_check_image');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($category_id) {
                $this->edit_category($category_id);
            } else {
                $this->add_category();
            }
        } else {
            $old_image = $this->input->post('hidden_image');
            if (isset($_FILES['category_image']) && $_FILES['category_image']['name'] != '') {
                $uploadPath = dirname(BASEPATH) . "/" . uploads_path . 'category';
                $tmp_name = $_FILES["category_image"]["tmp_name"];
                $temp = explode(".", $_FILES["category_image"]["name"]);
                $newfilename = (uniqid()) . '.' . end($temp);
                move_uploaded_file($tmp_name, "$uploadPath/$newfilename");

                if (isset($old_image) && $old_image != "") {
                    if (file_exists(FCPATH . uploads_path . "category/" . $old_image)) {
                        unlink(FCPATH . uploads_path . "category/" . $old_image);
                    }
                }
            }
            $insert = array(
                'category_name' => $this->input->post('category_name'),
                'category_image' => isset($newfilename) ? $newfilename : $old_image,
                'status' => $this->input->post('status'),
            );
            //Check for update
            if ($category_id > 0) {

                $insert['updated_on'] = date('Y-m-d H:i:s');
                $this->model_support->update('tbl_category', $insert, "cid='$category_id'");
                $this->session->set_flashdata('msg', "Category updated successfully.");
                $this->session->set_flashdata('msg_class', 'success');
                redirect(base_url()."admin/category");
            } else {
                $insert['created_on'] = date('Y-m-d H:i:s');
                $this->model_support->insert('tbl_category', $insert);
                $this->session->set_flashdata('msg', "Category added successfully");
                $this->session->set_flashdata('msg_class', 'success');
                redirect(base_url()."admin/category");
            }
        }
    }

    public function delete_category($cid)
    {
        $where_cid = "cat_id=$cid";
        $result = $this->model_support->getData('tbl_recipes', 'rid,recipes_image', '', $where_cid);
        if (isset($result) && count($result) > 0) {
            foreach ($result as $row) {
                $image_array = json_decode($row['recipes_image']);
                if (!empty($image_array)) {
                    foreach ($image_array as $image_row) {
                        if (file_exists(FCPATH . uploads_path . 'recipes/' . $image_row)) {
                            unlink(FCPATH . uploads_path . 'recipes/' . $image_row);
                        }
                    }
                }
                $rid = $row['rid'];
                $this->model_support->delete('tbl_ingredients', "rid=$rid");
                $this->model_support->delete('tbl_bookmark', "recipe_id=$rid");
                $this->model_support->delete('tbl_comment', "recipe_id=$rid");
                $this->model_support->delete('tbl_recipes', "rid=$rid");
            }
        }
        $where = "cid=$cid";
        $image = $this->model_support->getData('tbl_category', 'category_image', '', $where);
        if (file_exists(FCPATH . uploads_path . 'category/' . $image[0]['category_image'])) {
            unlink(FCPATH . uploads_path . 'category/' . $image[0]['category_image']);
        }
        $this->model_support->delete('tbl_category', $where);
        $this->session->set_flashdata('msg', "Category deleted successfully.");
        $this->session->set_flashdata('msg_class', 'success');
        exit;

    }

    public function check_image()
    {
        $id = $this->input->post('cid');
        if (isset($id) && $id != '') {
            $new_logo = $_FILES['category_image']['name'];
            if (isset($new_logo) && $new_logo != '') {
                $image = $_FILES['category_image']['name'];
            } else {
                $image = $this->input->post('hidden_image');
            }
        } else {
            $image = $_FILES['category_image']['name'];
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
    public function check_category_name()
    {
        $cid = (int) $this->input->post('cid');
        $category_name = trim($this->input->post('category_name'));
        if (isset($cid) && $cid > 0) {
            $where = "category_name='$category_name' AND cid!='$cid'";
        } else {
            $where = "category_name='$category_name'";
        }
        $check_name = $this->model_support->getData("tbl_category", "category_name", "", $where);
        if (isset($check_name) && count($check_name) > 0) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }
    public function delete_category_image($id)
    {
        $where = "cid='$id'";
        $data = $this->model_support->getData('tbl_category', 'category_image', '', $where);
        if (isset($data) && $data[0]['category_image'] != '') {
            $update['category_image'] = "";
            $res = $this->model_support->update('tbl_category', $update, "cid='$id'");
            if ($res) {
                if (file_exists(FCPATH . uploads_path . 'category/' . $data[0]['category_image'])) {
                    unlink(FCPATH . uploads_path . 'category/' . $data[0]['category_image']);
                }
                echo "true";
                exit;
            }
        } else {
            echo "false";
            exit;
        }
    }

}

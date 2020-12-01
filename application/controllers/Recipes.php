<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Recipes extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authenticate->check_admin();
        date_default_timezone_set(get_time_zone());
        $this->load->model('model_support');
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');

    }

    public function settodayrecipe()
    {
        $rid = $this->input->post('rid');
        $where = array("rid"=>$rid);
        $setupdate = array("today_recipe"=>"1");
        $delupdate = array("today_recipe"=>"0");
        $this->common_model->updateTableData("tbl_recipes", array() , $delupdate);
        $this->common_model->updateTableData("tbl_recipes",$where , $setupdate);
    }

    public function deltodayrecipe()
    {
        $rid = $this->input->post('rid');
        $where = array("rid"=>$rid);
        $update = array("today_recipe"=>"0");
        $this->common_model->updateTableData("tbl_recipes",$where , $update);
    }

    public function index()
    {
        $join = array(
            array(
                "table" => "tbl_category",
                "condition" => "tbl_category.cid=tbl_recipes.cat_id",
                "jointype" => "LEFT"),
        );
        $order = "tbl_recipes.rid  desc";
        $data['recipes'] = array();
        $recipes = $this->model_support->getData("tbl_recipes", "tbl_recipes.*,tbl_category.category_name,tbl_category.cid", $join, "", $order);
        foreach($recipes as $recipe){
            $join = array(
                array(
                    "table" => "tbl_category",
                    "condition" => "tbl_category.cid=tbl_recipe_category.cid",
                    "jointype" => "LEFT"),
            );
            $cids = $this->model_support->getData('tbl_recipe_category', 'tbl_recipe_category.cid, tbl_category.category_name', $join, "rid=".$recipe['rid']);
            $item = array("recipe" => $recipe, "cids" => $cids);
            array_push($data['recipes'], $item);
        }
        // var_dump($data['recipes']);die();
        $data['title'] = "Manage Recipes";
        $this->load->view("table_recipes", $data);
    }

    public function add_recipes()
    {
        $data['title'] = "Add Recipe";
        $data['category'] = $this->model_support->getData('tbl_category', '*', array(), '', 'category_name ASC');
        $data['measurement'] = $this->model_support->getData('tbl_measurement', '*', array(), '', 'measurement_name ASC');
        $this->load->view("add_recipes", $data);
    }

    public function edit_recipes($rid)
    {
        $rid = (int)$rid;
        $where = "rid=$rid";
        $join = array(
            array(
                "table" => "tbl_category",
                "condition" => "tbl_category.cid=tbl_recipes.cat_id",
                "jointype" => "LEFT"),
        );

        $result = $this->model_support->getData('tbl_recipes', 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid', $join, $where);
        $cids = $this->model_support->getData('tbl_recipe_category', 'tbl_recipe_category.cid', array(), $where);
        if ($result && count($result) > 0) {
            $data['recipes'] = $result[0];
            $data['cids'] = $cids;
            $data['title'] = "Edit Recipe";
            $data['category'] = $this->model_support->getData('tbl_category', '*', array(), '', 'category_name ASC');
            $data['measurement'] = $this->model_support->getData('tbl_measurement', '*', array(), '', 'measurement_name ASC');
            $where_rid = "rid=$rid";
            $data['ingredients'] = $this->model_support->getData("tbl_ingredients", "*", "", $where_rid);
            $this->load->view("add_recipes", $data);
        } else {
            $this->session->set_flashdata('msg', "Recipe not found.");
            $this->session->set_flashdata('msg_class', 'failure');
            redirect(base_url()."admin/recipes");
        }
    }

    public function recipes_save()
    {
        $recipes_id = (int)$this->input->post('rid');
        $this->form_validation->set_rules('recipes_heading', '', 'trim|required');
        $this->form_validation->set_rules('recipes_time', 'Cooking time', 'trim|integer|required|is_natural_no_zero');
        $this->form_validation->set_rules('direction[]', '', 'trim|required');
        $this->form_validation->set_rules('ingredient_name[]', '', 'trim|required');
        $this->form_validation->set_rules('summary', '', 'trim|required');
        $this->form_validation->set_rules('serving_person', 'Serving person', 'trim|required|integer|is_natural_no_zero');
        $this->form_validation->set_rules('recipes_image[]', '', 'callback_check_image');
        $this->form_validation->set_rules('calories', '', 'trim');
        $this->form_validation->set_rules('youtube_link', '', 'trim');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($recipes_id) {
                $this->edit_recipes($recipes_id);
            } else {
                $this->add_recipes();
            }
        } else {
            $old_img = array();
            if (isset($recipes_id) && $recipes_id != '') {
                $old_img = $this->input->post("old_image[]");
            }
            if (isset($_FILES['recipes_image']) && $_FILES['recipes_image']['name'][0] != '') {
                if (isset($recipes_id) && $recipes_id != '') {
                    $result_image = $this->model_support->getData('tbl_recipes', 'recipes_image', array(), "rid=$recipes_id ");
                    $old_img = json_decode($result_image[0]['recipes_image']);
                }
                $count = count($_FILES['recipes_image']['name']);
                $all_img = array();
                if ($count && !empty($count)) {
                    for ($i = 0; $i < $count; $i++) {
                        $uploadPath = dirname(BASEPATH) . "/" . uploads_path . 'recipes';
                        $tmp_name = $_FILES['recipes_image']['tmp_name'][$i];
                        $temp = explode(".", $_FILES['recipes_image']['name'][$i]);
                        if (end($temp) == "gif" || end($temp) == "png" || end($temp) == "jpeg" || end($temp) == "jpg") {
                            $new_img = (uniqid()) . '.' . end($temp);
                            move_uploaded_file($tmp_name, "$uploadPath/$new_img");
                            array_push($all_img, $new_img);
                        }
                    }
                }
                if (empty($old_img)) {
                    $old_img = array();
                }
                $final_all_img = array_merge($all_img, $old_img);
            }
            $direction = $this->input->post("direction[]");
            $direction_array = array();
            foreach ($direction as $row) {
                if ($row != '') {
                    array_push($direction_array, $row);
                }
            }
            $directionJSON = json_encode($direction_array);

            $ing = array();
            $qty = array();
            $wg = array();
            $ing = $this->input->post("ingredient_name");
            $qty = $this->input->post("quantity");
            $wg = $this->input->post("weight");
            

            $insert = array(
                'recipes_heading' => $this->input->post('recipes_heading'),
                'cat_id' => json_encode($cid_array),
                'recipes_time' => $this->input->post('recipes_time'),
                'summary' => $this->input->post('summary'),
                'serving_person' => $this->input->post("serving_person"),
                'direction' => $directionJSON,
                'calories' => $this->input->post('calories'),
                'youtube_link' => $this->input->post('youtube_link'),
                'recipes_image' => isset($final_all_img) && count($final_all_img) > 0 ? json_encode($final_all_img) : json_encode($old_img),
                'status' => $this->input->post('status'),
                'created_by' => $this->session->userdata('ADMIN_ID'),
            );
            //Check for update
            if ($recipes_id > 0) {
                $insert['updated_on'] = date('Y-m-d  H:i:s');
                $this->model_support->update('tbl_recipes', $insert, "rid='$recipes_id'");
                $this->model_support->delete("tbl_ingredients", 'rid = ' . $recipes_id);

                // add category
                $cids = $this->input->post("cid[]");
                $this->model_support->delete("tbl_recipe_category", 'rid = ' . $recipes_id);
                foreach($cids as $cid){
                    $newCid = array("rid" => $recipes_id, "cid" => $cid);
                    $this->model_support->insert('tbl_recipe_category', $newCid);
                }
                //  add ingredients
                $j = count($ing);
                for ($i = 0; $i < $j; $i++) {
                    if ($ing[$i] != '') {
                        $ins_ing[] = array(
                            "rid" => $recipes_id,
                            "ingredient_name" => $ing[$i],
                            "qty" => isset($qty[$i]) && $qty[$i] !== '' ? $qty[$i] : 1,
                            "weight" => isset($wg[$i]) && $wg[$i] !== '' ? $wg[$i] : 'gm',
                            "updated_on" => date('Y-m-d H:i:s'),
                        );
                    }
                }
                if (isset($ins_ing) && !empty($ins_ing)) {
                    $this->model_support->Add_batch('tbl_ingredients', $ins_ing);
                }

                $this->session->set_flashdata('msg', "Recipe updated successfully");
                $this->session->set_flashdata('msg_class', 'success');

            } else {
                $insert['created_on'] = date('Y-m-d H:i:s');
                $id = $this->model_support->insert('tbl_recipes', $insert);
                // add category
                $cids = $this->input->post("cid[]");
                $this->model_support->delete("tbl_recipe_category", 'rid = ' . $id);
                foreach($cids as $cid){
                    $newCid = array("rid" => $id, "cid" => $cid);
                    $this->model_support->insert('tbl_recipe_category', $newCid);
                }
                //   add ingredients
                $j = count($ing);
                for ($i = 0; $i < $j; $i++) {
                    $ins_ing[] = array(
                        "rid" => $id,
                        "ingredient_name" => $ing[$i],
                        "qty" => isset($qty[$i]) && $qty[$i] !== '' ? $qty[$i] : '1',
                        "weight" => isset($wg[$i]) && $wg[$i] !== '0' ? $wg[$i] : '',
                        "created_on" => date('Y-m-d H:i:s'),
                    );
                }
                if (isset($ins_ing) && !empty($ins_ing)) {
                    $this->model_support->Add_batch('tbl_ingredients', $ins_ing);
                }

                $this->session->set_flashdata('msg', "Recipe added successfully");
                $this->session->set_flashdata('msg_class', 'success');

            }
            redirect(base_url()."admin/recipes");
        }
    }

    public function delete_recipes($rid)
    {

        $image = $this->common_model->getTableData('tbl_recipes', array("rid" => $rid), 'recipes_image')->row();
        $image = json_decode($image->recipes_image);
        if (isset($image) && !empty($image)) {
            foreach ($image as $row) {
                if (file_exists(FCPATH . uploads_path . 'recipes/' . $row)) {
                    unlink(FCPATH . uploads_path . 'recipes/' . $row);
                }
            }
            $this->common_model->deleteTableData('tbl_ingredients', array("rid" => $rid));
            $this->common_model->deleteTableData('tbl_bookmark', array("recipe_id" => $rid));
            $this->common_model->deleteTableData('tbl_comment', array("recipe_id" => $rid));
            $this->common_model->deleteTableData('tbl_recipes', array("rid" => $rid));
            $this->session->set_flashdata('msg', "Recipe deleted successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            exit;
        }
    }
    // check direction field
    // public function check_direction()
    // {
    //     $direction = $this->input->post("direction[]");
    //     if (!empty($direction[0])) {
    //         return true;
    //     } else {
    //         $this->form_validation->set_message('check_direction', 'This field is required.');
    //         return false;
    //     }
    //     return true;

    // }
    public function check_image($image)
    {
        $id = (int)$this->input->post('rid');
        $image = array();
        if ($id) {
            $new_img = array();
            $new_img = $_FILES['recipes_image']['name'];
            if (isset($new_img) && $new_img[0] != '') {
                $image = $_FILES['recipes_image']['name'];
            } else {
                $image = $this->input->post("old_image[]");
            }
        } else {
            $image = $_FILES['recipes_image']['name'];
        }
        if (isset($image) && !empty($image) && $image[0] != '') {
            $allowed_extensions = array("jpg", "jpeg", "png", "gif");
            for ($i = 0; $i < count($image); $i++) {
                $extension = pathinfo($image[$i], PATHINFO_EXTENSION);
                if (!in_array($extension, $allowed_extensions)) {
                    $this->form_validation->set_message('check_image', 'Invalid format. Only jpg / jpeg/ png /gif format allowed.');
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            $this->form_validation->set_message('check_image', 'This field is required.');
            return false;
        }

    }

    public function delete_recipe_image()
    {
        $id = $this->input->post('id');
        $key = $this->input->post('key');
        $value = $this->input->post('value');
        $query = "UPDATE `tbl_recipes` SET `recipes_image`= JSON_REMOVE(recipes_image,'$[$key]') WHERE rid=$id";
        $res = $this->db->query($query);
        if ($res) {
            if ($value != '' && file_exists(FCPATH . uploads_path . "recipes/" . $value)) {
                unlink(FCPATH . uploads_path . "recipes/" . $value);
            }
            echo true;
        } else {
            echo false;
        }
        exit;
    }
}

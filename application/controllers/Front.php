<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Front extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->lang->load('error_message');

    }

    public function index()
    {

        $data['title'] = "Home";
        $search = $this->input->get("search");
        $joins = array(
            'tbl_category' => 'tbl_recipes.cat_id = tbl_category.cid',
            'tbl_user' => 'tbl_user.id =tbl_recipes.created_by',
        );
        if (!empty($search)) {
            $query = "SELECT `tbl_recipes`.*, `tbl_category`.`category_name`, `tbl_category`.`cid`, CONCAT(`tbl_user`.`firstname`,' ',`tbl_user`.`lastname`) as `created_by` FROM `tbl_recipes` LEFT JOIN `tbl_category` ON `tbl_recipes`.`cat_id` = `tbl_category`.`cid` LEFT JOIN `tbl_user` ON `tbl_user`.`id` =`tbl_recipes`.`created_by` WHERE `tbl_recipes`.`status` = 'A' AND (`tbl_recipes`.`recipes_heading` LIKE '%$search%' OR `tbl_category`.`category_name` LIKE '%$search%') ORDER BY `tbl_recipes`.`rid` DESC";
            $recipes = $this->db->query($query)->result();
        } else {
            // $recipes = $this->common_model->getleftJoinedTableData('tbl_recipes', $joins, array("tbl_recipes.status" => "A"), 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by', array(), array(), array(), "", "", array("tbl_recipes.rid", "desc"))->result();
            $category_array = array();
            $recipes = array();
            $category = $this->common_model->getTableData('tbl_category', array("status" => "A"), '*', array(), array(), array(), "", "", array("cid", "desc"))->result();
            if (isset($category) && !empty($category)) {
                foreach ($category as $row) {
                    $total_recipe = count_category_recipe($row->cid);
                    if ($total_recipe > 0) {
                        array_push($category_array, $row);
                        $recipe_category = $this->common_model->getleftJoinedTableData('tbl_recipes', $joins, array("tbl_recipes.status" => "A", "cat_id" => $row->cid), 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by', array(), array(), array(), "", 8, array("tbl_recipes.rid", "desc"))->result();
                        foreach ($recipe_category as $recipe_row) {
                            array_push($recipes, $recipe_row);
                        }
                    }
                }
            }
            $data['category'] = $category_array;
        }
        $data['recipes'] = $recipes;
        $this->load->view("front/home", $data);
    }

    public function bookmark_recipe()
    {
        $this->authenticate->check_user();
        $user_id = $this->session->userdata("USER_ID");
        $search = $this->input->get("search");
        $joins = array(
            'tbl_category' => 'tbl_recipes.cat_id = tbl_category.cid',
            'tbl_user' => 'tbl_user.id =tbl_recipes.created_by',
        );
        $my_recipe = $this->common_model->getTableData('tbl_bookmark', array("user_id" => $user_id), '*', array(), array(), array(), "", "", array("id", "desc"))->result();
        $recipes = array();
        if (isset($my_recipe) && !empty($my_recipe)) {
            foreach ($my_recipe as $row) {
                $single_recipes = $this->common_model->getleftJoinedTableData('tbl_recipes', $joins, array("tbl_recipes.status" => "A", "tbl_recipes.rid" => $row->recipe_id), 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by', array(), array(), array(), "", "", array("tbl_recipes.rid", "desc"))->row();
                array_push($recipes, $single_recipes);
            }
        }
        $data['title'] = "Bookmark";
        $data['category_name'] = "Bookmark";
        $data['recipes'] = $recipes;
        $this->load->view("front/category_recipes", $data);
    }

    public function recipe_detail($rid)
    {
        $rid = (int)$rid;
        $search = $this->input->get("search");
        $join = array(
            "tbl_recipe_category" => "tbl_recipe_category.rid=tbl_recipes.rid",
            "tbl_category" => "tbl_category.cid=tbl_recipe_category.cid",
            'tbl_user' => 'tbl_user.id =tbl_recipes.created_by',
        );
        if (!empty($search)) {
            $query = "SELECT `tbl_recipes`.*, `tbl_category`.`category_name`, `tbl_category`.`cid`, CONCAT(`tbl_user`.`firstname`,' ',`tbl_user`.`lastname`) as `created_by` FROM `tbl_recipes` LEFT JOIN `tbl_recipe_category` ON `tbl_recipes`.`rid` = `tbl_recipe_category`.`rid`  LEFT JOIN `tbl_category` ON `tbl_recipe_category`.`cid` = `tbl_category`.`cid` LEFT JOIN `tbl_user` ON `tbl_user`.`id` =`tbl_recipes`.`created_by` WHERE `tbl_recipes`.`status` = 'A' AND (`tbl_recipes`.`recipes_heading` LIKE '%$search%' OR `tbl_category`.`category_name` LIKE '%$search%') ORDER BY `tbl_recipes`.`rid` DESC";
            $recipes = $this->db->query($query)->result();
            $data['recipes'] = $recipes;
            $this->load->view("front/home", $data);
        } else {
            $fields = 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,tbl_user.profile_image as profile_image,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by';
            $result = $this->common_model->getleftJoinedTableData('tbl_recipes', $join, array('tbl_recipes.rid' => $rid), $fields)->row();
            if ($result && !empty($result)) {
                $data['recipe'] = $result;
                $data['title'] = "Recipe detail";
                $data['recent_recipes'] = $this->common_model->getleftJoinedTableData('tbl_recipes', array('tbl_category' => 'tbl_recipes.cat_id = tbl_category.cid'), array("tbl_recipes.status" => "A"), 'tbl_recipes.*,tbl_category.category_name', array(), array(), array(), "", "4", array("tbl_recipes.rid", "desc"))->result();
                // $data['category']  = $this->common_model->getTableData('tbl_category',array("status" => "A"), '*', array(), array(), array(), "", "", array("category_name", "desc"))->result();
                $data['ingredients'] = $this->common_model->getTableData('tbl_ingredients', array("rid" => $rid), '*', array(), array(), array(), "", "", array("id", "asc"))->result();
                $this->load->view("front/recipe_detail", $data);
            } else {
                $this->session->set_flashdata('msg', "Recipe not found.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url());
            }
        }
    }

    public function category()
    {
        $alldata['title'] = "Categories";
        $search = $this->input->get("search");
        $like = array();
        if (!empty($search)) {
            $like = array(
                "tbl_category.category_name" => $search,
            );
        }
        $category = $this->common_model->getleftJoinedTableData('tbl_category', array(), array("status" => "A"), '*', $like, array(), array(), "", "", array("cid", "desc"))->result();
        $all_category = array();

        if ($category && count($category) > 0) {
            foreach ($category as $row) {
                $data = array();
                $total = $this->common_model->getTableData('tbl_recipes', array("cat_id" => $row->cid, "status" => "A"), 'rid', array(), array(), array(), "", "", array())->result();
                $data['cid'] = $row->cid;
                $data['category_name'] = $row->category_name;
                $data['category_image'] = $row->category_image;
                $data['status'] = isset($row->status) && $row->status == "A" ? "Active" : "Inactive";
                $data['category_image'] = $row->category_image;
                $data['total_recipes'] = count($total);
                array_push($all_category, $data);
            }
        }
        $alldata['category'] = $all_category;
        $this->load->view("front/category", $alldata);
    }

    public function category_recipes($category_id)
    {
        $category_id = (int)$category_id;
        $data['title'] = "Home";
        $search = $this->input->get("search");
        $joins = array(
            // 'tbl_category' => 'tbl_recipes.cat_id = tbl_category.cid',
            'tbl_recipe_category' => 'tbl_recipe_category.rid = tbl_recipes.rid',
            'tbl_category' => 'tbl_recipe_category.cid = tbl_category.cid',
            'tbl_user' => 'tbl_user.id =tbl_recipes.created_by',
        );
        $fields = 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by';
        if (!empty($search)) {
            $query = "SELECT `tbl_recipes`.*, `tbl_category`.`category_name`, `tbl_category`.`cid`, CONCAT(`tbl_user`.`firstname`,' ',`tbl_user`.`lastname`) as `created_by` FROM `tbl_recipes` LEFT JOIN `tbl_recipe_category` ON `tbl_recipes`.`cid` = `tbl_recipe_category`.`rid`  LEFT JOIN `tbl_category` ON `tbl_recipe_category`.`cid` = `tbl_category`.`cid` LEFT JOIN `tbl_user` ON `tbl_user`.`id` =`tbl_recipes`.`created_by` WHERE `tbl_recipes`.`status` = 'A' AND (`tbl_recipes`.`recipes_heading` LIKE '%$search%' OR `tbl_category`.`category_name` LIKE '%$search%') ORDER BY `tbl_recipes`.`rid` DESC";
            // $query = "SELECT `tbl_recipes`.*, `tbl_category`.`category_name`, `tbl_category`.`cid`, CONCAT(`tbl_user`.`firstname`,' ',`tbl_user`.`lastname`) as `created_by` FROM `tbl_recipes` LEFT JOIN `tbl_category` ON `tbl_recipes`.`cat_id` = `tbl_category`.`cid` LEFT JOIN `tbl_user` ON `tbl_user`.`id` =`tbl_recipes`.`created_by` WHERE `tbl_recipes`.`status` = 'A' AND (`tbl_recipes`.`recipes_heading` LIKE '%$search%' OR `tbl_category`.`category_name` LIKE '%$search%') ORDER BY `tbl_recipes`.`rid` DESC";
            $recipes = $this->db->query($query)->result();
            $data['recipes'] = $recipes;
            $this->load->view("front/home", $data);
        } else {
            $recipes = $this->common_model->getleftJoinedTableData('tbl_recipes', $joins, array("tbl_recipes.status" => "A", "tbl_recipe_category.cid" => $category_id), $fields, array(), array(), array(), "", "", array("tbl_recipes.rid", "desc"))->result();
            $category_name = $this->common_model->getTableData('tbl_category', array("status" => "A", "cid" => $category_id), 'category_name', array(), array(), array(), "", "", array("cid", "desc"))->row();
            $data['recipes'] = $recipes;
            $data['category_name'] = $category_name->category_name;
            $this->load->view("front/category_recipes", $data);
        }
    }

    // rating
    public function user_rating()
    {
        $rid = $this->input->post('rid');
        $user_id = $this->input->post('user_id');
        $ratingValue = $this->input->post('ratingValue');

        $data = array(
            'user_id' => $user_id,
            'recipe_id' => $rid,
            'rating' => $ratingValue,
        );
        $old_rating = $this->common_model->getTableData('tbl_rating', array("recipe_id" => $rid, "user_id" => $user_id), '*')->row();
        if (isset($old_rating) && !empty($old_rating)) {
            $data['updated_on'] = date('Y-m-d H:i:s');
            $upd_id = $this->common_model->updateTableData('tbl_rating', array('id' => $old_rating->id), $data);
            if ($upd_id) {
                $query = "SELECT AVG(rating) as rating FROM `tbl_rating` WHERE `recipe_id` = $rid";
                $res = $this->db->query($query)->row();
                $total_rating = get_star($res->rating);
                $user_rating = get_star($ratingValue, 'Y');
                echo json_encode(array("total_rating" => $total_rating, "user_rating" => $user_rating, "rating" => round($res->rating, 1)));
                exit;
            } else {
                echo false;
                exit;
            }
        } else {
            $data['created_on'] = date('Y-m-d H:i:s');
            $ins_id = $this->common_model->insertTableData('tbl_rating', $data);
            if ($ins_id) {
                $query = "SELECT AVG(rating) as rating FROM `tbl_rating` WHERE `recipe_id` = $rid";
                $res = $this->db->query($query)->row();
                $total_rating = get_star($res->rating);
                $user_rating = get_star($ratingValue, 'Y');
                echo json_encode(array("total_rating" => $total_rating, "user_rating" => $user_rating, "rating" => round($res->rating, 1)));
                exit;
            } else {
                echo false;
                exit;
            }
        }

    }

    // comment
    public function comment_save()
    {
        $id = "";
        $recipe_id = $this->input->post('recipe_id');
        $user_id = $this->input->post('user_id');
        $comment = trim($this->input->post('comment'));
        if ($comment == '') {
            echo json_encode(array("status" => false, "data" => "This field is required."));
            exit;
        } else {
            $data = array(
                "recipe_id" => $recipe_id,
                "user_id" => $user_id,
                "comment" => $comment,
                "comment_reply_id" => 0,
                "comment_type" => "C",
            );
            if ($id) {
                $data['update_on'] = date('Y-m-d H:i:s');
                $this->common_model->updateTableData('tbl_comment', array('id' => ""), $data);
            } else {
                $data['created_on'] = date('Y-m-d H:i:s');
                $ins_id = $this->common_model->insertTableData('tbl_comment', $data);
            }
            $user = $this->common_model->getTableData("tbl_user", array("id" => $user_id))->row();
            $comment_date = $this->common_model->getTableData("tbl_comment", array("id" => $ins_id), 'created_on')->row();
            $data['user'] = $user;
            $data['comment'] = $comment;
            $data['comment_id'] = $ins_id;
            $data['comment_type'] = "C";
            $data['comment_date'] = $comment_date->created_on;
            $html = $this->load->view("front/single_comment_html", $data, true);

            $total_comment_query = "SELECT * FROM `tbl_comment` WHERE recipe_id=$recipe_id AND status='A'";
            $total_comment = $this->db->query($total_comment_query)->num_rows();
            echo json_encode(array("status" => true, "data" => $html, "total_comment" => $total_comment));
            exit;
        }
    }

    // reply comment
    public function reply_comment_save()
    {
        $id = "";
        $recipe_id = $this->input->post('recipe_id');
        $user_id = $this->input->post('user_id');
        $reply_comment = trim($this->input->post('reply_comment'));

        if ($reply_comment == '') {
            echo json_encode(array("status" => false, "data" => "This field is required."));
            exit;
        } else {
            $data = array(
                'recipe_id' => $recipe_id,
                "user_id" => $user_id,
                "comment" => $reply_comment,
                "comment_reply_id" => $this->input->post('reply_comment_id'),
                "comment_type" => "R",
            );
            if ($id) {
                $data['update_on'] = date('Y-m-d H:i:s');
                $this->common_model->updateTableData('tbl_comment', array('id' => ""), $data);
            } else {
                $data['created_on'] = date('Y-m-d H:i:s');
                $ins_id = $this->common_model->insertTableData('tbl_comment', $data);
            }
            $user = $this->common_model->getTableData("tbl_user", array("id" => $user_id))->row();
            $comment_date = $this->common_model->getTableData("tbl_comment", array("id" => $ins_id), 'created_on')->row();
            $data['user'] = $user;
            $data['comment'] = $reply_comment;
            $data['comment_type'] = "R";
            $data['comment_id'] = $this->input->post('reply_comment_id');
            $data['comment_date'] = $comment_date->created_on;
            $html = $this->load->view("front/single_comment_html", $data, true);
            $total_comment_query = "SELECT * FROM `tbl_comment` WHERE  recipe_id=$recipe_id AND status='A'";
            $total_comment = $this->db->query($total_comment_query)->num_rows();
            echo json_encode(array("status" => true, "data" => $html, "total_comment" => $total_comment));
            exit;
        }
    }

    // contact
    public function contact()
    {
        $data['title'] = "Contact";
        $this->load->view("front/contact", $data);
    }

    public function contact_save()
    {
        $this->form_validation->set_rules('name', '', 'trim|required');
        $this->form_validation->set_rules('message', '', 'trim|required');
        $this->form_validation->set_rules('email', '', 'trim|valid_email|required');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            $this->contact();
        } else {
            $insert = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'message' => $this->input->post('message'),
                'subject' => $this->input->post('subject'),
            );
            $insert['created_on'] = date('Y-m-d H:i:s');
            $ins_id = $this->common_model->insertTableData('tbl_contact', $insert);
            if ($ins_id) {
                $admin_data = $this->common_model->getTableData("tbl_user", array("user_type" => "A", "status" => "A"))->row();
                $insert['admin_name'] = ucfirst($admin_data->firstname) . " " . ucfirst($admin_data->lastname);
                $html = $this->load->view("email_template/contact_html", $insert, true);
                $subject = "Contact request";
                $define_param['to_name'] = ucfirst($admin_data->firstname) . " " . ucfirst($admin_data->lastname);
                $define_param['to_email'] = $admin_data->email;
                $send = $this->sendmail->send($define_param, $subject, $html);
                if ($send->status) {
                    $this->session->set_flashdata('msg', "Contact request has been sent successfully.We will reply you as soon as possible.");
                    $this->session->set_flashdata('msg_class', 'success');
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('something_went_wrong'));
                    $this->session->set_flashdata('msg_class', 'failure');
                }
            }
            redirect('contact');
        }
    }

    // bookmark
    public function bookmark_save()
    {
        $id = "";
        $recipe_id = $this->input->post('recipe_id');
        $user_id = $this->input->post('user_id');
        $bookmark = $this->common_model->getTableData("tbl_bookmark", array("recipe_id" => $recipe_id, "user_id" => $user_id))->row();
        if (isset($bookmark) && !empty($bookmark)) {
            $del = $this->common_model->deleteTableData('tbl_bookmark', array("recipe_id" => $recipe_id, "user_id" => $user_id));
            if ($del) {
                echo json_encode(array("status" => true, "code" => 0, "message" => "Bookmark remove"));
                exit;
            }
        } else {
            $data = array(
                'recipe_id' => $recipe_id,
                "user_id" => $user_id,
            );
            if ($id) {
                $data['update_on'] = date('Y-m-d H:i:s');
                $this->common_model->updateTableData('tbl_bookmark', array('id' => ""), $data);
            } else {
                $data['created_on'] = date('Y-m-d H:i:s');
                $this->common_model->insertTableData('tbl_bookmark', $data);
                echo json_encode(array("status" => true, "code" => 1, "message" => "Bookmark save"));
                exit;
            }
        }

    }
}

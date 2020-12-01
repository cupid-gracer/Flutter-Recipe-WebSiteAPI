<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
require APPPATH . '/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class Recipes extends REST_Controller
{

    public $key;

    public function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('common_model');
        date_default_timezone_set(get_time_zone());
        $this->key = "6JPN3cFCkCcSajuQUze5kwK0muEnoq";
        $this->lang->load('error_message');
    }

    public function check_key($key)
    {
        if ($this->key == $key) {
            return true;
        } else {
            return false;
        }
    }

    public function verify_token($idToken)
    {
        if ($idToken) {
            $serviceAccount = ServiceAccount::fromJsonFile(FCPATH . 'service-account-file.json');
            $firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();
            try {
                $verifiedIdToken = $firebase->getAuth()->verifyIdToken($idToken);
                $uid = $verifiedIdToken->getClaim('sub');
                $result = $firebase->getAuth()->getUser($uid);
                if (isset($result) && !empty($result)) {
                    $user = (object)$result->providerData[0];
                    if (isset($user) && !empty($user)) {
                        $userData = $this->common_model->getTableData('tbl_user', array('user_type' => 'C', 'email' => $user->email), '*')->row();
                        if (isset($userData) && !empty($userData)) {
                            if ($userData->status == "A" && $userData->register_type == SSO) {
                                return (object)array("user_id" => $userData->id);
                            } else if ($userData->status == "I") {
                                $update['updated_on'] = date('Y-m-d H:i:s');
                                $update['register_type'] = SSO;
                                $update['password'] = "";
                                $update['status'] = 'A';
                                $this->common_model->updateTableData('tbl_user', array("id" => $userData->id), $update);
                                $this->common_model->updateTableData('tbl_comment', array("user_id" => $userData->id), array("status" => "A"));
                                return (object)array("user_id" => $userData->id);
                            } else if ($userData->status == "A" && $userData->register_type == GENERAL) {
                                return (object)array("user_id" => "", "message" => $this->lang->line('already_sign_up_with_email'));
                            } else {
                                return (object)array("user_id" => "", "message" => $this->lang->line('account_already_exist_but_not_verified'));
                            }
                        } else {
                            $insert = array(
                                'firstname' => $user->displayName,
                                'lastname' => "",
                                'email' => $user->email,
                                'phone' => $user->phoneNumber,
                                'user_type' => "C", //C=customer ,A=admin
                                'register_type' => SSO, //SSO =single sign-on GENERAL =General
                                'profile_image' => $user->photoUrl,
                                'created_on' => date('Y-m-d H:i:s'),
                            );
                            $ins_id = $this->common_model->insertTableData('tbl_user', $insert);
                            return (object)array("user_id" => $ins_id);
                        }
                    } else {
                        return (object)array("user_id" => "", "message" => "Something went wrong.");
                    }
                } else {
                    return (object)array("user_id" => "", "message" => "Something went wrong.");
                }
            } catch (Exception $e) {
                return (object)array("user_id" => "", "message" => $e->getMessage());
            }
        } else {
            return (object)array("user_id" => "", "message" => $this->lang->line('no_token_provide'));
        }
    }

    public function check_token($token)
    {
        if ($token) {
            try {
                $user = $this->implementjwt->DecodeToken($token);
                return (object)$user;
            } catch (Exception $e) {
                return (object)array("user_id" => "", "message" => $e->getMessage());
            }
        } else {
            return (object)array("user_id" => "", "message" => $this->lang->line('no_token_provide'));
        }
    }

    /** verify id token */
    public function login_get()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        $result = $this->verify_token($token);
        if (!empty($result) && $result->user_id != '') {
            $user_id = $result->user_id;
            $userData = $this->common_model->getTableData('tbl_user', array("status" => "A", 'user_type' => "C", "id" => $user_id), '*')->row();
            $user = $this->get_user($userData);
            $this->response(["status" => true, "code" => 200, "data" => $user], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED);
        }
    }

    /** user login */
    public function login_post()
    {
        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        if ($res) {
            $email = $this->post('email');
            $password = $this->post('password');
            if ($email) {
                if ($password) {
                    $user = $this->common_model->getTableData('tbl_user', array('password' => md5($password), 'email' => $email, 'user_type' => "C"))->row();
                    if (isset($user) && !empty($user) && $user->status == "A") {
                        $data['user_id'] = $user->id;
                        $data['email'] = $user->email;
                        $data['user_type'] = $user->user_type;
                        /** generate token */
                        $jwtToken = $this->implementjwt->GenerateToken($data);
                        $userData = $this->get_user($user);
                        $userData['token'] = $jwtToken;
                        $this->response(["status" => true, "code" => 200, "data" => $userData], REST_Controller::HTTP_OK);
                    } else {
                        if (isset($user) && !empty($user) && $user->status == "EP") {
                            $this->response(['status' => false, "code" => 400, 'message' => $this->lang->line('account_not_verify')], REST_Controller::HTTP_BAD_REQUEST);
                        } else {
                            $this->response(['status' => false, "code" => 400, 'message' => $this->lang->line('invalid_email_password')], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    }
                } else {
                    $this->response(['status' => false, "code" => 400, 'message' => 'Password is required'], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, "code" => 400, 'message' => 'Email is required'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /** User register  */
    public function register_post()
    {
        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        if ($res) {
            $firstname = $this->post('name');
            $email = $this->post('email');
            $password = $this->post('password');
            if ($firstname) {
                if ($email) {
                    $check_email = check_email($email);
                    if ($check_email->status) {
                        $check_password = $this->check_password($password);
                        if ($check_password->status) {
                            $user = $this->common_model->getTableData('tbl_user', array('email' => $email, 'user_type' => "C"))->row();
                            if (isset($user) && !empty($user)) {
                                if ($user->status == "I") {
                                    $insert['register_type'] = GENERAL;
                                    $insert['password'] = md5($password);
                                    $insert['status'] = 'A';
                                    $insert['updated_on'] = date('Y-m-d H:i:s');
                                    $this->common_model->updateTableData('tbl_user', array("id" => $user->id), $insert);
                                    $this->common_model->updateTableData('tbl_comment', array("user_id" => $user->id), array("status" => "A"));
                                    $data['user_id'] = $user->id;
                                    $data['email'] = $user->email;
                                    $data['user_type'] = $user->user_type;
                                    /** generate token */
                                    $jwtToken = $this->implementjwt->GenerateToken($data);
                                    $userData = $this->get_user($user);
                                    $userData['token'] = $jwtToken;
                                    $this->response(["status" => true, "code" => 200, "data" => $userData], REST_Controller::HTTP_OK);
                                } else {
                                    $this->response(['status' => false, "code" => 400, 'message' => $this->lang->line('account_already_exist_but_not_verified')], REST_Controller::HTTP_BAD_REQUEST);
                                }
                            } else {
                                $insert = array(
                                    'firstname' => $firstname,
                                    'lastname' => "",
                                    'email' => $email,
                                    'password' => md5($password),
                                    'phone' => "",
                                    'register_type' => GENERAL,
                                    'user_type' => "C",
                                    "profile_image" => "",
                                    "status" => "EP", //email verification pending
                                    "created_on" => date('Y-m-d H:i:s'),
                                );
                                $ins_id = $this->common_model->insertTableData('tbl_user', $insert);
                                $enc_user_id = $this->general->encryptData($ins_id);
                                $enc_email = $this->general->encryptData($email);
                                $url = base_url('verify-email/' . $enc_user_id . "/" . $enc_email);
                                $name = ucfirst($firstname);

                                // Send email
                                $subject = 'Account register';
                                $define_param['to_name'] = $name;
                                $define_param['to_email'] = $email;

                                $parameter['NAME'] = $name;
                                $parameter['URL'] = $url;
                                $html = $this->load->view("email_template/email_verification", $parameter, true);
                                $send = $this->sendmail->send($define_param, $subject, $html);
                                if ($send->status) {
                                    $this->response(["status" => true, "code" => 200, "message" => $this->lang->line('account_confirmation_text')], REST_Controller::HTTP_OK);
                                } else {
                                    $this->response(["status" => false, "code" => 400, "message" => $this->lang->line('something_went_wrong')], REST_Controller::HTTP_OK);
                                }
                            }
                        } else {
                            $this->response(['status' => false, "code" => 400, 'message' => $check_password->message], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(['status' => false, "code" => 400, 'message' => $check_email->message], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(['status' => false, "code" => 400, 'message' => 'Email is required'], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, "code" => 400, 'message' => 'Name is required'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /** get all recipe */
    public function recipes_post()
    {

        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        $user_id = isset($result) && $result->user_id != '' ? $result->user_id : '';
        if ($res) {
            $search = trim($this->post("search"));
            $category_id = $this->post("category_id"); //get recipe from category id;
            $bookmark = $this->post("bookmark"); //get user bookmarked recipe 1=true;
            $limit = $this->post("limit");
            $offset = $this->post("offset");

            $like = array();
            if ($category_id) {
                // $where = array("tbl_recipes.cat_id" => $category_id, "tbl_recipes.status" => "A");
                $where = array("tbl_recipe_category.cid" => $category_id, "tbl_recipes.status" => "A");
            } else {
                $where = array("tbl_recipes.status" => "A");
            }
            $join = array(
                "tbl_user" => "tbl_user.id=tbl_recipes.created_by",
                "tbl_recipe_category" => "tbl_recipes.rid=tbl_recipe_category.rid",
                "tbl_category" => "tbl_category.cid=tbl_recipe_category.cid",
            );
            $fields = 'tbl_recipes.*,tbl_category.category_name,tbl_user.profile_image as creator_image,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by';

            if ($search != '') {
                $this->db->select($fields);
                // $this->db->join('tbl_category', 'tbl_category.cid = tbl_recipes.cat_id', 'left');
                $this->db->join('tbl_category', 'tbl_category.cid = tbl_recipe_category.cid', 'left');
                $this->db->join('tbl_user', 'tbl_user.id = tbl_recipes.created_by', 'left');
                $this->db->order_by('tbl_recipes.rid', 'desc');
                $this->db->from('tbl_recipes');
                $where = "tbl_recipes.status= 'A' AND(tbl_category.category_name LIKE '%$search%' ESCAPE '!' OR tbl_recipes.recipes_heading LIKE '%$search%' ESCAPE '!')";
                $this->db->where($where);
                $recipes = $this->db->get()->result();
            } elseif ($bookmark == 1) {
                $recipes = array();
                $bookmark_data = $this->common_model->getTableData("tbl_bookmark", array("user_id" => $user_id), "recipe_id", array(), array(), array(), $offset, $limit, array("id", "desc"))->result();
                if (isset($bookmark_data) && !empty($bookmark_data)) {
                    foreach ($bookmark_data as $row) {
                        $where_recipe_id = array("tbl_recipes.rid" => $row->recipe_id, "tbl_recipes.status" => "A");
                        $recipe = $this->common_model->getleftJoinedTableData('tbl_recipes', $join, $where_recipe_id, $fields)->row();
                        array_push($recipes, $recipe);
                    }
                }
            } else {
                $recipes = $this->common_model->getleftJoinedTableData('tbl_recipes', $join, $where, $fields, array(), array(), array(), $offset, $limit, array("tbl_recipes.rid", "desc"),  array("tbl_recipes.rid"))->result();
            }

            $all_recipes = array();
            if (isset($recipes) && !empty($recipes)) {
                foreach ($recipes as $row) {
                    $recipe = $this->get_recipe($row, $user_id);
                    array_push($all_recipes, $recipe);
                }
                $this->response(["status" => true, "code" => 200, "data" => $all_recipes], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                $this->response(['status' => true, "code" => 200, "data" => $all_recipes], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /* get category */

    public function category_post()
    {
        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        if ($res) {
            $search = trim($this->post("search"));
            $limit = $this->post("limit");
            $offset = $this->post("offset");
            if ($search != '') {
                $this->db->select('*');
                $this->db->order_by('cid', 'desc');
                $this->db->from('tbl_category');
                $where = "status= 'A' AND category_name LIKE '%$search%' ESCAPE '!'";
                $this->db->where($where);
                $category = $this->db->get()->result();
            } else {
                $category = $this->common_model->getTableData('tbl_category', array("status" => "A"), '*', array(), array(), array(), $offset, $limit, array("cid", "desc"))->result();
            }
            if (!empty($category)) {
                $all_category1 = array();
                foreach ($category as $row) {
                    $all_category['cid'] = $row->cid;
                    $all_category['category_name'] = $row->category_name;
                    if ($row->category_image != '' && file_exists(FCPATH . uploads_path . "category/" . $row->category_image)) {
                        $all_category['category_image_url'] = base_url(uploads_path . "category/" . $row->category_image);
                    } else {
                        $all_category['category_image_url'] = base_url() . NO_CATEGORY_IMAGE;
                    }
                    array_push($all_category1, $all_category);
                }
                $this->response(['status' => true, "code" => 200, 'data' => $all_category1], REST_Controller::HTTP_OK);
            } else {
                $this->response(['status' => true, "code" => 200, 'data' => array()], REST_Controller::HTTP_OK);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }


    public function get_setting_get()
    {
        $this->db->select('is_facebook_login,is_google_login');
        $this->db->from('tbl_site_config');
        $tbl_site_config = $this->db->get()->row_array();
        $this->response(['status' => true, "code" => 200, 'data' => $tbl_site_config], REST_Controller::HTTP_OK);
    }

    /* update profile */

    public function update_profile_post()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $user_id = $result->user_id;
            $firstname = $this->post('name');
            if ($firstname) {
                $lastname = $this->post("lastname");
                $phone = $this->post('phone');
                $result = $this->common_model->getTableData('tbl_user', array("id" => $user_id), '*')->row();
                if (isset($result) && !empty($result)) {
                    if (isset($_FILES['profile_image']['name']) && $_FILES['profile_image']['name'] != '') {
                        $uploadPath = dirname(BASEPATH) . "/" . uploads_path . 'profile';
                        $tmp_name = $_FILES["profile_image"]["tmp_name"];
                        $temp = explode(".", $_FILES["profile_image"]["name"]);
                        $newfilename = (uniqid()) . '.' . end($temp);
                        move_uploaded_file($tmp_name, "$uploadPath/$newfilename");

                        if (isset($result->profile_image) && $result->profile_image != "") {
                            if (file_exists(FCPATH . uploads_path . "profile/" . $result->profile_image)) {
                                unlink(FCPATH . uploads_path . "profile/" . $result->profile_image);
                            }
                        }
                    }
                    $update_data = array(
                        'firstname' => $firstname,
                        'lastname' => $lastname,
                        'phone' => $phone,
                        'profile_image' => isset($newfilename) && $newfilename != '' ? $newfilename : $result->profile_image,
                    );
                    $update_data['updated_on'] = date('Y-m-d h:i:s');
                    $update = $this->common_model->updateTableData("tbl_user", array("id" => $user_id), $update_data);
                    if ($update) {
                        $where = array("status" => "A", "id" => $user_id);
                        $user = $this->common_model->getTableData('tbl_user', $where, '*')->row();
                        $data = $this->get_user($user);
                        $this->response(['status' => true, 'code' => 200, 'data' => $data], REST_Controller::HTTP_OK);
                    } else {
                        $this->response(['status' => true, 'code' => 200, 'data' => array()], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => 'User were not found.'], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'Name is required.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /*     * Bookmark */

    public function bookmark_post()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $bookmark = $this->post('bookmark');
            $recipe_id = $this->post('recipe_id');
            $user_id = $result->user_id;
            if ($bookmark != '') {
                $result = $this->common_model->getTableData('tbl_recipes', array("rid" => $recipe_id), '*')->row();
                if (isset($result) && !empty($result)) {
                    $bookmark_data = $this->common_model->getTableData("tbl_bookmark", array("recipe_id" => $recipe_id, "user_id" => $user_id))->row();
                    if (isset($bookmark_data) && !empty($bookmark_data)) {
                        if ($bookmark == 0) {
                            $del = $this->common_model->deleteTableData('tbl_bookmark', array("recipe_id" => $recipe_id, "user_id" => $user_id));
                        }
                    } else {
                        if ($bookmark == 1) {
                            $data = array(
                                'user_id' => $user_id,
                                'recipe_id' => $recipe_id,
                            );
                            $data['created_on'] = date('Y-m-d h:i:s');
                            $insert = $this->common_model->insertTableData("tbl_bookmark", $data);
                        }
                    }
                    // get recipe
                    $where = array("tbl_recipes.rid" => $recipe_id);
                    $join = array(
                        "tbl_category" => "tbl_category.cid=tbl_recipes.cat_id",
                        "tbl_user" => "tbl_user.id=tbl_recipes.created_by",
                    );
                    $recipe = $this->common_model->getleftJoinedTableData('tbl_recipes', $join, $where, 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,tbl_user.profile_image as creator_image,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by')->row();
                    if (!empty($recipe)) {
                        $recipe_array = $this->get_recipe($recipe, $user_id);
                        $this->response(['status' => true, 'code' => 200, 'data' => $recipe_array], REST_Controller::HTTP_OK);
                    } else {
                        $this->response(['status' => false, 'code' => 200, 'data' => array()], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => 'Recipe not available'], REST_Controller::HTTP_BAD_REQUEST); //Authentication error the HTTP response code
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'Bookmark is required.'], REST_Controller::HTTP_BAD_REQUEST); //Authentication error the HTTP response code
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /* Rating */

    public function rate_post()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $user_id = $result->user_id;
            $rating = $this->post('rating');
            $recipe_id = (int)$this->post('recipe_id');
            $result = $this->common_model->getTableData('tbl_recipes', array("rid" => $recipe_id), '*')->row();
            if (isset($result) && !empty($result)) {
                if ($rating) {
                    $data = array(
                        'user_id' => $user_id,
                        'recipe_id' => $recipe_id,
                        'rating' => $rating,
                    );
                    $old_rating = $this->common_model->getTableData('tbl_rating', array("recipe_id" => $recipe_id, "user_id" => $user_id), '*')->row();
                    if (isset($old_rating) && !empty($old_rating)) {
                        $data['updated_on'] = date('Y-m-d H:i:s');
                        $upd_id = $this->common_model->updateTableData('tbl_rating', array('id' => $old_rating->id), $data);
                        if ($upd_id) {
                            $query = "SELECT AVG(rating) as rating FROM `tbl_rating` WHERE `recipe_id` = $recipe_id";
                            $res = $this->db->query($query)->row();
                        }
                    } else {
                        $data['created_on'] = date('Y-m-d H:i:s');
                        $ins_id = $this->common_model->insertTableData('tbl_rating', $data);
                        if ($ins_id) {
                            $query = "SELECT AVG(rating) as rating FROM `tbl_rating` WHERE `recipe_id` = $recipe_id";
                            $res = $this->db->query($query)->row();
                        }
                    }

                    // get recipe
                    $where = array("tbl_recipes.rid" => $recipe_id);
                    $join = array(
                        "tbl_category" => "tbl_category.cid=tbl_recipes.cat_id",
                        "tbl_user" => "tbl_user.id=tbl_recipes.created_by",
                    );
                    $recipe = $this->common_model->getleftJoinedTableData('tbl_recipes', $join, $where, 'tbl_recipes.*,tbl_category.category_name,tbl_category.cid,tbl_user.profile_image as creator_image,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as created_by')->row();
                    if (!empty($recipe)) {
                        $recipe_array = $this->get_recipe($recipe, $user_id);
                        $this->response(['status' => true, 'code' => 200, 'data' => array(array("recipe" => $recipe_array, "user_rate" => $rating))], REST_Controller::HTTP_OK);
                    } else {
                        $this->response(['status' => true, 'code' => 200, 'data' => array()], REST_Controller::HTTP_OK);
                    }
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => 'Rate is required.'], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'Recipe not available.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /*     * Post comment */

    public function comment_post()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $user_id = $result->user_id;
            $recipe_id = (int)$this->post('recipe_id');
            $comment = $this->post('comment');
            if ($recipe_id) {
                if ($comment) {
                    $reply_comment_id = $this->post('reply_comment_id');
                    $result = $this->common_model->getTableData('tbl_recipes', array("rid" => $recipe_id), '*')->row();
                    if (isset($result) && !empty($result)) {
                        $data = array(
                            "recipe_id" => $recipe_id,
                            "user_id" => $user_id,
                            "comment" => $comment,
                            "comment_reply_id" => isset($reply_comment_id) && $reply_comment_id != '' ? $reply_comment_id : 0,
                            "comment_type" => isset($reply_comment_id) && $reply_comment_id != '' ? "R" : "C",
                        );
                        $data['created_on'] = date('Y-m-d h:i:s');
                        $insert = $this->common_model->insertTableData("tbl_comment", $data);

                        $where = array("tbl_comment.id" => $insert, "tbl_comment.status" => 'A');
                        $comment = $this->common_model->getleftJoinedTableData('tbl_comment', array("tbl_user" => "tbl_user.id =tbl_comment.user_id"), $where, 'tbl_comment.*,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as comment_by,tbl_user.profile_image as profile_image')->row();
                        if (!empty($comment)) {
                            $commentData = $this->get_comment($comment);
                            $this->response(['status' => true, 'code' => 200, 'data' => $commentData], REST_Controller::HTTP_OK);
                        } else {
                            $this->response(['status' => true, 'code' => 200, 'data' => array()], REST_Controller::HTTP_OK);
                        }
                    } else {
                        $this->response(['status' => false, 'code' => 400, 'message' => 'Recipe not available'], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => 'Comment is required.'], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'Recipe id is required.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /** get comment list by recipe id */
    public function comments_post()
    {
        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        if ($res) {
            $recipe_id = $this->post("recipe_id");
            if ($recipe_id) {
                $offset = $this->post("offset");
                $limit = $this->post("limit");
                $where = array("tbl_comment.recipe_id" => $recipe_id, "tbl_comment.status" => "A");
                $comment = $this->common_model->getleftJoinedTableData('tbl_comment', array("tbl_user" => "tbl_user.id =tbl_comment.user_id"), $where, 'tbl_comment.*,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as comment_by,tbl_user.profile_image as profile_image', array(), array(), array(), $offset, $limit, array("tbl_comment.id", "desc"))->result();
                $comment_array = array();
                if (!empty($comment)) {
                    foreach ($comment as $row) {
                        $data = $this->get_comment($row);
                        array_push($comment_array, $data);
                    }
                    $this->response(['status' => true, "code" => 200, 'data' => $comment_array], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
                } else {
                    $this->response(['status' => true, "code" => 200, 'data' => $comment_array], REST_Controller::HTTP_OK);
                }
            } else {
                $this->response(['status' => false, "code" => 400, 'message' => 'Recipe id is required.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /*     * Change password  */

    public function change_password_post()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $user_id = $result->user_id;
            $current_password = $this->post('current_password');
            $new_password = $this->post('new_password');
            $confirm_password = $this->post('confirm_password');
            if ($current_password) {
                $check_password = $this->check_password($new_password);
                if ($check_password->status) {
                    $check_confirm_password = $this->check_confirm_password($new_password, $confirm_password);
                    if ($check_confirm_password->status) {
                        $current_password_db = $this->common_model->getTableData('tbl_user', array('id' => $user_id), 'password')->row();
                        if (md5($current_password) == $current_password_db->password) {
                            $update = array(
                                'password' => md5($new_password),
                            );
                            $update['updated_on'] = date('Y-m-d H:i:s');
                            $this->common_model->updateTableData('tbl_user', array('id' => $user_id), $update);
                            $this->response(['status' => true, 'code' => 200, 'message' => 'Password updated successfully.'], REST_Controller::HTTP_OK);
                        } else {
                            $this->response(['status' => false, 'code' => 400, 'message' => 'Invalid current password.'], REST_Controller::HTTP_BAD_REQUEST);
                        }
                    } else {
                        $this->response(['status' => false, 'code' => 400, 'message' => $check_confirm_password->message], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => $check_password->message], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'Current password is required.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    /** Forgot password */
    public function forgot_password_post()
    {
        $key = isset($this->_head_args['x-api-key']) ? $this->_head_args['x-api-key'] : "";
        $res = $this->check_key($key);
        if ($res) {
            $email = $this->post("email");
            if ($email) {
                $user = $this->common_model->getTableData('tbl_user', array('email' => $email, "status" => "A", "user_type" => "C"))->row();
                if (!empty($user) && $user->register_type == GENERAL) {
                    $update = array(
                        'forgot_password_code' => uniqid(),
                        'forgot_password_time' => date("Y-m-d H:i:s"),
                        'updated_on' => date("Y-m-d H:i:s"),
                    );
                    $res = $this->common_model->updateTableData('tbl_user', array('email' => $email, "user_type" => "C"), $update);
                    if ($res) {
                        $uniq_id = $this->common_model->getTableData('tbl_user', array('email' => $email, "user_type" => "C"))->row();
                        $url = base_url() . "reset-password/$uniq_id->forgot_password_code";
                        $parameter['URL'] = $url;
                        $html = $this->load->view("email_template/reset_password", $parameter, true);
                        $subject = "Reset password";
                        $define_param['to_name'] = ucfirst($user->firstname) . " " . $user->lastname;
                        $define_param['to_email'] = $user->email;
                        $send = $this->sendmail->send($define_param, $subject, $html);
                        if ($send->status) {
                            $this->response(['status' => true, "code" => 200, "message" => $this->lang->line('reset_password_text')], REST_Controller::HTTP_OK);
                        } else {
                            $this->response(['status' => false, "code" => 400, "message" => $this->lang->line('something_went_wrong')], REST_Controller::HTTP_OK);
                        }
                    } else {
                        $this->response(["status" => false, "code" => 400, "message" => "Some error has occurred. Please try again."], REST_Controller::HTTP_BAD_REQUEST);
                    }
                } else {
                    if (!empty($user) && $user->register_type == SSO) {
                        $this->response(["status" => false, "code" => 400, "message" => $this->lang->line('already_sign_up_with_sso')], REST_Controller::HTTP_BAD_REQUEST);
                    } else {
                        $this->response(["status" => false, "code" => 400, "message" => $this->lang->line('email_not_exist')], REST_Controller::HTTP_BAD_REQUEST);
                    }
                }
            } else {
                $this->response(['status' => false, "code" => 400, "message" => "Email is required."], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, "code" => 401, 'message' => 'Invalid API key.'], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    // delete account
    public function account_delete()
    {
        $token = isset($this->_head_args['x-auth-token']) ? $this->_head_args['x-auth-token'] : "";
        if ($token) {
            $result = $this->verify_token($token);
        } else {
            $token = isset($this->_head_args['x-user-token']) ? $this->_head_args['x-user-token'] : "";
            $result = $this->check_token($token);
        }
        if (!empty($result) && $result->user_id != '') {
            $user_id = (int)$result->user_id;
            $result = $this->common_model->getTableData('tbl_user', array("id" => $user_id))->row();
            if (isset($result) && !empty($result)) {
                $comment = $this->common_model->getTableData('tbl_comment', array("user_id" => $user_id))->result();
                if (isset($comment) && !empty($comment)) {
                    $this->common_model->updateTableData('tbl_comment', array("user_id" => $user_id), array("status" => "I"));
                    //  $delete = $this->common_model->deleteTableData('tbl_user', array("user_id" => $user_id));
                }
                $update = $this->common_model->updateTableData('tbl_user', array("id" => $user_id), array("status" => "I"));
                if ($update) {
                    $this->response(['status' => true, 'code' => 200, 'message' => "Account deleted successfully.", "data" => array()], REST_Controller::HTTP_OK);
                } else {
                    $this->response(['status' => false, 'code' => 400, 'message' => "Some error occur.Account not deleted.", "data" => array()], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => false, 'code' => 400, 'message' => 'User were not found.', "data" => array()], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'code' => 401, 'message' => $result->message, "data" => array()], REST_Controller::HTTP_UNAUTHORIZED); //Authentication error the HTTP response code
        }
    }

    // end recipes api

    /* helper function */
    public function get_recipe($recipe, $user_id = '')
    {
        $data['recipe_id'] = $recipe->rid;
        $data['recipe_name'] = $recipe->recipes_heading;
        $data['cat_id'] = $recipe->cat_id;
        $data['category_name'] = $recipe->category_name;
        $data['created_by'] = $recipe->created_by;
        $data['creator_image_url'] = get_user_profile_image($recipe->creator_image);
        $data['calories'] = sprintf("%.1f", $recipe->calories);
        $data['serving_person'] = $recipe->serving_person;
        $data['recipes_time'] = $recipe->recipes_time . " " . "Minutes";
        $data['recipes_image_url'] = array();
        $all_image = json_decode($recipe->recipes_image);
        if (isset($all_image) && !empty($all_image)) {
            foreach ($all_image as $row) {
                if (file_exists(FCPATH . uploads_path . "recipes/" . $row)) {
                    array_push($data['recipes_image_url'], base_url(uploads_path . "recipes/" . $row));
                } else {
                    array_push($data['recipes_image_url'], base_url() . NO_RECIPE_IMAGE);
                }
            }
        }
        $data['direction'] = array();
        $direction = json_decode($recipe->direction);
        if (isset($direction) && !empty($direction)) {
            foreach ($direction as $row) {
                array_push($data['direction'], $row);
            }
        }
        $data['summary'] = $recipe->summary;
        $data['youtube'] = $recipe->youtube_link;
        $data['today_recipe'] = $recipe->today_recipe;
        $data['ingredients'] = array();
        $ingredients = $this->common_model->getTableData('tbl_ingredients', array("rid" => $recipe->rid), '*')->result();
        foreach ($ingredients as $ing_row) {
            $ingData['ingredient_name'] = $ing_row->ingredient_name;
            $ingData['quantity'] = is_numeric($ing_row->qty)? sprintf("%.1f", $ing_row->qty):$ing_row->qty;
            $ingData['weight'] = $ing_row->weight;
            array_push($data['ingredients'], $ingData);
        }
        $data["share_url"] = base_url('recipe-detail/' . $recipe->rid);
        $rating = sprintf("%.1f", get_average_rating($recipe->rid));
        $data['rating'] = isset($rating) && $rating != '' ? $rating : '';
        $bookmark = get_bookmark($recipe->rid, $user_id);
        $data['is_bookmark'] = isset($bookmark) && $bookmark != '' ? "1" : "0";
        return $data;
    }

    public function get_user($user)
    {
        $data['user_id'] = $user->id;
        $data['firstname'] = $user->firstname;
        $data['lastname'] = $user->lastname;
        $data['profile_image_url'] = get_user_profile_image($user->profile_image);
        $data['phone'] = isset($user->phone) && $user->phone != '' ? $user->phone : "";
        $data['email'] = $user->email;
        return $data;
    }

    public function get_comment($comment)
    {
        $data['comment_id'] = $comment->id;
        $data['comment'] = $comment->comment;
        $data['comment_by'] = $comment->comment_by;
        $data['user_id'] = $comment->user_id;
        $data['profile_image_url'] = get_user_profile_image($comment->profile_image);
        $data['created_on'] = $comment->created_on;
        $data['reply_comment'] = array();
        $reply_comment = get_reply_comments($comment->recipe_id, $comment->id);
        if (isset($reply_comment) && !empty($reply_comment)) {
            foreach ($reply_comment as $reply_comment_row) {
                $replyCommentData['comment'] = $reply_comment_row['comment'];
                $replyCommentData['comment_by'] = $reply_comment_row['comment_by'];
                $replyCommentData['profile_image_url'] = "";
                $replyCommentData['profile_image_url'] = get_user_profile_image($reply_comment_row['profile_image']);
                $replyCommentData['created_on'] = $reply_comment_row['created_on'];
                array_push($data['reply_comment'], $replyCommentData);
            }
        }
        return $data;
    }

    /*     * Check password */

    public function check_password($password)
    {
        $password_length = strlen($password);
        if ($password_length == 0) {
            return (object)array("status" => false, "message" => "Password is required.");
        } elseif ($password_length < 8) {
            return (object)array("status" => false, "message" => "Password must be 8 character long.");
        } else {
            return (object)array("status" => true);
        }
    }

    /*     * Check confirm password */

    public function check_confirm_password($password, $confirm_password)
    {
        $message = '';
        $password_length = strlen($confirm_password);
        if ($password_length == 0) {
            return (object)array("status" => false, "message" => "Confirm password is required.");
        } elseif ($confirm_password != $password) {
            return (object)array("status" => false, "message" => "Invalid confirm password.");
        } else {
            return (object)array("status" => true);
        }
    }

}

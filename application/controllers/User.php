<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
        $this->lang->load('error_message');

    }
    public function profile()
    {
        $this->authenticate->check_user();
        $id = $this->session->userdata('USER_ID');
        if ($id) {
            $data['title'] = "Profile";
            $user_data = $this->common_model->getTableData('tbl_user', array("id" => $id), "*")->row();
            $data['user_data'] = $user_data;
            $this->load->view("front/user_profile", $data);
        } else {
            redirect(base_url()."login");
        }
    }
    //show register form
    public function register()
    {
        if (!$this->session->userdata('USER_ID')) {
            $data['title'] = "Register";
            $this->load->view('front/register', $data);
        } else {
            redirect(base_url());
        }
    }
    public function register_save()
    {

        $user_id = $this->input->post('user_id');
        if ($user_id == '') {
            $this->form_validation->set_rules('password', '', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('conf_password', '', 'trim|required|callback_conf_password_check');
            $this->form_validation->set_rules('email', '', 'trim|valid_email|required');
        }
        $this->form_validation->set_rules('firstname', '', 'trim|required');
        $this->form_validation->set_rules('lastname', '', 'trim|required');
        if ($user_id != '') {
            $this->form_validation->set_rules('profile_image', '', 'callback_check_image');
        }
        $this->form_validation->set_rules('phone', '', 'trim|exact_length[10]');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            if ($user_id) {
                $this->profile();
            } else {
                $this->register();
            }
        } else {
            $email = $this->input->post('email');
            $check_email = check_email($email, $user_id);
            if ($check_email->status) {
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
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'user_type' => "C",
                    'profile_image' => isset($new_image) ? $new_image : $old_image,

                );

                //Check for update
                if ($user_id > 0) {
                    $insert['updated_on'] = date('Y-m-d H:i:s');
                    $this->common_model->updateTableData('tbl_user', array("id" => $user_id), $insert);
                    $this->session->set_flashdata('msg', "Profile updated successdully.");
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect(base_url()."profile");
                } else {
                    $user = $this->common_model->getTableData('tbl_user', array('email' => $email, 'user_type' => "C"))->row();
                    if (isset($user) && !empty($user)) {
                        if ($user->status == "I") {
                            $update['register_type'] = GENERAL;
                            $update['password'] = md5($this->input->post('password'));
                            $update['status'] = 'A';
                            $update['updated_on'] = date('Y-m-d H:i:s');
                            $this->common_model->updateTableData('tbl_user', array("email" => $email), $update);
                            $this->common_model->updateTableData('tbl_comment', array("user_id" => $user->id), array("status" => "A"));
                            $this->session->set_userdata("USER_ID", $user->id);
                            redirect(base_url());
                        } else if ($user->status == "EP") {
                            $this->session->set_flashdata('msg', $this->lang->line('account_already_exist_but_not_verified'));
                            $this->session->set_flashdata('msg_class', 'failure');
                            redirect('register');
                        }
                    } else {
                        $insert['status'] = "EP"; //email verification pending
                        $insert['email'] = $this->input->post('email');
                        $insert['password'] = md5($this->input->post('password'));
                        $insert['created_on'] = date('Y-m-d H:i:s');
                        $ins_id = $this->common_model->insertTableData('tbl_user', $insert);
                        //  send email verification mail
                        if ($ins_id) {
                            $enc_user_id = $this->general->encryptData($ins_id);
                            $enc_email = $this->general->encryptData($email);
                            $url = base_url('verify-email/' . $enc_user_id . "/" . $enc_email);
                            $name = ucfirst($this->input->post('firstname')) . " " . ucfirst($this->input->post('lastname'));

                            // Send email
                            $subject = 'Account Registration';
                            $define_param['to_name'] = $name;
                            $define_param['to_email'] = $email;

                            $parameter['NAME'] = $name;
                            $parameter['URL'] = $url;
                            $html = $this->load->view("email_template/email_verification", $parameter, true);
                            $send = $this->sendmail->send($define_param, $subject, $html);
                            if ($send->status) {
                                $this->session->set_flashdata('msg', $this->lang->line('account_confirmation_text'));
                                $this->session->set_flashdata('msg_class', "success");
                            } else {
                                $this->session->set_flashdata('msg', $this->lang->line('something_went_wrong'));
                                $this->session->set_flashdata('msg_class', "failure");
                            }
                            redirect('login');
                        } else {
                            $this->session->set_flashdata('msg_class', "failure");
                            $this->session->set_flashdata('msg', 'Some error occur.please try again.');
                            $this->register();
                        }
                        $this->session->set_flashdata('msg', "Account created successfully.");
                        $this->session->set_flashdata('msg_class', 'success');
                        redirect(base_url());
                    }
                }
            } else {
                $this->session->set_flashdata('msg', $check_email->message);
                $this->session->set_flashdata('msg_class', 'failure');
                $this->register();
            }
        }
    }

    public function verify_email($enc_user_id, $enc_email)
    {
        $user_id = (int) $this->general->decryptData($enc_user_id);
        $email = $this->general->decryptData($enc_email);
        $user = $this->common_model->getTableData("tbl_user", array("id" => $user_id, "email" => $email))->row();
        if (isset($user) && !empty($user)) {
            if ($user->status == 'A') {
                $this->session->set_flashdata('msg_class', "success");
                $this->session->set_flashdata('msg', 'Your email is already verified.');
                redirect('login');
            } else {
                $create_on = date("Y-m-d H:i:s", strtotime($user->created_on . "+1 hour"));
                if ($create_on > date("Y-m-d H:i:s")) {
                    $this->common_model->updateTableData('tbl_user', array('id' => $user_id), array("status" => "A"));
                    $this->session->set_flashdata('msg_class', "success");
                    $this->session->set_flashdata('msg', 'Account verification success.Now login.');
                    redirect('login');
                } else {
                    $data['link_expire'] = $user_id;
                    $data['verification_message']="Account verification link has been expire.";
                    $this->load->view('front/login', $data);
                }
            }
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', 'Invalid request');
            redirect('register');
        }
    }
    public function resend_verify_link($user_id)
    {
        $user_id = (int) $user_id;
        if ($user_id) {
            $user = $this->common_model->getTableData('tbl_user', array('id' => $user_id, 'user_type' => "C"))->row();
            if (isset($user) && !empty($user)) {
                $this->common_model->updateTableData('tbl_user', array('id' => $user_id), array("created_on" => date("Y-m-d H:i:s")));
                $enc_user_id = $this->general->encryptData($user_id);
                $enc_email = $this->general->encryptData($user->email);
                $url = base_url('verify-email/' . $enc_user_id . "/" . $enc_email);
                $name = ucfirst($user->firstname) . " " . ucfirst($user->lastname);

                // Send email
                $subject = 'Account Registration';
                $define_param['to_name'] = $name;
                $define_param['to_email'] = $user->email;

                $parameter['NAME'] = $name;
                $parameter['URL'] = $url;
                $html = $this->load->view("email_template/email_verification", $parameter, true);
                $send = $this->sendmail->send($define_param, $subject, $html);
                if ($send->status) {
                    $this->session->set_flashdata('msg', $this->lang->line('account_confirmation_text'));
                    $this->session->set_flashdata('msg_class', "success");
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line("something_went_wrong"));
                    $this->session->set_flashdata('msg_class', "failure");
                }
                redirect('login');
            } else {
                $this->session->set_flashdata('msg_class', "failure");
                $this->session->set_flashdata('msg', 'Invalid request');
                redirect('login');
            }
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', 'Invalid request');
            redirect('login');
        }
    }

    public function conf_password_check($conf_password)
    {
        $password = $this->input->post('password');
        if ($password != $conf_password) {
            $this->form_validation->set_message('conf_password_check', 'Invalid confirm password.');
            return false;
        }
        return true;
    }
    public function check_image()
    {
        $image = "";
        $image = $_FILES['profile_image']['name'];
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
    public function delete_profile_image($id)
    {
        $user_data = $this->common_model->getTableData('tbl_user', array("id" => $id), 'profile_image')->row();
        if (isset($user_data) && $user_data->profile_image != '') {
            $update['profile_image'] = "";
            $this->common_model->updateTableData('tbl_user', array("id" => $id), $update);
            if (file_exists(FCPATH . uploads_path . "profile/" . $user_data->profile_image)) {
                unlink(FCPATH . uploads_path . "profile/" . $user_data->profile_image);
                echo true;
                exit;
            } else {
                echo false;
                exit;
            }
        } else {
            echo false;
            exit;
        }
    }
    public function check_user_email()
    {
        $user_id = (int) $this->input->post('user_id');
        $email = trim($this->input->post('email'));
        if (isset($user_id) && $user_id > 0) {
            $where = array("email" => $email, "status" => "A", "id!=" => $user_id, "user_type" => "C");
        } else {
            $where = array("email" => $email, "status" => "A", "user_type" => "C");
        }
        $check_name = $this->common_model->getTableData("tbl_user", $where, "email")->row();
        if (isset($check_name) && !empty($check_name)) {
            echo "false";
            exit;
        } else {
            echo "true";
            exit;
        }
    }

    /**Single sign on */
    public function social_login()
    {
        $email = $this->input->post('email');
        $user = $this->common_model->getTableData('tbl_user', array('user_type' => 'C', 'email' => $email), '*')->row();
        if (isset($user) && !empty($user)) {
            if ($user->status == "I") {
                $update['updated_on'] = date('Y-m-d H:i:s');
                $update['register_type'] = SSO;
                $update['password'] = "";
                $update['status'] = 'A';
                $this->common_model->updateTableData('tbl_user', array("id" => $user->id), $update);
                $this->common_model->updateTableData('tbl_comment', array("user_id" => $user->id), array("status" => "A"));
                $this->session->set_userdata("USER_ID", $user->id);
                echo json_encode(array("status" => true));
                exit;
            } else if ($user->status == "A" && $user->register_type == SSO) {
                $this->session->set_userdata("USER_ID", $user->id);
                echo json_encode(array("status" => true));
                exit;
            } else if ($user->status == "A" && $user->register_type == GENERAL) {
                echo json_encode(array("status" => false, "message" => $this->lang->line('already_sign_up_with_email')));
                exit;
            } else {
                echo json_encode(array("status" => false, "message" => $this->lang->line('account_already_exist_but_not_verified')));
                exit;
            }
        } else {
            $insert = array(
                'phone' => $this->input->post('phone'),
                'email' => $email,
                'firstname' => $this->input->post('firstname'),
                'lastname' => "",
                'user_type' => "C",
                "register_type" => SSO,
                'profile_image' => $this->input->post("profile_image"),

            );
            $insert['created_on'] = date('Y-m-d H:i:s');
            $ins_id = $this->common_model->insertTableData('tbl_user', $insert);
            $this->session->set_userdata("USER_ID", $ins_id);
            echo json_encode(array("status" => true));
            exit;
        }

    }
    public function delete_account()
    {
        $user_id = $this->session->userdata('USER_ID');
        $user = $this->common_model->getTableData('tbl_user', array("id" => $user_id))->row();
        if (isset($user) && !empty($user)) {
            $comment = $this->common_model->getTableData('tbl_comment', array("user_id" => $user_id))->result();
            if (isset($comment) && !empty($comment)) {
                $this->common_model->updateTableData('tbl_comment', array("user_id" => $user_id), array("status" => "I"));
                //  $delete = $this->common_model->deleteTableData('tbl_user', array("user_id" => $user_id));
            }
            $update = $this->common_model->updateTableData('tbl_user', array("id" => $user_id), array("status" => "I"));
            if ($update) {
                $this->session->unset_userdata('USER_ID');
                $this->session->sess_destroy();
                $this->session->set_flashdata('msg_class', "success");
                $this->session->set_flashdata('msg', 'Account deleted successfully.');
                redirect(base_url());
            } else {
                $this->session->set_flashdata('msg_class', "failure");
                $this->session->set_flashdata('msg', 'Something went wrong.Please try again.');
                redirect('profile');
            }
        } else {
            $this->session->set_flashdata('msg_class', "failure");
            $this->session->set_flashdata('msg', 'Invalid request');
            redirect('profile');
        }

    }

}

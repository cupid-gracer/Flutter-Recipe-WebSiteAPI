<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_content extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
        date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
        $this->lang->load('error_message');
        $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
    }

    //show login form
    public function login()
    {
        if (!$this->session->userdata('USER_ID')) {
            $data['title'] = "Login";
            $this->load->view('front/login', $data);
        } else {
            redirect(base_url());
        }
    }

    //logout
    public function logout()
    {
        $this->session->unset_userdata('USER_ID');
        $this->session->sess_destroy();
        redirect(base_url());
    }

    //check login email or password
    public function login_action()
    {
        $email = $this->input->post("email", true);
        $password = $this->input->post("password", true);
        $this->form_validation->set_rules('email', '', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', '', 'trim|required');
        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == false) {
            $this->login();
        } else {
            $user = $this->common_model->getTableData('tbl_user', array('password' => md5($password), 'email' => $email, 'user_type' => "C"))->row();
            if (isset($user) && !empty($user)) {
                if ($user->status == "A") {
                    $this->session->set_userdata("USER_ID", $user->id);
                    $this->session->set_flashdata('msg', 'You have logged in successfully.');
                    $this->session->set_flashdata('msg_class', 'success');
                    redirect(base_url());
                } else if ($user->status == "EP") {
                    $create_on = date("Y-m-d H:i:s", strtotime($user->created_on . "+1 hour"));
                    if ($create_on < date("Y-m-d H:i:s")) {
                        $data['link_expire'] = $user->id;
                        $data['verification_message'] = "Your account not verify.";
                        $this->load->view('front/login', $data);
                    } else {
                        $this->session->set_flashdata('msg', $this->lang->line('account_not_verify'));
                        $this->session->set_flashdata('msg_class', 'failure');
                        redirect('login');
                    }
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('invalid_email_password'));
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect('login');
                }
            } else {
                $this->session->set_flashdata('msg', $this->lang->line('invalid_email_password'));
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('login');
            }

        }
    }
    //    log in modal action
    public function modal_login_action()
    {
        $email = $this->input->post("email", true);
        $password = $this->input->post("password", true);

        if ($email != '' && $password != '') {
            $user = $this->common_model->getTableData('tbl_user', array('password' => md5($password), 'email' => $email, 'user_type' => "C", 'status' => "A"))->row();
            if (isset($user) && !empty($user)) {
                $this->session->set_userdata("USER_ID", $user->id);
                echo json_encode(array("status" => true, "message" => ""));
                exit;
            } else {
                echo json_encode(array("status" => false, "message" => "Invalid email or password."));
                exit;
            }
        } else {
            echo json_encode(array("status" => false, "message" => "Email and password is required."));
            exit;
        }
    }

    // change password
    public function change_password()
    {
        $this->authenticate->check_user();
        $data['title'] = "Change password";
        $this->load->view('front/change_password', $data);
    }

    public function change_password_action()
    {
        $user_id = $this->session->userdata('USER_ID');
        $this->form_validation->set_rules('current_password', '', 'trim|required|callback_current_password_check');
        $this->form_validation->set_rules('new_password', '', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', '', 'trim|required|callback_conf_password_check');
        $this->form_validation->set_message('required', "This field is required");
        if ($this->form_validation->run() == false) {
            $this->change_password();
        } else {
            $update = array(
                'password' => md5($this->input->post('new_password')),
            );
            $update['updated_on'] = date('Y-m-d H:i:s');
            $this->common_model->updateTableData('tbl_user', array('id' => $user_id), $update);
            $this->session->set_flashdata('msg', "Password updated successfully.");
            $this->session->set_flashdata('msg_class', 'success');
            redirect(base_url()."change-password");
        }
    }

    public function current_password_check($current_password)
    {
        $user_id = $this->session->userdata('USER_ID');
        $current_password_hash = md5($current_password);
        $current_password_db = $this->common_model->getTableData('tbl_user', array('id' => $user_id), 'password')->row();
        if ($current_password_hash != $current_password_db->password) {
            $this->form_validation->set_message('current_password_check', 'Invalid current password.');
            return false;
        }
        return true;
    }
    public function conf_password_check($conf_password)
    {
        $new_password = $this->input->post('new_password');
        if ($new_password != $conf_password) {
            $this->form_validation->set_message('conf_password_check', 'Invalid confirm password.');
            return false;
        }
        return true;
    }

    // forgot-password
    public function forgot_password()
    {
        $data['title'] = "Forgot password";
        $this->load->view("front/forgot_password", $data);
    }

    public function forgot_password_action()
    {
        $this->form_validation->set_rules('email', '', 'required|trim|valid_email');
        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == false) {
            $this->forgot_password();
        } else {
            $email = $this->input->post('email');
            $user = $this->common_model->getTableData('tbl_user', array('email' => $email, "status" => "A", "user_type" => "C"))->row();
            if (isset($user) && $user->register_type == GENERAL) {
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
                        $this->session->set_flashdata('msg', $this->lang->line('reset_password_text'));
                        $this->session->set_flashdata('msg_class', 'success');
                    } else {
                        $this->session->set_flashdata('msg', $this->lang->line('something_went_wrong'));
                        $this->session->set_flashdata('msg_class', 'failure');
                    }
                    redirect(base_url()."login");
                } else {
                    $this->session->set_flashdata('msg', "Please try again.");
                    $this->session->set_flashdata('msg_class', 'failure');
                    redirect(base_url()."forgot-password");
                }
            } else {
                if (isset($user) && $user->register_type == SSO) {
                    $this->session->set_flashdata('msg', $this->lang->line('already_sign_up_with_sso'));
                } else {
                    $this->session->set_flashdata('msg', $this->lang->line('email_not_exist'));
                }
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url()."forgot-password");
            }

        }
    }
    //show reset password
    public function reset_password($uniq_id = "")
    {
        if ($uniq_id == "") {
            $uniq_id = $this->uri->segment(2);
        }
        $user_data = $this->common_model->getTableData("tbl_user", array("forgot_password_code" => $uniq_id))->row();
        if (isset($user_data) && !empty($user_data)) {
            $add_min = date("Y-m-d H:i:s", strtotime($user_data->forgot_password_time . "+1 hour"));
            if ($add_min > date("Y-m-d H:i:s")) {
                $data['title'] = "Reset password";
                $data['uniq_id'] = $uniq_id;
                $this->load->view('front/reset_password', $data);
            } else {
                $this->session->set_flashdata('msg', "Reset password link expire try again.");
                $this->session->set_flashdata('msg_class', 'failure');
                redirect('forgot-password');
            }
        } else {
            $this->session->set_flashdata('msg_class', 'failure');
            $this->session->set_flashdata('msg', "Invalid request.");
            redirect('login');
        }
    }

    //edit password
    public function reset_password_action()
    {
        $uniq_id = $this->input->post('uniq_id');
        $password = $this->input->post('password');
        $this->form_validation->set_rules('password', '', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('conf_password', 'Confirm password', 'trim|required|matches[password]');
        $this->form_validation->set_message('required', 'This field is required');
        if ($this->form_validation->run() == false) {
            $this->reset_password($uniq_id);
        } else {
            if ($password == $this->input->post('conf_password')) {
                $update['password'] = md5($password);
                $update['updated_on'] = date("Y-m-d H:i:s");
                $this->common_model->updateTableData('tbl_user', array('forgot_password_code' => $uniq_id), $update);
                $this->session->set_flashdata('msg', 'Password reset successfully.');
                $this->session->set_flashdata('msg_class', 'success');
                redirect('login');
            } else {
                $this->session->set_flashdata('msg', 'Invalid confirm password.');
                $this->session->set_flashdata('msg_class', 'failure');
                redirect(base_url()."reset-password/" . $uniq_id);
            }
        }
    }
}

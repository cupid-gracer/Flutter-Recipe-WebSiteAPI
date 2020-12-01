<?php
function get_AdminDetail($id)
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_user');
    $where = "id='$id' AND status='A'";
    $CI->db->where($where);
    $user_data = $CI->db->get()->result_array();
    return isset($user_data) && count($user_data) > 0 ? $user_data[0] : '';

}

function get_setting()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_site_config');
    return $CI->db->get()->row_array();
}

function get_favicon()
{
    $CI = &get_instance();
    $CI->db->select('site_favicon');
    $CI->db->from('tbl_site_config');
    $where = "id='1'";
    $CI->db->where($where);
    $site_favicon = $CI->db->get()->row_array();

    if ($site_favicon['site_favicon'] != '' && file_exists(FCPATH . uploads_path . $site_favicon['site_favicon'])) {
        return base_url() . uploads_path . $site_favicon['site_favicon'];
    } else {
        return base_url() . FAVICONE_152;
    }
}

function get_header_color()
{
    $CI = &get_instance();
    $CI->db->select('header_color');
    $CI->db->from('tbl_site_config');
    $where = "id='1'";
    $CI->db->where($where);
    $data = $CI->db->get()->row_array();
    if (isset($data) && !empty($data) && $data['header_color'] != '') {
        return $data['header_color'];
    } else {
        return "#232323";
    }
}

function get_site_name()
{
    $CI = &get_instance();
    $CI->db->select('site_name');
    $CI->db->from('tbl_site_config');
    $site_name = $CI->db->get()->row_array();
    return isset($site_name) && count($site_name) > 0 ? ucfirst($site_name['site_name']) : '';
}

function get_logo()
{
    $CI = &get_instance();
    $CI->db->select('site_logo');
    $CI->db->from('tbl_site_config');
    $where = "id='1'";
    $CI->db->where($where);
    $site_logo = $CI->db->get()->row_array();

    if ($site_logo['site_logo'] != '' && file_exists(FCPATH . uploads_path . $site_logo['site_logo'])) {
        return base_url() . uploads_path . $site_logo['site_logo'];
    } else {
        return base_url() . SITE_LOGO;
    }
}

function get_carousel()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_carousel');
    $where = "status='A'";
    $CI->db->order_by('id', 'desc');
    $CI->db->where($where);
    $data = $CI->db->get()->result_array();
    return isset($data) && count($data) > 0 ? $data : '';

}

function tz_list()
{
    $zones_array = array();
    $timestamp = time();
    foreach (timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
    }
    return $zones_array;
}

function get_time_zone()
{
    $CI = &get_instance();
    $CI->db->select('time_zone');
    $CI->db->from('tbl_site_config');
    $where = "id='1'";
    $CI->db->where($where);
    $site_data = $CI->db->get()->row_array();
    return isset($site_data) && count($site_data) > 0 && $site_data['time_zone'] != '' ? $site_data['time_zone'] : 'Asia/Kolkata';
}

function get_site_data()
{
    $CI = &get_instance();
    $CI->db->select('*');
    $CI->db->from('tbl_site_config');
    $where = "id='1'";
    $CI->db->where($where);
    $site_data = $CI->db->get()->row_array();
    return isset($site_data) && count($site_data) > 0 ? $site_data : '';
}

function count_category_recipe($category_id)
{
    $CI = &get_instance();
    $CI->db->select('rid');
    $CI->db->from('tbl_recipes');
    $where = "status='A' AND cat_id =$category_id";
    $CI->db->where($where);
    $site_data = $CI->db->get()->result_array();
    return isset($site_data) && count($site_data) > 0 ? count($site_data) : '';
}

function get_total_comments($recipe_id)
{
    $CI = &get_instance();
    $CI->db->select('recipe_id');
    $CI->db->from('tbl_comment');
    $where = "recipe_id=$recipe_id AND status='A'";
    $CI->db->where($where);
    $comment = $CI->db->get()->result_array();
    return isset($comment) && count($comment) > 0 ? count($comment) : 0;
}

function get_comments($recipe_id)
{
    $CI = &get_instance();
    $CI->db->select('tbl_comment.*,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as comment_by,tbl_user.profile_image');
    $CI->db->join('tbl_user', 'tbl_comment.user_id = tbl_user.id', 'left');
    $CI->db->order_by('id', 'asc');
    $CI->db->from('tbl_comment');
    $where = "recipe_id=$recipe_id AND comment_type='C' AND tbl_comment.status='A'";
    $CI->db->where($where);
    $comment = $CI->db->get()->result_array();
    return isset($comment) && count($comment) > 0 ? $comment : '';
}

function get_reply_comments($recipe_id, $comment_id)
{
    $CI = &get_instance();
    $CI->db->select('tbl_comment.*,CONCAT(tbl_user.firstname," ",tbl_user.lastname) as comment_by,tbl_user.profile_image');
    $CI->db->join('tbl_user', 'tbl_comment.user_id = tbl_user.id', 'left');
    $CI->db->order_by('id', 'asc');
    $CI->db->from('tbl_comment');
    $where = "recipe_id=$recipe_id AND comment_type='R' AND comment_reply_id =$comment_id AND tbl_comment.status='A'";
    $CI->db->where($where);
    $comment = $CI->db->get()->result_array();
    return isset($comment) && count($comment) > 0 ? $comment : '';
}

function get_user_rating($recipe_id, $user_id)
{
    $CI = &get_instance();
    $CI->db->select('rating');
    $CI->db->from('tbl_rating');
    $where = "recipe_id=$recipe_id AND user_id =$user_id";
    $CI->db->where($where);
    $result = $CI->db->get()->row_array();
    return isset($result) && count($result) > 0 ? $result['rating'] : 0;
}

function get_average_rating($recipe_id)
{
    $CI = &get_instance();
    $CI->db->select('AVG(rating) as rating');
    $CI->db->from('tbl_rating');
    $where = "recipe_id=$recipe_id";
    $CI->db->where($where);
    $result = $CI->db->get()->row_array();
    return isset($result) && count($result) > 0 ? $result['rating'] : 0;
}

function get_star($rat, $is_user_rat = "N")
{
    if ($rat != 0) {
        if ($rat <= 1 && $rat < 1.5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat <= 1.5 && $rat < 2) {
            $html = '<i class="fa fa-star rated"></i>';
            if ($is_user_rat == "N") {
                $html .= '<i class="fa fa-star-half-o rated"></i>';
            } else {
                $html .= '<i class="fa fa-star rated"></i>';
            }
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 2 && $rat < 2.5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 2.5 && $rat < 3) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            if ($is_user_rat == "N") {
                $html .= '<i class="fa fa-star-half-o rated"></i>';
            } else {
                $html .= '<i class="fa fa-star rated"></i>';
            }
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 3 && $rat < 3.5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 3.5 && $rat < 4) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            if ($is_user_rat == "N") {
                $html .= '<i class="fa fa-star-half-o rated"></i>';
            } else {
                $html .= '<i class="fa fa-star rated"></i>';
            }
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 4 && $rat < 4.5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star not-rated"></i>';
            return $html;
        } else if ($rat >= 4.5 && $rat < 5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            if ($is_user_rat == "N") {
                $html .= '<i class="fa fa-star-half-o rated"></i>';
            } else {
                $html .= '<i class="fa fa-star rated"></i>';
            }
            return $html;
        } else if ($rat >= 5) {
            $html = '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            $html .= '<i class="fa fa-star rated"></i>';
            return $html;
        }
    } else {
        $html = '<i class="fa fa-star not-rated"></i>';
        $html .= '<i class="fa fa-star not-rated"></i>';
        $html .= '<i class="fa fa-star not-rated"></i>';
        $html .= '<i class="fa fa-star not-rated"></i>';
        $html .= '<i class="fa fa-star not-rated"></i>';
        return $html;
    }
}

function get_bookmark($recipe_id, $user_id)
{
    $CI = &get_instance();
    $CI->db->select('id');
    $CI->db->from('tbl_bookmark');
    $where = "recipe_id=$recipe_id AND user_id =$user_id";
    $CI->db->where($where);
    $result = $CI->db->get()->row_array();
    return isset($result) && count($result) > 0 ? $result['id'] : "";
}

function check_email($email, $user_id = '')
{
    $CI = &get_instance();
    if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
        $CI->db->select('*');
        $CI->db->from('tbl_user');
        if ($user_id) {
            $where = "email='$email' AND status='A' AND id!=$user_id";
        } else {
            $where = "email='$email' AND status='A'";
        }
        $CI->db->where($where);
        $result = $CI->db->get()->row_array();
        if (isset($result) && count($result) > 0) {
            if ($result['register_type'] == SSO) {
                return (object)array("status" => false, "message" => $CI->lang->line('already_sign_up_with_sso'));
            } else if ($result['register_type'] == GENERAL) {
                return (object)array("status" => false, "message" => $CI->lang->line('email_exist'));
            }
        } else {
            return (object)array("status" => true);
        }
    } else {
        return (object)array("status" => false, "message" => $CI->lang->line('invalid_email'));
    }
}

function get_user_profile_image($profile_image = '')
{
    $len = strlen("http");
    if ($profile_image != '' && substr($profile_image, 0, $len) == "http") {
        return $profile_image;
    } else {
        if ($profile_image != '' && file_exists(FCPATH . uploads_path . "profile/" . $profile_image)) {
            return base_url() . uploads_path . "profile/" . $profile_image;
        } else {
            return base_url() . NO_USER_PATH;
        }
    }
}

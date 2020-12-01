<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->authenticate->check_admin();
		date_default_timezone_set(get_time_zone());
        $this->load->model('common_model');
    }
	public function index()
	{
		$data['title']= "Dashboard";
		$data['total_category'] = $this->common_model->Totalcount('tbl_category');
		$data['total_news'] = $this->common_model->Totalcount("tbl_recipes");
	    $this->load->view("dashboard",$data);
	}
}

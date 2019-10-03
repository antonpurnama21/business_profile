<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Dashboard extends CommonDash {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		$data = array(
			'titleWeb' => 'Business Profile',
			'breadcrumb' => explode(',', 'Dashboard,Main page'),
		);
		$this->render('dashboard', 'welcome_message', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
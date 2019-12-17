<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Dashboard extends CommonDash {
//comtroller tampilan dashboard
	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{

		$data = array(
			'titleWeb' => 'Business Profile',//web title
			'breadcrumb' => explode(',', 'Dashboard,Main page'),
			'totalUniv' => count($this->Mod_crud->getData('result','*','t_university')),//total university
			'totalCompany' => count($this->Mod_crud->getData('result','*','t_company')),//total company
			'totalComunity' => count($this->Mod_crud->getData('result','*','t_comunity')),//total comunity
			'mouYes' => count($this->Mod_crud->getData('result','*','t_university',null,null,null,array('mou = "YES"'))),//universitas yang sudah MOU
		);
		$this->render('dashboard', 'welcome_message', $data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
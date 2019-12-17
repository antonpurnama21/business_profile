<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonDash extends CI_Controller {
//main controller
	public $data = array();
	public $sess = null;

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('userlog')['is_login'] == FALSE) ://jika session is_login bernilai false
			redirect(base_url('auth/login')) ;//menuju login
		endif;
		$this->load->model('Mod_crud');//load model mod_crud
		$this->sess = $this->session->userdata('userlog');//set session menjadi $this->sess
		
	}

	public function render($template, $view, $dt)//templating
	{
		$data = array_merge($dt, array(
				'sidebar' => 'nothing',
				'sesi' => $this->sess//sett session menjadi sesi
				)
		);
		
		$this->template->load($template, $view, $data);//load template
	}
}

/* End of file CommonDash.php */
/* Location: ./application/controllers/CommonDash.php */
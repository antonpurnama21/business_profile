<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CommonDash extends CI_Controller {

	public $data = array();
	public $sess = null;

	function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('userlog')['is_login'] == FALSE) :
			redirect(base_url('auth/login')) ;
		endif;
		$this->load->model('Mod_crud');
		//auth_check();
		//$this->sidebar = '123';
		$this->sess = $this->session->userdata('userlog');
		
	}

	// public function makesidebar()
	// {
	// 	$grup = $this->mod_crud->getData('result', 'g.grupMenu, g.idGrupMenu, h.uniqueKaitan', 'grup_menu g', null, null, array('halaman h' => 'g.idKaitan = h.idKaitan'), array('statusGrupMenu = "1"'));
	// 	if ($grup) {
	// 		$bigmenu = array();
	// 		foreach ($grup as $gr) {
	// 			$childmenu = $this->mod_crud->getData('result', 'm.idMenu, m.judulMenu, h.uniqueKaitan', 'menu m', null, null, array('halaman h' => 'm.idKaitan = h.idKaitan'), array('m.idGrupMenu = "'.$gr->idGrupMenu.'"', 'm.statusMenu = "1"'));
	// 			if ($childmenu) {
	// 				$menu = array();
	// 				foreach ($childmenu as $mn ) {
	// 					$mnu = array(
	// 							'idMenu' => $mn->idMenu,
	// 							'judulMenu' => $mn->judulMenu,
	// 							'uniqueMenu' => $mn->uniqueKaitan,
	// 							'child' => $this->mod_crud->getData('result', 's.idSubMenu, s.judulSubMenu, h.uniqueKaitan', 'menu_sub s', null, null, array('halaman h' => 's.idKaitan = h.idKaitan'), array('s.idMenu = "'.$mn->idMenu.'"', 's.statusSubMenu = "1"'))
	// 						);
	// 					array_push($menu, $mnu);
	// 				}

	// 				$dt['grupMenu'] = $gr->grupMenu;
	// 				$dt['uniqueGrupMenu'] = $gr->uniqueKaitan;
	// 				$dt['menu'] = $menu;
	// 				array_push($bigmenu, $dt);
	// 			}
	// 		}
	// 	}else{
	// 		$bigmenu = array();
	// 	}
		

	// 	$data = array(
	// 			'menu' => $bigmenu
	// 		);
	// 	return $this->load->view('partials/frontend/menu', $data, TRUE);
		
	// }

	public function render($template, $view, $dt)
	{
		$data = array_merge($dt, array(
				'sidebar' => 'nothing',
				//'jenisbengkel' => $this->Mod_crud->getData('result', 'IDReferensiJenisBengkel, JenisBengkel', 'referensijenisbengkel'),
				'sesi' => $this->sess
				)
		);
		
		$this->template->load($template, $view, $data);
	}
}

/* End of file CommonDash.php */
/* Location: ./application/controllers/CommonDash.php */
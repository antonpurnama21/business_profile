<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {


	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('userlog')['is_login'] == FALSE) :
			redirect(base_url('auth')) ;
		endif;
		$this->load->model('Mod_crud');
		$this->load->library('Fpdf');
		define('FPDF_FONTPATH',$this->config->item('fonts_path')); 
	}

	public function index()
	{

	}

	public function printCompany($id=null)
	{
		$data = array(
				'title' => name_company($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_company_profile',null,null,null,array('companyID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_company_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function printComunity($id=null)
	{
		$data = array(
				'title' => name_comunity($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_comunity_profile',null,null,null,array('comunityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function printUniversity($id=null)
	{
		$data = array(
				'title' => name_university($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_university_profile',null,null,null,array('universityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_university_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function printResult()
	{
		$dtbase = explode(",", $this->input->post('dtbase'));
		$search	= $this->input->post('key');
		$db 	= array();

		$no = 0;
		foreach ($dtbase as $key) {
			$no++;
			$database = 't_'.$key.'_profile';
			$field = $this->Mod_crud->get_field_info($database);
			
			if ($key=='company') {
				$dd = 'cp';
			}elseif ($key=='comunity') {
				$dd = 'cm';
			}else{
				$dd = 'un';
			}

			$i = 0;
			foreach ($field as $key1) {
				$i++;
				if ($i==1) {
					${'dt'. $dd}[] = $key1->name." LIKE '%".$search."%'";
				}else{
					${'dt'. $dd}[] = "OR ".$key1->name." LIKE '%".$search."%'";
				}
			}
			//echo json_encode(${'dt'.$dd});
			$dtsearch[$dd] = $this->Mod_crud->getData('result','*', $database,null,null,null,null,null,null,${'dt'.$dd});
			$dtfield[$dd] 	= $this->Mod_crud->get_field_info($database);
			$total = $this->Mod_crud->countData('result','*', $database,null,null,null,null,null,null,${'dt'.$dd});
			if ($total > 0) {
				$db[$dd] 	= $key;
			}
		}

		$data = array(
				'title' 	=> "Keyword : ".$search,
				'dSearch' 	=> $dtsearch,
				'dField'	=> $dtfield,
				'db'		=> $db,
				'keyword'		=> $search,
			);
		$this->load->view('pages/report/PrintResult', $data);
		// echo json_encode($dtsearch);
		// echo json_encode($dtField);
		// echo json_encode($db);
		// echo 'Data base : '.$dtbase[0].' '.$dtbase[1].' '.$dtbase[2];
		// echo ' Keyword : '.$key;
	}


}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */
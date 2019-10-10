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

	public function print_company($id=null)
	{
		$data = array(
				'title' => name_company($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_company_profile',null,null,null,array('companyID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_company_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_comunity($id=null)
	{
		$data = array(
				'title' => name_comunity($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_comunity_profile',null,null,null,array('comunityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_university($id=null)
	{
		$data = array(
				'title' => name_university($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_university_profile',null,null,null,array('universityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_university_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_result()
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
				${'dt'. $dd}[] = $key1->name." LIKE '%".$search."%'";
			}
			//echo json_encode(${'dt'.$dd});
			$likes 	= implode(' OR ',${'dt'.$dd});
			$dtsearch[$dd] = $this->Mod_crud->getData('result','*', $database,null,null,null,null,null,null,$likes);
			$dtfield[$dd] 	= $this->Mod_crud->get_field_info($database);
			$total = $this->Mod_crud->countData('result','*', $database,null,null,null,null,null,null,$likes);
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

	public function print_result_company()
	{
		$field  = explode(',', $this->input->post('Field'));
		$sector  = $this->input->post('Sector');
		$keyword  = $this->input->post('Keyword');
		
		if ($sector) {
			$where = array('cp.sectorCompany = "'.$sector.'"');

		}else{
			$where = null;
		}

		if (!empty($field[0])) {
			$select[] = 'cp.'.$field[0];
			$like[] = 'cp.'.$field[0].' LIKE "%'.$keyword.'%" ';
		}

		if (!empty($field[1])) {
			$select[] = 'cp.'.$field[1];
			$like[] = 'cp.'.$field[1].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[2])) {
			$select[] = 'cp.'.$field[2];
			$like[] = 'cp.'.$field[2].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[3])) {
			$select[] = 'cp.'.$field[3];
			$like[] = 'cp.'.$field[3].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[4])) {
			$select[] = 'cp.'.$field[4];
			$like[] = 'cp.'.$field[4].' LIKE "%'.$keyword.'%" ';
		}

		
		$lk = implode(' OR ', $like);
		$sl = implode(', ', $select);
		
		$data = array(
				'title' 	=> "Company Profile",
				'dSearch' 	=> $this->Mod_crud->getData('result','cp.companyProfileID, cp.companyID, '.$sl, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$lk),
				'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID, cp.companyID, '.$sl, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$lk),
				'keyword' 	=> $keyword,
			);
		$this->load->view('pages/report/PrintResultData', $data);
	}

		public function print_result_university()
	{
		$field  = explode(',', $this->input->post('Field'));
		$mou 	= $this->input->post('Mou');
		$keyword  = $this->input->post('Keyword');
		
		if ($mou) {
			$where = array('c.mou = "'.$mou.'"');

		}else{
			$where = null;
		}

		if (!empty($field[0])) {
			$select[] = 'cp.'.$field[0];
			$like[] = 'cp.'.$field[0].' LIKE "%'.$keyword.'%" ';
		}

		if (!empty($field[1])) {
			$select[] = 'cp.'.$field[1];
			$like[] = 'cp.'.$field[1].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[2])) {
			$select[] = 'cp.'.$field[2];
			$like[] = 'cp.'.$field[2].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[3])) {
			$select[] = 'cp.'.$field[3];
			$like[] = 'cp.'.$field[3].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[4])) {
			$select[] = 'cp.'.$field[4];
			$like[] = 'cp.'.$field[4].' LIKE "%'.$keyword.'%" ';
		}

		
		$lk = implode(' OR ', $like);
		$sl = implode(', ', $select);
		
		$data = array(
				'title' 	=> "University Profile",
				'dSearch' 	=> $this->Mod_crud->getData('result','cp.universityProfileID, cp.universityID, '.$sl, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$lk),
				'dField'	=> $this->Mod_crud->qry_field_info('cp.universityProfileID, cp.universityID, '.$sl, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$lk),
				'keyword' 	=> $keyword,
			);
		$this->load->view('pages/report/PrintResultData', $data);
	}

			public function print_result_comunity()
	{
		$field  = explode(',', $this->input->post('Field'));
		$type 	= $this->input->post('Type');
		$keyword  = $this->input->post('Keyword');
		
		if ($type) {
			$where = array('cp.typeComunity = "'.$type.'"');

		}else{
			$where = null;
		}

		if (!empty($field[0])) {
			$select[] = 'cp.'.$field[0];
			$like[] = 'cp.'.$field[0].' LIKE "%'.$keyword.'%" ';
		}

		if (!empty($field[1])) {
			$select[] = 'cp.'.$field[1];
			$like[] = 'cp.'.$field[1].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[2])) {
			$select[] = 'cp.'.$field[2];
			$like[] = 'cp.'.$field[2].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[3])) {
			$select[] = 'cp.'.$field[3];
			$like[] = 'cp.'.$field[3].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[4])) {
			$select[] = 'cp.'.$field[4];
			$like[] = 'cp.'.$field[4].' LIKE "%'.$keyword.'%" ';
		}

		
		$lk = implode(' OR ', $like);
		$sl = implode(', ', $select);
		
		$data = array(
				'title' 	=> "Comunity Profile",
				'dSearch' 	=> $this->Mod_crud->getData('result','cp.comunityProfileID, cp.comunityID, '.$sl, 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID'),$where,null,null,$lk),
				'dField'	=> $this->Mod_crud->qry_field_info('cp.comunityProfileID, cp.comunityID, '.$sl, 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID'),$where,null,null,$lk),
				'keyword' 	=> $keyword,
			);
		$this->load->view('pages/report/PrintResultData', $data);
	}

}

/* End of file Laporan.php */
/* Location: ./application/controllers/Laporan.php */
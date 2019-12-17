<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {
//controller report

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('userlog')['is_login'] == FALSE) ://jika islogin bernilai false
			redirect(base_url('auth')) ;//kembali ke auth login
		endif;
		$this->load->model('Mod_crud');//load model mod crud
		$this->load->library('Fpdf');//load library fpdf
		define('FPDF_FONTPATH',$this->config->item('fonts_path'));//set font 
	}

	public function index()
	{

	}

	public function print_company($id=null)//print company by id
	{
		$data = array(
				'title' => name_company($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_company_profile',null,null,null,array('companyID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_company_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_comunity($id=null)//print comunity by id
	{
		$data = array(
				'title' => name_comunity($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_comunity_profile',null,null,null,array('comunityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_university($id=null)//print university by id
	{
		$data = array(
				'title' => name_university($id)." Profile",
				'dtProfile' => $this->Mod_crud->getData('row', '*','t_university_profile',null,null,null,array('universityID = "'.$id.'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_university_profile'),
			);
		$this->load->view('pages/report/PrintProfile', $data);
	}

	public function print_result()//print data hasil pencarian
	{
		//pisahkan post dtbase
		$dtbase = explode(",", $this->input->post('dtbase'));
		//post keyword
		$search	= $this->input->post('key');
		$db 	= array(); //set db ke array

		$no = 0;
		foreach ($dtbase as $key) {//looping dtbase
			$no++;
			//set table
			$database = 't_'.$key.'_profile';
			//ambil field table
			$field = $this->Mod_crud->get_field_info($database);
			
			if ($key=='company') {//jika key = company
				$dd = 'cp';
			}elseif ($key=='comunity') {//jika key = comunity
				$dd = 'cm';
			}else{
				$dd = 'un';
			}

			$i = 0;
			foreach ($field as $key1) {//looping $field
				$i++;
				${'dt'. $dd}[] = $key1->name." LIKE '%".$search."%'";//query like
			}
			$likes 	= implode(' OR ',${'dt'.$dd});//buat query like
			//data pencarian
			$dtsearch[$dd] = $this->Mod_crud->getData('result','*', $database,null,null,null,null,null,null,$likes);
			//field tabel
			$dtfield[$dd] 	= $this->Mod_crud->get_field_info($database);
			//total data pencarian
			$total = $this->Mod_crud->countData('result','*', $database,null,null,null,null,null,null,$likes);
			if ($total > 0) {
				$db[$dd] 	= $key;
			}
		}

		$data = array(
				'title' 	=> "Keyword : ".$search,//title report
				'dSearch' 	=> $dtsearch,//data report
				'dField'	=> $dtfield,//field table
				'db'		=> $db,//table
				'keyword'	=> $search,//kata kunci
			);
		$this->load->view('pages/report/PrintResult', $data);//load print result
	}

	public function print_result_company()//print result company
	{
		$field  = explode(',', $this->input->post('Field'));//memisahkan post field yang 
		$sector  = $this->input->post('Sector');//tampung post sector
		$keyword  = $this->input->post('Keyword');//tampung post keyword
		
		if ($sector) {//jika sector memiliki nilai
			//query where
			$where = array('cp.sectorCompany = "'.$sector.'"');

		}else{
			$where = null;
		}

		if (!empty($field[0])) {//jika $field 0 tidak kosong
			//query select
			$select[] = 'cp.'.$field[0];
			//query like
			$like[] = 'cp.'.$field[0].' LIKE "%'.$keyword.'%" ';
		}

		if (!empty($field[1])) {//jika field 1 tidak kosong
			//query select
			$select[] = 'cp.'.$field[1];
			//query like
			$like[] = 'cp.'.$field[1].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[2])) {//jika field 2 tidak kosong
			$select[] = 'cp.'.$field[2];
			$like[] = 'cp.'.$field[2].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[3])) {//jika field 3 tidak kosong
			$select[] = 'cp.'.$field[3];
			$like[] = 'cp.'.$field[3].' LIKE "%'.$keyword.'%" ';
		}
		if (!empty($field[4])) {//jika field 4 tidak kosong
			$select[] = 'cp.'.$field[4];
			$like[] = 'cp.'.$field[4].' LIKE "%'.$keyword.'%" ';
		}

		//tampung query like
		$lk = implode(' OR ', $like);
		//tampung query select
		$sl = implode(', ', $select);
		
		$data = array(
				'title' 	=> "Company Profile",//title company
				//data pencarian
				'dSearch' 	=> $this->Mod_crud->getData('result','cp.companyProfileID, cp.companyID, '.$sl, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$lk),
				//field tabel
				'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID, cp.companyID, '.$sl, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$lk),
				'keyword' 	=> $keyword,//kata kunci
			);
		$this->load->view('pages/report/PrintResultData', $data);//load view print result data
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
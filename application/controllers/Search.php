<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Search extends CommonDash {
//controller untuk fiur seacrh all data
	public function __construct()
	{
		parent::__construct();
		
	}
	//search index
	public function index()
	{
		$data = array(// generate js
			'_JS' => generate_js(array(
						"dashboards/js/plugins/ui/moment/moment.min.js",
						"dashboards/js/plugins/tables/datatables/datatables.min.js",
						"dashboards/js/plugins/tables/datatables/extensions/responsive.min.js",
						"dashboards/js/plugins/forms/selects/select2.min.js",
						"dashboards/js/pages/datatables_responsive.js",
						"dashboards/js/plugins/forms/styling/switch.min.js",
						"dashboards/js/plugins/forms/styling/switchery.min.js",
						"dashboards/js/plugins/forms/styling/uniform.min.js",
						"dashboards/js/plugins/uploaders/fileinput.min.js",
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/pickers/anytime.min.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/search-script.js",
				)
			),
			'titleWeb' => 'Search Data',//title web
			'breadcrumb' => explode(',', 'Dashboard,Search Data'),//bread crumb
		);
		$this->render('dashboard', 'pages/search/index', $data);//load view search index
	}

		public function searchData()//aksi search data
	{	
		//ambil inputan search
		$search 	= $this->input->post('inputsearch');
		$db 		= array();// db set array

		if ($search) {//jika search ada inputan
			//ambil field table company profile
			$cp = $this->Mod_crud->get_field_info('t_company_profile');
			$i = 0; 
			foreach ($cp as $key) {//looping data cp field
				$i++;

				$dt[] = $key->name.' LIKE "%'.$search.'%" ';//array data
			}
			$like = implode(" OR ", $dt);//selipkan 'or' pada data
			//ambil company profile ke array dtsearch cp
			$dtsearch['cp'] = $this->Mod_crud->getData('result','*', 't_company_profile',null,null,null,null,null,null,$like);
			//ambil company field ke array dtfield cp
			$dtField['cp'] 	= $this->Mod_crud->get_field_info('t_company_profile');
			//menghitung total data company profile
			$total1 = $this->Mod_crud->countData('result','*', 't_company_profile',null,null,null,null,null,null,$like);
			if ($total1 > 0) {//jika total lebih dari nol
				$db['cp'] 		= 'company';//company ke array cp
			}
		}

		if ($search) {
			$cm = $this->Mod_crud->get_field_info('t_comunity_profile');
			$i = 0;
			foreach ($cm as $key) {
				$i++;
				$dt1[] = $key->name.' LIKE "%'.$search.'%" ';
			}
			$like = implode(" OR ", $dt1);
			$dtsearch['cm'] = $this->Mod_crud->getData('result','*', 't_comunity_profile',null,null,null,null,null,null,$like);
			$dtField['cm']	= $this->Mod_crud->get_field_info('t_comunity_profile');
			$total2 	= $this->Mod_crud->countData('result','*', 't_comunity_profile',null,null,null,null,null,null,$like);
			if ($total2 > 0) {
				$db['cm'] 		= 'comunity';
			}

		}

		if ($search) {
			$un = $this->Mod_crud->get_field_info('t_university_profile');
			$i = 0;
			foreach ($un as $key) {
				$i++;
				$dt2[] = $key->name.' LIKE "%'.$search.'%" ';
			}
			$like = implode(" OR ", $dt2);
			$dtsearch['un'] = $this->Mod_crud->getData('result','*', 't_university_profile',null,null,null,null,null,null,$like);
			$dtField['un'] 	= $this->Mod_crud->get_field_info('t_university_profile');
			$total3	 	= $this->Mod_crud->countData('result','*', 't_university_profile',null,null,null,null,null,null,$like);
			if ($total3 > 0) {
				$db['un'] 		= 'university';
			}

		}

		$data = array(
			'_JS' => generate_js(array(
						"dashboards/js/plugins/ui/moment/moment.min.js",
						"dashboards/js/plugins/tables/datatables/datatables.min.js",
						"dashboards/js/plugins/tables/datatables/extensions/scroller.min.js",
						"dashboards/js/plugins/forms/selects/select2.min.js",
						"dashboards/js/pages/datatables_responsive.js",
						"dashboards/js/plugins/forms/styling/switch.min.js",
						"dashboards/js/plugins/forms/styling/switchery.min.js",
						"dashboards/js/plugins/forms/styling/uniform.min.js",
						"dashboards/js/plugins/uploaders/fileinput.min.js",
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/pickers/anytime.min.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/search-script.js",
				)
			),
			'titleWeb' 	=> 'Result',
			'breadcrumb'=> explode(',', 'Dashboard,Search Data'),
			'dMaster'	=> $dtsearch,//hasil pencarian
			'dField'	=> $dtField,//data field table
			'db'		=> $db,
			'keyword'	=> $search,//kata kunvi yang di cari
			'countotal'	=> $total1 + $total2 + $total3,//total data yang berhasil di cari
		);
		$this->render('dashboard', 'pages/search/result', $data);//load view search result

	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
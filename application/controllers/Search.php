<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Search extends CommonDash {

	public function __construct()
	{
		parent::__construct();
		
	}

	public function index()
	{
		$data = array(
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
			'titleWeb' => 'Search Data',
			'breadcrumb' => explode(',', 'Dashboard,Search Data'),
		);
		$this->render('dashboard', 'pages/search/index', $data);
	}

		public function searchData()
	{	
		$search 	= $this->input->post('inputsearch');
		$db 		= array();

		if ($search) {
			$cp = $this->Mod_crud->get_field_info('t_company_profile');
			$i = 0; 
			foreach ($cp as $key) {
				$i++;

				$dt[] = $key->name.' LIKE "%'.$search.'%" ';
			}
			$like = implode(" OR ", $dt);
			$dtsearch['cp'] = $this->Mod_crud->getData('result','*', 't_company_profile',null,null,null,null,null,null,$like);
			$dtField['cp'] 	= $this->Mod_crud->get_field_info('t_company_profile');
			$total1 = $this->Mod_crud->countData('result','*', 't_company_profile',null,null,null,null,null,null,$like);
			if ($total1 > 0) {
				$db['cp'] 		= 'company';
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
			'dMaster'	=> $dtsearch,
			'dField'	=> $dtField,
			'db'		=> $db,
			'keyword'	=> $search,
			'countotal'	=> $total1 + $total2 + $total3,
		);
		$this->render('dashboard', 'pages/search/result', $data);

	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */
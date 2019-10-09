<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Company extends CommonDash {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_crud');
	}

	public function index()
	{
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
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/company-index-script.js",
				)
			),
			'titleWeb' => "Company Profile",
			'breadcrumb' => explode(',', 'Company,Company List'),
			'dMaster'	=> $this->Mod_crud->getData('result','cp.companyProfileID,cp.companyID,cp.companyName,cp.sectorCompany,cp.EmailAddress', 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID')),
			'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID,cp.companyID,cp.companyName,cp.sectorCompany,cp.EmailAddress', 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID')),
			
		);
		$this->render('dashboard', 'pages/company/index', $data);
	}

	public function form($id=null)
	{	
		$data = array(
			'_JS' => generate_js(array(
					"dashboards/js/plugins/ui/moment/moment.min.js",
					"dashboards/js/plugins/forms/validation/validate.min.js",
					"dashboards/js/plugins/forms/selects/select2.min.js",
					"dashboards/js/plugins/forms/styling/switch.min.js",
					"dashboards/js/plugins/forms/styling/switchery.min.js",
					"dashboards/js/plugins/forms/styling/uniform.min.js",
					"dashboards/js/plugins/uploaders/fileinput.min.js",
					"dashboards/js/plugins/pickers/pickadate/picker.js",
					"dashboards/js/plugins/pickers/pickadate/picker.date.js",
					"dashboards/js/plugins/pickers/anytime.min.js",
					"dashboards/js/pages/company-script.js",
				)
			),
		    'titleWeb'   => "Form Company Profile",
		    'dMaster'	 => $this->Mod_crud->getData('row', '*', 't_company_profile', null, null, null, array('companyID = "'.$id.'"')),
		    'dField'	 => $this->Mod_crud->get_field_info('t_company_profile'),
		    'breadcrumb' => explode(',', 'Company, Form Company Profile'),
		    'actionForm' => base_url('company/save_form'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/company/formProfile', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_Add(){
		$data = array(
				'modalTitle' => 'Add Company ',
				'formAction' => base_url('company/save'),
				'Req' => ''
			);
		$this->load->view('pages/company/form', $data);
	}

	public function save(){
		$cek = $this->Mod_crud->checkData('companyName', 't_company', array('companyName = "'.$this->input->post('Companyname').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Company has been registered'));
		}else{

			$id 		= $this->Mod_crud->autoNumber('companyID','t_company','CP-',3);
			$idprofile 	= $this->Mod_crud->autoNumber('companyProfileID','t_company_profile','ID-'.$id,0);

			$save = $this->Mod_crud->insertData('t_company', array(
						'companyID' 		=> $id,
						'companyName' 		=> $this->input->post('Companyname'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			$savepro = $this->Mod_crud->insertData('t_company_profile', array(
						'companyProfileID' 	=> $idprofile,
						'companyID' 		=> $id,
						'companyName' 		=> $this->input->post('Companyname'),
           			)
           		);
			helper_log('add','Add New Company ( '.$this->input->post('Companyname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){
				$this->alert->set('bg-success', "Insert success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function save_form(){

			$update = $this->Mod_crud->updateData('t_company', array(
						'companyName'	=> $this->input->post('companyName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('companyID ' => $this->input->post('companyID'))
           		);
			$up = $this->Mod_crud->get_field_info('t_company_profile');
			foreach ($up as $key) {
				$updateProfile = $this->Mod_crud->updateData('t_company_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('companyProfileID ' => $this->input->post('companyProfileID'))
           		);	
			}

			helper_log('edit','Update Profile Company ( '.$this->input->post('companyName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){
				$this->alert->set('bg-success', "Update success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('company')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_edit(){
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_company', null, null, null, array('companyID = "'.$ID[0].'"')),
				'formAction' => base_url('company/edit'),
				'Req' => ''
			);
		$this->load->view('pages/company/form', $data);
	}

	public function edit(){
		$cek = $this->Mod_crud->checkData('companyName', 't_company', array('companyName = "'.$this->input->post('Companyname').'"', 'companyID != "'.$this->input->post('Companyid').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Company has been registered'));
		}else{

			$update = $this->Mod_crud->updateData('t_company', array(
						'companyName'	=> $this->input->post('Companyname'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('companyID ' => $this->input->post('Companyid'))
           		);

			$update = $this->Mod_crud->updateData('t_company_profile', array(
						'companyName'	=> $this->input->post('Companyname'),
           			), array('companyID ' => $this->input->post('Companyid'))
           		);
			helper_log('edit','Edit Company ( '.$this->input->post('Companyname').' )',$this->session->userdata('userlog')['sess_usrID']);

			if ($update){
				$this->alert->set('bg-success', "Update success !");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete(){
		$query 		= $this->Mod_crud->deleteData('t_company', array('companyID' => $this->input->post('id')));
		if ($query){
			$delpro	= $this->Mod_crud->deleteData('t_company_profile', array('companyID' => $this->input->post('id')));
			$data = array(
					'code' => 200,
					'pesan' => 'Success Delete !',
					'aksi' => 'setTimeout("window.location.reload();",1500)'
              	);
			echo json_encode($data);
		}else{
			echo '';
		}
		
	}

/////////////////////////////////////////////////////////////////////////////////////////

		public function form_field($id=null)
	{	
		$data = array(
			'_JS' => generate_js(array(
					"dashboards/js/plugins/ui/moment/moment.min.js",
					"dashboards/js/plugins/forms/validation/validate.min.js",
					"dashboards/js/plugins/forms/selects/select2.min.js",
					"dashboards/js/plugins/forms/styling/switch.min.js",
					"dashboards/js/plugins/forms/styling/switchery.min.js",
					"dashboards/js/plugins/forms/styling/uniform.min.js",
					"dashboards/js/plugins/uploaders/fileinput.min.js",
					"dashboards/js/plugins/pickers/pickadate/picker.js",
					"dashboards/js/plugins/pickers/pickadate/picker.date.js",
					"dashboards/js/plugins/pickers/anytime.min.js",
					"dashboards/js/pages/company-script.js",
				)
			),
		    'titleWeb'   => "Add Field",
		    'companyID'	 => $id,
		    'breadcrumb' => explode(',', 'Company, Add Record Field'),
		    'actionForm' => base_url('company/add_field'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/company/formField', $data);
	}

	public function get_typedata()
	{
		$resp = array();
		$data = $this->Mod_crud->getData('result', 'Type', 't_type_data');
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key->Type;
				$mk['text'] = $key->Type;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

	public function get_sector()
	{
		$resp = array();
		$data = $this->Mod_crud->getData('result', 'sectorCompany', 't_company_sector');
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key->sectorCompany;
				$mk['text'] = $key->sectorCompany;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

		public function get_field()
	{
		$resp = array();
		$data = $this->Mod_crud->get_field_info('t_company_profile');
		if (!empty($data)) {
			foreach ($data as $key) {
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				if ($name == 'companyProfileID' OR $name == 'companyID') {
					
				}else{
				$mk['id'] 	= $key->name;
				$mk['text'] = ucwords($pass2);
				array_push($resp, $mk);
				}
			}
		}
		echo json_encode($resp);
	}

	public function add_field()
	{
		$field 	= $this->input->post('Fieldname');
		$type 	= $this->input->post('Typedata');
		$length = $this->input->post('Lengthdata');
		$after 	= $this->input->post('After');
		$companyID = $this->input->post('Companyid');

	  	if ($type=='DATE') {
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		
		$add = $this->Mod_crud->query('ALTER TABLE `t_company_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');

		helper_log('add','Add New Coloumn Field ( '.$field.' ) In Table Company Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){
			$this->alert->set('bg-success', "Add Field success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field success !', 'aksi' => "window.location.href='".base_url('company/form/').$companyID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function delete_field()
	{
		$query 		= $this->Mod_crud->query('ALTER TABLE `t_company_profile` DROP `'.$this->input->post('id').'`');
		if ($query){
			$data = array(
					'code' 	=> 200,
					'pesan' => 'Success Delete !',
					'aksi' 	=> 'setTimeout("window.location.reload();",1500)'
              	);
			echo json_encode($data);
		}else{
			echo '';
		}
		
	}

	public function modal_profile()
	{
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Profile '.$ID[1],
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_company_profile', null, null, null, array('companyID = "'.$ID[0].'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_company_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/company/previewProfile', $data);
	}


	public function search()
	{
		$sector 		= $this->input->post('Sector');
		$keyword 		= $this->input->post('Keyword');
		$field1 		= $this->input->post('Field1');
		$field2 		= $this->input->post('Field2');
		$field3 		= $this->input->post('Field3');
		$field4 		= $this->input->post('Field4');
		$field5 		= $this->input->post('Field5');

		if ($sector) {
			$where = array('cp.sectorCompany = "'.$sector.'"');		
		}else{
			$where = null;
		}

		if ($field1) {
			$field[1] = $field1;
			$select[] = 'cp.'.$field1;
			$like[] = 'cp.'.$field1.' LIKE "%'.$keyword.'%" ';
		}
		if ($field2) {
			$field[2] = $field2;
			$select[] = 'cp.'.$field2;
			$like[] = 'cp.'.$field2.' LIKE "%'.$keyword.'%" ';
		}
		if ($field3) {
			$field[3] = $field3;
			$select[] = 'cp.'.$field3;
			$like[] = 'cp.'.$field3.' LIKE "%'.$keyword.'%" ';
		}
		if ($field4) {
			$field[4] = $field4;
			$select[] = 'cp.'.$field4;
			$like[] = 'cp.'.$field4.' LIKE "%'.$keyword.'%" ';
		}
		if ($field5) {
			$field[5] = $field5;
			$select[] = 'cp.'.$field5;
			$like[] = 'cp.'.$field5.' LIKE "%'.$keyword.'%" ';
		}
		$slct 	= implode(', ', $select);
		$likes 	= implode(' OR ',$like);

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
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/company-index-script.js",
				)
			),
			'titleWeb'	=> "Company Profile",
			'breadcrumb'=> explode(',', 'Company,Company List'),
			'dMaster'	=> $this->Mod_crud->getData('result','cp.companyProfileID, cp.companyID, '.$slct, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$likes),
			'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID, cp.companyID, '.$slct, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$likes),	
			'sector'	=> $sector,
			'keyword'	=> $keyword,
			'field'		=> $field,
		);
		$this->render('dashboard', 'pages/company/result', $data);
	}


}

/* End of file company.php */
/* Location: ./application/controllers/company.php */
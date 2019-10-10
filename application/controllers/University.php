<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class University extends CommonDash {

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
						"dashboards/js/pages/university-index-script.js",
				)
			),
			'titleWeb' 	 => "University Profile",
			'breadcrumb' => explode(',', 'University,University List'),
			'dMaster'	=> $this->Mod_crud->getData('result','cp.universityProfileID, cp.universityID, cp.universityName, cp.EmailAddress, cp.UniversityAddress, c.mou', 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID')),
			'dField'	=> $this->Mod_crud->qry_field_info('cp.universityProfileID, cp.universityID, cp.universityName, cp.EmailAddress, cp.UniversityAddress, c.mou', 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID')),
		);
		$this->render('dashboard', 'pages/university/index', $data);
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
					"dashboards/js/pages/university-script.js",
				)
			),
		    'titleWeb'   => "Form University Profile",
		    'dMaster'	 => $this->Mod_crud->getData('row', '*', 't_university_profile', null, null, null, array('universityID = "'.$id.'"')),
		    'dField'	 => $this->Mod_crud->get_field_info('t_university_profile'),
		    'breadcrumb' => explode(',', 'University, Form University Profile'),
		    'actionForm' => base_url('university/save_form'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/university/formProfile', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_add(){
		$data = array(
				'modalTitle' => 'Add university ',
				'formAction' => base_url('university/save'),
				'Req' => ''
			);
		$this->load->view('pages/university/form', $data);
	}

	public function save(){
		$cek = $this->Mod_crud->checkData('universityName', 't_university', array('universityName = "'.$this->input->post('Universityname').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'University has been registered'));
		}else{

			$id 		= $this->Mod_crud->autoNumber('universityID','t_university','MUV-',3);
			$idprofile 	= $this->Mod_crud->autoNumber('universityProfileID','t_university_profile','ID-'.$id.'-',2);

			$save = $this->Mod_crud->insertData('t_university', array(
						'universityID' 		=> $id,
						'universityName' 	=> $this->input->post('Universityname'),
						'mou'				=> $this->input->post('Mou'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			$savepro = $this->Mod_crud->insertData('t_university_profile', array(
						'universityProfileID'	=> $idprofile,
						'universityID' 			=> $id,
						'universityName' 		=> $this->input->post('Universityname'),
           			)
           		);
			helper_log('add','Add New University ( '.$this->input->post('Universityname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){
				$this->alert->set('bg-success', "Insert Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert Success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function save_form(){

			$update = $this->Mod_crud->updateData('t_university', array(
						'universityName'=> $this->input->post('universityName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('universityID ' => $this->input->post('universityID'))
           		);
			$up = $this->Mod_crud->get_field_info('t_university_profile');
			foreach ($up as $key) {
				$updateProfile = $this->Mod_crud->updateData('t_university_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('universityProfileID ' => $this->input->post('universityProfileID'))
           		);	
			}

			helper_log('edit','Update Profile University ( '.$this->input->post('universityName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){
				$this->alert->set('bg-success', "Update Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('university')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_edit(){
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_university', null, null, null, array('universityID = "'.$ID[0].'"')),
				'formAction' => base_url('university/edit'),
				'Req' => ''
			);
		$this->load->view('pages/university/form', $data);
	}

	public function edit(){
		$cek = $this->Mod_crud->checkData('universityName', 't_university', array('universityName = "'.$this->input->post('Universityname').'"', 'universityID != "'.$this->input->post('Universityid').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'university has been registered'));
		}else{

			$update = $this->Mod_crud->updateData('t_university', array(
						'universityName'=> $this->input->post('Universityname'),
						'mou'			=> $this->input->post('Mou'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('universityID ' => $this->input->post('Universityid'))
           		);

			$update = $this->Mod_crud->updateData('t_university_profile', array(
						'universityName'	=> $this->input->post('Universityname'),
           			), array('universityID ' => $this->input->post('Universityid'))
           		);
			helper_log('edit','Edit University ( '.$this->input->post('Universityname').' )',$this->session->userdata('userlog')['sess_usrID']);

			if ($update){
				$this->alert->set('bg-success', "Update Success !");
       			echo json_encode(array('code' => 200, 'message' => 'Update Success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete(){
		$query 		= $this->Mod_crud->deleteData('t_university', array('universityID' => $this->input->post('id')));
		if ($query){
			$delpro	= $this->Mod_crud->deleteData('t_university_profile', array('universityID' => $this->input->post('id')));
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
					"dashboards/js/pages/university-script.js",
				)
			),
		    'titleWeb'   	=> "Add Field",
		    'universityID'	=> $id,
		    'breadcrumb' 	=> explode(',', 'university, Add Field'),
		    'actionForm' 	=> base_url('university/add_field'),
		    'buttonForm' 	=> 'Save'
		);

		$this->render('dashboard', 'pages/university/formField', $data);
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

		public function get_mou()
	{
		$resp = array();
		for ($i=0; $i < 2; $i++) { 
			if ($i==1) {
				$mk['id'] = 'YES';
				$mk['text'] = 'YES';
				array_push($resp, $mk);
			}else{
				$mk['id'] = 'NO';
				$mk['text'] = 'NO';
				array_push($resp, $mk);
			}
		}		
		echo json_encode($resp);
	}

		public function get_field()
	{
		$resp = array();
		$data = $this->Mod_crud->get_field_info('t_university_profile');
		if (!empty($data)) {
			foreach ($data as $key) {
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				if ($name == 'universityProfileID' OR $name == 'universityID') {
					
				}else{
					$mk['id'] = $key->name;
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
		$universityID = $this->input->post('Universityid');

	  	if ($type=='DATE') {
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		
		$add = $this->Mod_crud->query('ALTER TABLE `t_university_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');

		helper_log('add','Add New Coloumn Field ( '.$field.' ) In Table university Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){
			$this->alert->set('bg-success', "Add Field Success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field Success !', 'aksi' => "window.location.href='".base_url('university/form/').$universityID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function delete_field()
	{
		$query 		= $this->Mod_crud->query('ALTER TABLE `t_university_profile` DROP `'.$this->input->post('id').'`');
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
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_university_profile', null, null, null, array('universityID = "'.$ID[0].'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_university_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/university/previewProfile', $data);
	}

	public function search()
	{
		$mou 			= $this->input->post('Mou');
		$keyword 		= $this->input->post('Keyword');
		$field1 		= $this->input->post('Field1');
		$field2 		= $this->input->post('Field2');
		$field3 		= $this->input->post('Field3');
		$field4 		= $this->input->post('Field4');
		$field5 		= $this->input->post('Field5');

		if ($mou) {
			$where = array('c.mou = "'.$mou.'"');		
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
						"dashboards/js/pages/university-index-script.js",
				)
			),
			'titleWeb'	=> "University Profile",
			'breadcrumb'=> explode(',', 'university,university List'),
			'dMaster'	=> $this->Mod_crud->getData('result','cp.universityProfileID, cp.universityID, '.$slct, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$likes),
			'dField'	=> $this->Mod_crud->qry_field_info('cp.universityProfileID, cp.universityID, '.$slct, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$likes),	
			'mou'		=> $mou,
			'keyword'	=> $keyword,
			'field'		=> $field,
		);
		$this->render('dashboard', 'pages/university/result', $data);
	}


}

/* End of file university.php */
/* Location: ./application/controllers/university.php */
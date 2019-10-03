<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Comunity extends CommonDash {

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
						"dashboards/js/plugins/tables/datatables/extensions/responsive.min.js",
						"dashboards/js/plugins/forms/selects/select2.min.js",
						"dashboards/js/pages/datatables_responsive.js",
						"dashboards/js/plugins/forms/styling/switch.min.js",
						"dashboards/js/plugins/forms/styling/switchery.min.js",
						"dashboards/js/plugins/forms/styling/uniform.min.js",
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/comunity-index-script.js",
				)
			),
			'titleWeb' => "Comunity Profile",
			'breadcrumb' => explode(',', 'Comunity,Comunity List'),
			'dMaster'	=> $this->Mod_crud->getData('result','c.*,cp.*', 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID')),
			'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'),
		);
		$this->render('dashboard', 'pages/comunity/index', $data);
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
					"dashboards/js/pages/comunity-script.js",
				)
			),
		    'titleWeb'   => "Form Comunity Profile",
		    'dMaster'	 => $this->Mod_crud->getData('row', '*', 't_comunity_profile', null, null, null, array('comunityID = "'.$id.'"')),
		    'dField'	 => $this->Mod_crud->get_field_info('t_comunity_profile'),
		    'breadcrumb' => explode(',', 'Comunity, Form Comunity Profile'),
		    'actionForm' => base_url('comunity/saveFrom'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/comunity/formProfile', $data);
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modalAdd(){
		$data = array(
				'modalTitle' => 'Add Comunity ',
				'formAction' => base_url('comunity/save'),
				'Req' => ''
			);
		$this->load->view('pages/comunity/form', $data);
	}

	public function save(){
		$cek = $this->Mod_crud->checkData('comunityName', 't_comunity', array('comunityName = "'.$this->input->post('Comunityname').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Comunity has been registered'));
		}else{

			$id 		= $this->Mod_crud->autoNumber('comunityID','t_comunity','CM-',3);
			$idprofile 	= $this->Mod_crud->autoNumber('comunityProfileID','t_comunity_profile','ID-'.$id,0);

			$save = $this->Mod_crud->insertData('t_comunity', array(
						'comunityID' 		=> $id,
						'comunityName' 		=> $this->input->post('Comunityname'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			$savepro = $this->Mod_crud->insertData('t_comunity_profile', array(
						'comunityProfileID' => $idprofile,
						'comunityID' 		=> $id,
						'comunityName' 		=> $this->input->post('Comunityname'),
           			)
           		);
			helper_log('add','Add New Comunity ( '.$this->input->post('Comunityname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){
				$this->alert->set('bg-success', "Insert Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert Success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function saveFrom(){

			$update = $this->Mod_crud->updateData('t_comunity', array(
						'comunityName'	=> $this->input->post('comunityName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('comunityID ' => $this->input->post('comunityID'))
           		);
			$up = $this->Mod_crud->get_field_info('t_comunity_profile');
			foreach ($up as $key) {
				$updateProfile = $this->Mod_crud->updateData('t_comunity_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('comunityProfileID ' => $this->input->post('comunityProfileID'))
           		);	
			}

			helper_log('edit','Update Profile Comunity ( '.$this->input->post('comunityName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){
				$this->alert->set('bg-success', "Update Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('comunity')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modalEdit(){
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_comunity', null, null, null, array('comunityID = "'.$ID[0].'"')),
				'formAction' => base_url('comunity/edit'),
				'Req' => ''
			);
		$this->load->view('pages/comunity/form', $data);
	}

	public function edit(){
		$cek = $this->Mod_crud->checkData('comunityName', 't_comunity', array('comunityName = "'.$this->input->post('Comunityname').'"', 'comunityID != "'.$this->input->post('Comunityid').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'comunity has been registered'));
		}else{

			$update = $this->Mod_crud->updateData('t_comunity', array(
						'comunityName'	=> $this->input->post('Comunityname'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('comunityID ' => $this->input->post('Comunityid'))
           		);

			$update = $this->Mod_crud->updateData('t_comunity_profile', array(
						'comunityName'	=> $this->input->post('Comunityname'),
           			), array('comunityID ' => $this->input->post('Comunityid'))
           		);
			helper_log('edit','Edit Comunity ( '.$this->input->post('Comunityname').' )',$this->session->userdata('userlog')['sess_usrID']);

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
		$query 		= $this->Mod_crud->deleteData('t_comunity', array('comunityID' => $this->input->post('id')));
		if ($query){
			$delpro	= $this->Mod_crud->deleteData('t_comunity_profile', array('comunityID' => $this->input->post('id')));
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

	public function getList()
	{
		$res = array();
		$comunity = $this->Mod_crud->getData('result','*', 't_comunity');
		if (!empty($comunity)) {
			$no = 0;
			foreach ($comunity as $key) {
				$no++;
				array_push($res, array(
							'',
							$no,
							$key->comunityID,
							$key->comunityName,
							'
							<a style="margin-bottom: 5px" class="btn btn-primary" href='.base_url('comunity/form/').$key->comunityID.'><i class="icon-file-plus"></i> Add / Edit Profile</a>
							<a style="margin-bottom: 5px" class="btn btn-primary" onclick="showModal(`'.base_url("comunity/modalEdit").'`, `'.$key->comunityID.'~'.$key->comunityName.'`, `editcomunity`);"><i class="icon-quill4"></i> Edit</a>
							<a style="margin-bottom: 5px" class="btn btn-primary" onclick="showModal(`'.base_url("comunity/modalProfile").'`, `'.$key->comunityID.'~'.$key->comunityName.'`, `modalprofile`);"><i class="icon-eye"></i> Show Profile</a>
							<a style="margin-bottom: 5px" class="btn btn-danger" onclick="confirms(`Delete`,`Data '.$key->comunityName.'?`,`'.base_url("comunity/delete").'`,`'.$key->comunityID.'`)"><i class="icon-trash"></i> Delete</a>'
							)
				);
			}
		}
		echo json_encode($res);
	}

/////////////////////////////////////////////////////////////////////////////////////////

		public function formField($id=null)
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
					"dashboards/js/pages/comunity-script.js",
				)
			),
		    'titleWeb'   => "Add Field",
		    'comunityID'	 => $id,
		    'breadcrumb' => explode(',', 'Comunity, Add Field'),
		    'actionForm' => base_url('comunity/addField'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/comunity/formField', $data);
	}

	public function getTypedata()
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

		public function getField()
	{
		$resp = array();
		$data = $this->Mod_crud->get_field_info('t_comunity_profile');
		if (!empty($data)) {
			foreach ($data as $key) {
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);

				$mk['id'] = $key->name;
				$mk['text'] = ucwords($pass2);
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

	public function addField()
	{
		$field 	= $this->input->post('Fieldname');
		$type 	= $this->input->post('Typedata');
		$length = $this->input->post('Lengthdata');
		$after 	= $this->input->post('After');
		$comunityID = $this->input->post('Comunityid');

	  	if ($type=='DATE') {
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		
		$add = $this->Mod_crud->query('ALTER TABLE `t_comunity_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');

		helper_log('add','Add New Coloumn Field ( '.$field.' ) In Table Comunity Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){
			$this->alert->set('bg-success', "Add Field success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field success !', 'aksi' => "window.location.href='".base_url('comunity/form/').$comunityID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function deleteField()
	{
		$query 		= $this->Mod_crud->query('ALTER TABLE `t_comunity_profile` DROP `'.$this->input->post('id').'`');
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

		public function modalProfile()
	{
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Profile '.$ID[1],
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_comunity_profile', null, null, null, array('comunityID = "'.$ID[0].'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/comunity/previewProfile', $data);
	}

		public function search()
	{
		$field 		= $this->input->post('Field');
		$keyword 	= $this->input->post('Keyword');
		$data = array();


		if ($field) {
			$data[] = 'cp.'.$field.' LIKE "%'.$keyword.'%" ';
		}

		//echo ' WHERE '.implode(' AND ',$data);

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
						"dashboards/js/pages/comunity-index-script.js",
				)
			),
			'titleWeb' => "comunity Profile",
			'breadcrumb' => explode(',', 'Comunity,Comunity List'),
			'dMaster'	=> $this->Mod_crud->getData('result','c.*,cp.*', 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID'),$data),
			'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'),
			'field'		=> $field,
			'keyword'	=> $keyword,
		);
		$this->render('dashboard', 'pages/comunity/index', $data);
	}


}

/* End of file comunity.php */
/* Location: ./application/controllers/comunity.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class University extends CommonDash {
//controller universitas
	public function __construct()
	{
		parent::__construct();
	}

	public function index()//universitas index
	{
		$data = array(//generate js
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
			'titleWeb' 	 => "University Profile",//title web
			'breadcrumb' => explode(',', 'University,University List'),//bread crumb (path halaman)
			//ambil data university profile
			'dMaster'	=> $this->Mod_crud->getData('result','cp.universityProfileID, cp.universityID, cp.universityName, cp.EmailAddress, cp.UniversityAddress, c.mou', 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID')),
			//ambil field record universitas profile
			'dField'	=> $this->Mod_crud->qry_field_info('cp.universityProfileID, cp.universityID, cp.universityName, cp.EmailAddress, cp.UniversityAddress, c.mou', 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID')),
		);
		$this->render('dashboard', 'pages/university/index', $data);//load university index
	}

	public function form($id=null)//form profile universitas
	{	
		$data = array(//generate js
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
		    'titleWeb'   => "Form University Profile",//title web
		    //ambil data universitas profile
		    'dMaster'	 => $this->Mod_crud->getData('row', '*', 't_university_profile', null, null, null, array('universityID = "'.$id.'"')),
		    //field record universitas profile
		    'dField'	 => $this->Mod_crud->get_field_info('t_university_profile'),
		    'breadcrumb' => explode(',', 'University, Form University Profile'),
		    'actionForm' => base_url('university/save_form'),//url form aksi
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/university/formProfile', $data);//load view universitas form profile
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_add(){//modal tambah universitas
		$data = array(
				'modalTitle' => 'Add university ',//modal title
				'formAction' => base_url('university/save'),//url aksi modal tambah
				'Req' => ''
			);
		$this->load->view('pages/university/form', $data);//load view modal form
	}

	public function save(){//aksi form modal tambah
		//cek duplikasi nama universitas
		$cek = $this->Mod_crud->checkData('universityName', 't_university', array('universityName = "'.$this->input->post('Universityname').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'University has been registered'));
		}else{
			//generate id universitas
			$id 		= $this->Mod_crud->autoNumber('universityID','t_university','MUV-',3);
			//generate id profile universitas
			$idprofile 	= $this->Mod_crud->autoNumber('universityProfileID','t_university_profile','ID-'.$id.'-',2);
			//simpan universitas
			$save = $this->Mod_crud->insertData('t_university', array(
						'universityID' 		=> $id,
						'universityName' 	=> $this->input->post('Universityname'),
						'mou'				=> $this->input->post('Mou'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			//simpan universitas profile
			$savepro = $this->Mod_crud->insertData('t_university_profile', array(
						'universityProfileID'	=> $idprofile,
						'universityID' 			=> $id,
						'universityName' 		=> $this->input->post('Universityname'),
           			)
           		);
			//log tambah universitas
			helper_log('add','Add New University ( '.$this->input->post('Universityname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){//jika save bernilai true
				//set alert sukses
				$this->alert->set('bg-success', "Insert Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert Success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function save_form(){//simpan university profile
			//simpan universitas
			$update = $this->Mod_crud->updateData('t_university', array(
						'universityName'=> $this->input->post('universityName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('universityID ' => $this->input->post('universityID'))
           		);
			//ambil field table profile university
			$up = $this->Mod_crud->get_field_info('t_university_profile');
			foreach ($up as $key) {//looping insert berdasarkan field table 
				$updateProfile = $this->Mod_crud->updateData('t_university_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('universityProfileID ' => $this->input->post('universityProfileID'))
           		);	
			}
			//log update university profile
			helper_log('edit','Update Profile University ( '.$this->input->post('universityName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){//jika update profile bernilai true
				//set alert sukses
				$this->alert->set('bg-success', "Update Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('university')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_edit(){//modal edit universitas
		$ID = explode('~',$this->input->post('id'));//ambil post id
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],//modal titile
				//ambil data university by id
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_university', null, null, null, array('universityID = "'.$ID[0].'"')),
				'formAction' => base_url('university/edit'),//url form modal aksi
				'Req' => ''
			);
		$this->load->view('pages/university/form', $data);//load modal university form
	}

	public function edit(){//aksi modal edit
		//cek duplikasi
		$cek = $this->Mod_crud->checkData('universityName', 't_university', array('universityName = "'.$this->input->post('Universityname').'"', 'universityID != "'.$this->input->post('Universityid').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'university has been registered'));
		}else{
			//simpan perubahan university
			$update = $this->Mod_crud->updateData('t_university', array(
						'universityName'=> $this->input->post('Universityname'),
						'mou'			=> $this->input->post('Mou'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('universityID ' => $this->input->post('Universityid'))
           		);
			//simpan perubahan universitas profile
			$update = $this->Mod_crud->updateData('t_university_profile', array(
						'universityName'	=> $this->input->post('Universityname'),
           			), array('universityID ' => $this->input->post('Universityid'))
           		);
			//log edit university
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
	public function delete(){//hapus university dan profil
		//log hapus university
		helper_log('delete','Delete University ( '.name_university($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
		//query hapus university
		$query 		= $this->Mod_crud->deleteData('t_university', array('universityID' => $this->input->post('id')));
		if ($query){
			//hapus profile university
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

		public function form_field($id=null)//form tambah field tabel profile
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
		    'titleWeb'   	=> "Add Field",//title web
		    'universityID'	=> $id,//get id
		    'breadcrumb' 	=> explode(',', 'university, Add Field'),
		    'actionForm' 	=> base_url('university/add_field'),
		    'buttonForm' 	=> 'Save'
		);

		$this->render('dashboard', 'pages/university/formField', $data);//load view university form field
	}

	public function get_typedata()//ambil data pada tabel tipedata
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

		public function get_mou()//ambil data universitas yang sudah mou
	{
		$resp = array();
		$data = $this->db->value_enum('t_university','mou');
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key;
				$mk['text'] = $key;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

		public function get_field()//ambil field table pada universitas profile
	{
		$resp = array();
		//get field table
		$data = $this->Mod_crud->get_field_info('t_university_profile');
		if (!empty($data)) {//jika field table tidak kosong
			foreach ($data as $key) {//looping data
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				if ($name == 'universityProfileID' OR $name == 'universityID' OR $name == 'universityName') {
					
				}else{
					$mk['id'] = $key->name;
					$mk['text'] = ucwords($pass2);
					array_push($resp, $mk);
				}
			}
		}
		echo json_encode($resp);
	}

	public function add_field()//aksi tambah field table
	{
		$field 	= $this->input->post('Fieldname');//get post fieldname
		$type 	= $this->input->post('Typedata');
		$length = $this->input->post('Lengthdata');
		$after 	= $this->input->post('After');
		$universityID = $this->input->post('Universityid');

	  	if ($type=='DATE') {//jika type == Date
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		//query tambah field table pada tabel universitas
		$add = $this->Mod_crud->query('ALTER TABLE `t_university_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');
		//log tambah field table
		helper_log('add','Add New Column Field ( '.$field.' ) In Table university Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){//jika add bernilai true
			//set alert sukses
			$this->alert->set('bg-success', "Add Field Success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field Success !', 'aksi' => "window.location.href='".base_url('university/form/').$universityID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function delete_field()//hapus field table univesity profile
	{
		//log hapus field table profil universitas
		helper_log('delete','Delete Column Field University Profile ( '.$this->input->post('id').' )',$this->session->userdata('userlog')['sess_usrID']);
		//query hapus field
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

	public function modal_profile()//modal review profile universitas
	{
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Profile '.$ID[1],
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_university_profile', null, null, null, array('universityID = "'.$ID[0].'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_university_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/university/previewProfile', $data);//load modal preview profile
	}

	public function search()//pencarian data
	{
		$mou 			= $this->input->post('Mou');//get post mou
		$keyword 		= $this->input->post('Keyword');//get post keyword dst..
		$field1 		= $this->input->post('Field1');
		$field2 		= $this->input->post('Field2');
		$field3 		= $this->input->post('Field3');
		$field4 		= $this->input->post('Field4');
		$field5 		= $this->input->post('Field5');

		if ($mou) {//jika mou memiliki nilai
			$where = array('c.mou = "'.$mou.'"');		
		}else{
			$where = null;
		}

		if ($field1) {//jika field 1 memiliki nilai
			$field['f1'] = $field1;//set field 1 ke array f1
			$select[] = 'cp.'.$field1;//set ke array select
			$like[] = 'cp.'.$field1.' LIKE "%'.$keyword.'%" ';//set ke array like
		}
		if ($field2) {
			$field['f2'] = $field2;
			$select[] = 'cp.'.$field2;
			$like[] = 'cp.'.$field2.' LIKE "%'.$keyword.'%" ';
		}
		if ($field3) {
			$field['f3'] = $field3;
			$select[] = 'cp.'.$field3;
			$like[] = 'cp.'.$field3.' LIKE "%'.$keyword.'%" ';
		}
		if ($field4) {
			$field['f4'] = $field4;
			$select[] = 'cp.'.$field4;
			$like[] = 'cp.'.$field4.' LIKE "%'.$keyword.'%" ';
		}
		if ($field5) {
			$field['f5'] = $field5;
			$select[] = 'cp.'.$field5;
			$like[] = 'cp.'.$field5.' LIKE "%'.$keyword.'%" ';
		}

		if (empty($select) OR empty($like)) {//array select dan like kosong
			//ambil field table university profile
			$fl = $this->Mod_crud->get_field_info('t_university_profile');
			$i = 0; 
			foreach ($fl as $key) {
				$i++;
				$name = $key->name;
				if ($name == 'universityProfileID' OR $name == 'universityID' OR $name == 'universityName') {
					//kosong
				}else{
				$lk[] = $name.' LIKE "%'.$keyword.'%" ';
				$sl[] = 'cp.'.$name;
				$field[] = $name;
				}
			}
			$slct 	= implode(', ', $sl);//query select
			$likes 	= 'cp.universityName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$lk);//query like
		}else{
			$slct 	= implode(', ', $select);
			$likes 	= 'cp.universityName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$like);
			$field = $field;
		}

		$data = array(//generate js
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
			'titleWeb'	=> "University Profile",//title web
			'breadcrumb'=> explode(',', 'university,university List'),
			//ambil data hasil pencarian
			'dMaster'	=> $this->Mod_crud->getData('result','cp.universityProfileID, cp.universityID, cp.universityName, '.$slct, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$likes),
			//ambil field record pencarian
			'dField'	=> $this->Mod_crud->qry_field_info('cp.universityProfileID, cp.universityID, cp.universityName, '.$slct, 't_university c',null,null,array('t_university_profile cp'=>'c.universityID = cp.universityID'),$where,null,null,$likes),	
			'mou'		=> $mou,//status mou
			'keyword'	=> $keyword,//keyword pencarian
			'field'		=> $field,
		);
		$this->render('dashboard', 'pages/university/result', $data);//load view university result
	}


}

/* End of file university.php */
/* Location: ./application/controllers/university.php */
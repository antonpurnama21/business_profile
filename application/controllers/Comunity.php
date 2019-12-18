<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Comunity extends CommonDash {
//controller comunity 
	public function __construct()
	{
		parent::__construct();
	}

	public function index()//comunity index
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
						"dashboards/js/pages/comunity-index-script.js",
				)
			),
			'titleWeb' => "Comunity Profile",//title aplikasi
			'breadcrumb' => explode(',', 'Comunity,Comunity List'),//bread crumb
			//ambil data profile comunity
			'dMaster'	=> $this->Mod_crud->getData('result','cp.comunityProfileID, cp.comunityID, cp.comunityName, cp.EmailAddress, cp.typeComunity', 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID')),
			//ambil field table
			'dField'	=> $this->Mod_crud->qry_field_info('cp.comunityProfileID, cp.comunityID, cp.comunityName, cp.EmailAddress, cp.typeComunity', 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID')),
		);
		$this->render('dashboard', 'pages/comunity/index', $data);//load view comunity index
	}

	public function form($id=null)//form comunity profile
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
					"dashboards/js/pages/comunity-script.js",
				)
			),
		    'titleWeb'   => "Form Comunity Profile",
		    //ambil data profile komunitas
		    'dMaster'	 => $this->Mod_crud->getData('row', '*', 't_comunity_profile', null, null, null, array('comunityID = "'.$id.'"')),
		    //field record tabel profile komunitas
		    'dField'	 => $this->Mod_crud->get_field_info('t_comunity_profile'),
		    'breadcrumb' => explode(',', 'Comunity, Form Comunity Profile'),
		    'actionForm' => base_url('comunity/save_form'),//url aksi form
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/comunity/formProfile', $data);//load view komunitas form profile
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_add(){//modal tambah
		$data = array(
				'modalTitle' => 'Add Comunity ',//modal title
				'formAction' => base_url('comunity/save'),//modal form url
				'Req' => ''
			);
		$this->load->view('pages/comunity/form', $data);//load modal form
	}

	public function save(){//aksi modal tambah
		//cek duplikasi nama komunitas
		$cek = $this->Mod_crud->checkData('comunityName', 't_comunity', array('comunityName = "'.$this->input->post('Comunityname').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'Comunity has been registered'));
		}else{
			//generate id komunitas
			$id 		= $this->Mod_crud->autoNumber('comunityID','t_comunity','CM-',3);
			//generate id profile komunitas
			$idprofile 	= $this->Mod_crud->autoNumber('comunityProfileID','t_comunity_profile','ID-'.$id.'-',2);
			//simpan komunitas
			$save = $this->Mod_crud->insertData('t_comunity', array(
						'comunityID' 		=> $id,
						'comunityName' 		=> $this->input->post('Comunityname'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			//simpan komunitas profile
			$savepro = $this->Mod_crud->insertData('t_comunity_profile', array(
						'comunityProfileID' => $idprofile,
						'comunityID' 		=> $id,
						'comunityName' 		=> $this->input->post('Comunityname'),
           			)
           		);
			//log tambah komunitas
			helper_log('add','Add New Comunity ( '.$this->input->post('Comunityname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){//jika save bernilai true
				//set alert sukses
				$this->alert->set('bg-success', "Insert Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert Success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function save_form(){//aksi form comunity profile
			//update komunitas
			$update = $this->Mod_crud->updateData('t_comunity', array(
						'comunityName'	=> $this->input->post('comunityName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('comunityID ' => $this->input->post('comunityID'))
           		);
			//ambil field pada table comunity profile
			$up = $this->Mod_crud->get_field_info('t_comunity_profile');
			foreach ($up as $key) {//looping insert
				$updateProfile = $this->Mod_crud->updateData('t_comunity_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('comunityProfileID ' => $this->input->post('comunityProfileID'))
           		);	
			}
			//log update comunity profile
			helper_log('edit','Update Profile Comunity ( '.$this->input->post('comunityName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){
				$this->alert->set('bg-success', "Update Success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('comunity')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_edit(){//modal edit komunitas
		$ID = explode('~',$this->input->post('id'));//ambil komunitas
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],//modal title
				//ambil data komunitas by id
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_comunity', null, null, null, array('comunityID = "'.$ID[0].'"')),
				'formAction' => base_url('comunity/edit'),//url modal edit
				'Req' => ''
			);
		$this->load->view('pages/comunity/form', $data);//load modal form komunitas
	}

	public function edit(){//aksi modal edit
		//cek duplikasi nama komunitas
		$cek = $this->Mod_crud->checkData('comunityName', 't_comunity', array('comunityName = "'.$this->input->post('Comunityname').'"', 'comunityID != "'.$this->input->post('Comunityid').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'comunity has been registered'));
		}else{
			//simpan perubahan
			$update = $this->Mod_crud->updateData('t_comunity', array(
						'comunityName'	=> $this->input->post('Comunityname'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('comunityID ' => $this->input->post('Comunityid'))
           		);
			//simpan perubahan pada profile komunitas
			$update = $this->Mod_crud->updateData('t_comunity_profile', array(
						'comunityName'	=> $this->input->post('Comunityname'),
           			), array('comunityID ' => $this->input->post('Comunityid'))
           		);
			//log edit komunitas
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
	public function delete(){//hapus komunitas 
		//log hapus
		helper_log('delete','Delete Comunity ( '.name_comunity($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
		//hapus komunitas
		$query 		= $this->Mod_crud->deleteData('t_comunity', array('comunityID' => $this->input->post('id')));
		if ($query){//jika query bernilai true
			//hapus komunitas profile
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

/////////////////////////////////////////////////////////////////////////////////////////

		public function form_field($id=null)//form tambah field record tabel komunitas profile
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
		    'comunityID' => $id,
		    'breadcrumb' => explode(',', 'Comunity, Add Field'),
		    'actionForm' => base_url('comunity/add_field'),
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/comunity/formField', $data);//load view komunitas form field
	}

	public function get_typedata()//ambil data pada tabel typedata
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

	public function get_type()//ambil data pada tabel typecomunity
	{
		$resp = array();
		$data = $this->Mod_crud->getData('result', 'typeComunity', 't_comunity_type');
		if (!empty($data)) {
			foreach ($data as $key) {
				$mk['id'] = $key->typeComunity;
				$mk['text'] = $key->typeComunity;
				array_push($resp, $mk);
			}
		}
		echo json_encode($resp);
	}

		public function get_field()//ambil field table comunity profile
	{
		$resp = array();
		$data = $this->Mod_crud->get_field_info('t_comunity_profile');
		if (!empty($data)) {
			foreach ($data as $key) {
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);
				//jika nam sama dengan ..
				if ($name == 'comunityProfileID' OR $name == 'comunityID' OR $name == 'comunityName') {
					//kosong
				}else{
					$mk['id'] = $key->name;
					$mk['text'] = ucwords($pass2);
					array_push($resp, $mk);
				}
			}
		}
		echo json_encode($resp);
	}

	public function add_field()//aksi form tambah field record tabel komunitas profile
	{
		$field 	= $this->input->post('Fieldname');//ambil data post fieldname
		$type 	= $this->input->post('Typedata');
		$length = $this->input->post('Lengthdata');
		$after 	= $this->input->post('After');
		$comunityID = $this->input->post('Comunityid');

	  	if ($type=='DATE') {//jika type bernilai 'DATE'
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		//query tambah field tabel
		$add = $this->Mod_crud->query('ALTER TABLE `t_comunity_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');
		//log tambah field record
		helper_log('add','Add New Column Field ( '.$field.' ) In Table Comunity Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){//jika add bernilai true
			//set alert sukses
			$this->alert->set('bg-success', "Add Field success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field success !', 'aksi' => "window.location.href='".base_url('comunity/form/').$comunityID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function delete_field()//hapus field record pada table comunity profile
	{
		//log hapus delete field
		helper_log('delete','Delete Column Field Comunity Profile ( '.$this->input->post('id').' )',$this->session->userdata('userlog')['sess_usrID']);
		//query delete field record table
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

		public function modal_profile()//modal review profile
	{
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Profile '.$ID[1],//modal title
				//ambil data table comunity profile
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_comunity_profile', null, null, null, array('comunityID = "'.$ID[0].'"')),
				//ambil field record pada table comunity profile
				'dField'	=> $this->Mod_crud->get_field_info('t_comunity_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/comunity/previewProfile', $data);//load modal preview profile
	}

		public function search()//pencarian data pada profile comunity
	{
		$type 			= $this->input->post('Type');//tipe komunitas
		$keyword 		= $this->input->post('Keyword');//kata kunci yang di cari
		$field1 		= $this->input->post('Field1');//field yang di cari
		$field2 		= $this->input->post('Field2');
		$field3 		= $this->input->post('Field3');
		$field4 		= $this->input->post('Field4');
		$field5 		= $this->input->post('Field5');

		if ($type) {//jika post tipe memiliki nilai
			$where = array('cp.typeComunity = "'.$type.'"');		
		}else{
			$where = null;
		}

		if ($field1) {//jika field 1 memilki nilai
			$field['f1'] = $field1;
			$select[] = 'cp.'.$field1;
			$like[] = 'cp.'.$field1.' LIKE "%'.$keyword.'%" ';
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

		if (empty($select) OR empty($like)) {//jika array select atau array like kosong
			//ambil field record profile komunitas
			$fl = $this->Mod_crud->get_field_info('t_comunity_profile');
			$i = 0; 
			foreach ($fl as $key) {//looping fl
				$i++;
				$name = $key->name;
				//jika name bernilai sama dengan ..
				if ($name == 'comunityProfileID' OR $name == 'comunityID' OR $name == 'comunityName') {
					//kosong
				}else{
				$lk[] = $name.' LIKE "%'.$keyword.'%" ';
				$sl[] = 'cp.'.$name;
				$field[] = $name;
				}
			}
			$slct 	= implode(', ', $sl);//query select
			//query like
			$likes 	= 'cp.comunityName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$lk);
		}else{
			$slct 	= implode(', ', $select);
			$likes 	= 'cp.comunityName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$like);
			$field = $field;//field table
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
						"dashboards/js/plugins/pickers/pickadate/picker.js",
						"dashboards/js/plugins/pickers/pickadate/picker.date.js",
						"dashboards/js/plugins/forms/validation/validate.min.js",
						"dashboards/js/pages/comunity-index-script.js",
				)
			),
			'titleWeb' => "Comunity Profile",
			'breadcrumb' => explode(',', 'Comunity,Comunity List'),
			//ambil data profile berdasarkan pencarian
			'dMaster'	=> $this->Mod_crud->getData('result','cp.comunityProfileID, cp.comunityID, cp.comunityName, '.$slct, 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID'),$where,null,null,$likes),
			//ambil field record table
			'dField'	=> $this->Mod_crud->qry_field_info('cp.comunityProfileID, cp.comunityID, cp.comunityName, '.$slct, 't_comunity c',null,null,array('t_comunity_profile cp'=>'c.comunityID = cp.comunityID'),$where,null,null,$likes),	
			'type'		=> $type,
			'keyword'	=> $keyword,
			'field'		=> $field,
		);
		$this->render('dashboard', 'pages/comunity/result', $data);//load view comunity result
	}


}

/* End of file comunity.php */
/* Location: ./application/controllers/comunity.php */
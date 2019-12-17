<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Company extends CommonDash {
//controller untuk mengelola company table
	public function __construct()
	{
		parent::__construct();
	}

	//company index
	public function index()
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
						"dashboards/js/pages/company-index-script.js",
				)
			),
			'titleWeb' => "Company Profile",//web title
			'breadcrumb' => explode(',', 'Company,Company List'),
			//ambil data company profile
			'dMaster'	=> $this->Mod_crud->getData('result','cp.companyProfileID,cp.companyID,cp.companyName,cp.sectorCompany,cp.EmailAddress', 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID')),
			//ambil table field info
			'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID,cp.companyID,cp.companyName,cp.sectorCompany,cp.EmailAddress', 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID')),
			
		);
		$this->render('dashboard', 'pages/company/index', $data);//load view company index
	}

	//form company profile
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
		    'actionForm' => base_url('company/save_form'),//url aksi
		    'buttonForm' => 'Save'
		);

		$this->render('dashboard', 'pages/company/formProfile', $data);//load view form profile
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_Add(){//modal tambah company
		$data = array(
				'modalTitle' => 'Add Company ',//modal title
				'formAction' => base_url('company/save'),//url aksi modal
				'Req' => ''
			);
		$this->load->view('pages/company/form', $data);//load modal form add
	}

	public function save(){//aksi modal tambah
		//cek duplikasi nama company
		$cek = $this->Mod_crud->checkData('companyName', 't_company', array('companyName = "'.$this->input->post('Companyname').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'Company has been registered'));
		}else{
			//generate id
			$id 		= $this->Mod_crud->autoNumber('companyID','t_company','CP-',3);
			//generete profile id
			$idprofile 	= $this->Mod_crud->autoNumber('companyProfileID','t_company_profile','ID-'.$id.'-',2);
			//simpan data company
			$save = $this->Mod_crud->insertData('t_company', array(
						'companyID' 		=> $id,
						'companyName' 		=> $this->input->post('Companyname'),
						'createdBY'			=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 		=> date('Y-m-d H:i:s')
           			)
           		);
			//simpan profile
			$savepro = $this->Mod_crud->insertData('t_company_profile', array(
						'companyProfileID' 	=> $idprofile,
						'companyID' 		=> $id,
						'companyName' 		=> $this->input->post('Companyname'),
           			)
           		);

			//log simpan company
			helper_log('add','Add New Company ( '.$this->input->post('Companyname').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){//jika bernilai true
				//set alert sukses
				$this->alert->set('bg-success', "Insert success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}

	public function save_form(){//aksi form profile company
			//simpan perubahan company
			$update = $this->Mod_crud->updateData('t_company', array(
						'companyName'	=> $this->input->post('companyName'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('companyID ' => $this->input->post('companyID'))
           		);
			//ambil info field
			$up = $this->Mod_crud->get_field_info('t_company_profile');
			foreach ($up as $key) {//looping simpan profile
				$updateProfile = $this->Mod_crud->updateData('t_company_profile', array(
						$key->name	=> $this->input->post($key->name),
           			), array('companyProfileID ' => $this->input->post('companyProfileID'))
           		);	
			}
			//log simpan profile company
			helper_log('edit','Update Profile Company ( '.$this->input->post('companyName').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($updateProfile){//jika bernilai true
				$this->alert->set('bg-success', "Update success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !', 'aksi' => "window.location.href='".base_url('company')."';"));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}

	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modal_edit(){//modal edit
		$ID = explode('~',$this->input->post('id'));//get id
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],//modal title
				//ambil data company by id
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_company', null, null, null, array('companyID = "'.$ID[0].'"')),
				'formAction' => base_url('company/edit'),//url aksi modal
				'Req' => ''
			);
		$this->load->view('pages/company/form', $data);//load view modal edit
	}

	public function edit(){//aksi modal edit
		//cek dupliksai nama company
		$cek = $this->Mod_crud->checkData('companyName', 't_company', array('companyName = "'.$this->input->post('Companyname').'"', 'companyID != "'.$this->input->post('Companyid').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'Company has been registered'));
		}else{
			//simpan perubahan
			$update = $this->Mod_crud->updateData('t_company', array(
						'companyName'	=> $this->input->post('Companyname'),
						'createdBY'		=> $this->session->userdata('userlog')['sess_usrID'],
						'createdTime' 	=> date('Y-m-d H:i:s')
           			), array('companyID ' => $this->input->post('Companyid'))
           		);
			//simpan perubahan pada profile
			$update = $this->Mod_crud->updateData('t_company_profile', array(
						'companyName'	=> $this->input->post('Companyname'),
           			), array('companyID ' => $this->input->post('Companyid'))
           		);
			//log edit perubahan company
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
	public function delete(){//hapus company dan company profile
		//log hapus
		helper_log('delete','Delete Company ( '.name_company($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
		//hapus company
		$query 		= $this->Mod_crud->deleteData('t_company', array('companyID' => $this->input->post('id')));
		if ($query){
			//hapus company profile
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

		public function form_field($id=null)//form tambah field tabel company
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

		$this->render('dashboard', 'pages/company/formField', $data);//load view form field
	}

	public function get_typedata()//ambil data tipe data
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

	public function get_sector()//ambil data sector
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

		public function get_field()//ambil field info company
	{
		$resp = array();
		$data = $this->Mod_crud->get_field_info('t_company_profile');
		if (!empty($data)) {
			foreach ($data as $key) {
				$name = $key->name;
				$pass1 = preg_replace("/([a-z])([A-Z])/","\\1 \\2",$name);
				$pass2 = preg_replace("/([A-Z])([A-Z][a-z])/","\\1 \\2",$pass1);//memisahkan dengan spasi
				if ($name == 'companyProfileID' OR $name == 'companyID' OR $name == 'companyName') {
					
				}else{
				$mk['id'] 	= $key->name;
				$mk['text'] = ucwords($pass2);
				array_push($resp, $mk);
				}
			}
		}
		echo json_encode($resp);
	}

	public function add_field()//aksi tambah field table
	{
		$field 	= $this->input->post('Fieldname');
		$type 	= $this->input->post('Typedata');
		$length = $this->input->post('Lengthdata');
		$after 	= $this->input->post('After');
		$companyID = $this->input->post('Companyid');

	  	if ($type=='DATE') {//jika bertipe tanggal
			$Tipe = $type;
		}else{
			$Tipe = $type.'('.$length.')';
		}
		//tambah field ke tabel
		$add = $this->Mod_crud->query('ALTER TABLE `t_company_profile` ADD `'.$field.'` '.$Tipe.' NULL  AFTER `'.$after.'`');
		//log tambah field baru
		helper_log('add','Add New Column Field ( '.$field.' ) In Table Company Profile',$this->session->userdata('userlog')['sess_usrID']);

		if ($add){//jika bernilai true
			$this->alert->set('bg-success', "Add Field success ! ");
    		echo json_encode(array('code' => 200, 'message' => 'Add Field success !', 'aksi' => "window.location.href='".base_url('company/form/').$companyID."';"));
    	}else{
    		echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
     	}
	}

		public function delete_field()//hapus field pada table
	{
		//log hapus field
		helper_log('delete','Delete Column Field Company Profile ( '.$this->input->post('id').' )',$this->session->userdata('userlog')['sess_usrID']);
		//hapus field
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

	public function modal_profile()//modal review field
	{
		$ID = explode('~',$this->input->post('id'));//get id
		$data = array(
				'modalTitle' => 'Profile '.$ID[1],//modal title
				//ambil data company profile
				'dMaster' 	=> $this->Mod_crud->getData('row', '*', 't_company_profile', null, null, null, array('companyID = "'.$ID[0].'"')),
				'dField'	=> $this->Mod_crud->get_field_info('t_company_profile'), 
				'Req' => ''
			);
		$this->load->view('pages/company/previewProfile', $data);
	}


	public function search()//aksi pencarian
	{
		$sector 		= $this->input->post('Sector');
		$keyword 		= $this->input->post('Keyword');
		$field1 		= $this->input->post('Field1');
		$field2 		= $this->input->post('Field2');
		$field3 		= $this->input->post('Field3');
		$field4 		= $this->input->post('Field4');
		$field5 		= $this->input->post('Field5');

		if ($sector) {//jika sector di input
			$where = array('cp.sectorCompany = "'.$sector.'"');		
		}else{
			$where = null;
		}

		if ($field1) {//jika field 1  di inputkan
			$field['f1'] = $field1;
			$select[] = 'cp.'.$field1;
			$like[] = 'cp.'.$field1.' LIKE "%'.$keyword.'%" ';
		}
		if ($field2) {//jika field 2 di inputkan
			$field['f2'] = $field2;
			$select[] = 'cp.'.$field2;
			$like[] = 'cp.'.$field2.' LIKE "%'.$keyword.'%" ';
		}
		if ($field3) {//jika field 3 di inputkan
			$field['f3'] = $field3;
			$select[] = 'cp.'.$field3;
			$like[] = 'cp.'.$field3.' LIKE "%'.$keyword.'%" ';
		}
		if ($field4) {//jika field 4 di inputkan
			$field['f4'] = $field4;
			$select[] = 'cp.'.$field4;
			$like[] = 'cp.'.$field4.' LIKE "%'.$keyword.'%" ';
		}
		if ($field5) {//jika field 5 di inputkan
			$field['f5'] = $field5;
			$select[] = 'cp.'.$field5;
			$like[] = 'cp.'.$field5.' LIKE "%'.$keyword.'%" ';
		}

		if (empty($select) OR empty($like)) {//jika nilai select dan like kosong
			// ambil field table company profile
			$fl = $this->Mod_crud->get_field_info('t_company_profile');
			$i = 0; 
			foreach ($fl as $key) {//looping field
				$i++;
				$name = $key->name;
				if ($name == 'companyProfileID' OR $name == 'companyID' OR $name == 'companyName') {
					
				}else{
				$lk[] = $name.' LIKE "%'.$keyword.'%" ';
				$sl[] = 'cp.'.$name;
				$field[] = $name;
				}
			}
			//create select
			$slct 	= implode(', ', $sl);
			//create query
			$likes 	= 'cp.companyName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$lk);
		}else{
			//create select
			$slct 	= implode(', ', $select);
			//create query like
			$likes 	= 'cp.companyName LIKE "%'.$keyword.'%" OR '.implode(' OR ',$like);
			$field = $field;
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
						"dashboards/js/pages/company-index-script.js",
				)
			),
			'titleWeb'	=> "Company Profile",
			'breadcrumb'=> explode(',', 'Company,Company List'),
			//ambil data profile
			'dMaster'	=> $this->Mod_crud->getData('result','cp.companyProfileID, cp.companyID, cp.companyName, '.$slct, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$likes),
			//tampilkan field table company profile
			'dField'	=> $this->Mod_crud->qry_field_info('cp.companyProfileID, cp.companyID, cp.companyName, '.$slct, 't_company c',null,null,array('t_company_profile cp'=>'c.companyID = cp.companyID'),$where,null,null,$likes),	
			'sector'	=> $sector,//sector
			'keyword'	=> $keyword,//keyword
			'field'		=> $field,//field
		);
		$this->render('dashboard', 'pages/company/result', $data);//load view company result
	}


}

/* End of file company.php */
/* Location: ./application/controllers/company.php */
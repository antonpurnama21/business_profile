<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Type extends CommonDash {
//controller untuk table type data
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_crud');
	}
	//type comunity index
	public function index()
	{
		$data = array( //generate js
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
						"dashboards/js/pages/type-index-script.js",
				)
			),
			'titleWeb' => "Comunity Type",//title web
			'breadcrumb' => explode(',', 'Comunity Profile , Type'),//bread crumb
			//ambil data type comunity
			'dMaster' => $this->Mod_crud->getData('result','*', 't_comunity_type'),
		);
		$this->render('dashboard', 'pages/type/index', $data);//load view tipe comunity index
	}

	public function modalAdd(){//modal tambah tipe komunitas
		$data = array(
				'modalTitle' => 'Add Type ',//modal title
				'formAction' => base_url('type/save'),//url aksi
				'Req' => ''
			);
		$this->load->view('pages/type/form', $data);//load view modal form
	}

	public function save(){//simpan data tipe komunitas
		//cek duplikasi tipe komunitas
		$cek = $this->Mod_crud->checkData('typeComunity', 't_comunity_type', array('typeComunity = "'.$this->input->post('Name').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Type has been registered'));
		}else{
			//simpan tipe komunitas
			$save = $this->Mod_crud->insertData('t_comunity_type', array(
						'typeComunity'	=> $this->input->post('Name')
           			)
           		);
			//log simpan
			helper_log('add','Add New Type Comunity ( '.$this->input->post('Name').' )',$this->session->userdata('userlog')['sess_usrID']);
			if ($save){
				$this->alert->set('bg-success', "Insert success ! ");
       			echo json_encode(array('code' => 200, 'message' => 'Insert success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function modalEdit(){//modal edit tipe komunitas
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],
				//ambil data tipe by id
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_comunity_type', null, null, null, array('typeID = "'.$ID[0].'"')),
				'formAction' => base_url('type/edit'),
				'Req' => ''
			);
		$this->load->view('pages/type/form', $data); //load view modal
	}

	public function edit(){//modal edit aksi
		//cek duplikasi nama tipe komunitas
		$cek = $this->Mod_crud->checkData('typeComunity', 't_comunity_type', array('typeComunity = "'.$this->input->post('Name').'"', 'typeID != "'.$this->input->post('ID').'"'));
		if ($cek){//jika ada
			echo json_encode(array('code' => 256, 'message' => 'Type has been registered'));
		}else{
			//simpan perubahan
			$update = $this->Mod_crud->updateData('t_comunity_type', array(
						'typecomunity'	=> $this->input->post('Name')
           			), array('typeID ' => $this->input->post('ID'))
           		);
			//log edit
			helper_log('edit','Edit Type ( '.$this->input->post('Name').' )',$this->session->userdata('userlog')['sess_usrID']);

			if ($update){
				$this->alert->set('bg-success', "Update success !");
       			echo json_encode(array('code' => 200, 'message' => 'Update success !'));
       		}else{
       			echo json_encode(array('code' => 500, 'message' => 'An error occurred while saving data !'));
       		}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function delete(){//hapus tipe komunitas
		//log hapus
		helper_log('delete','Delete Type Comunity ( '.name_typecomunity($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
		//hapus tipe komunitas
		$query 		= $this->Mod_crud->deleteData('t_comunity_type', array('typeID' => $this->input->post('id')));
		if ($query){
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

}

/* End of file type.php */
/* Location: ./application/controllers/type.php */
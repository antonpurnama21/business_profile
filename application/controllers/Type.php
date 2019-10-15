<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Type extends CommonDash {

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
						"dashboards/js/pages/type-index-script.js",
				)
			),
			'titleWeb' => "Comunity Type",
			'breadcrumb' => explode(',', 'Comunity Profile , Type'),
			'dMaster' => $this->Mod_crud->getData('result','*', 't_comunity_type'),
		);
		$this->render('dashboard', 'pages/type/index', $data);
	}

	public function modalAdd(){
		$data = array(
				'modalTitle' => 'Add Type ',
				'formAction' => base_url('type/save'),
				'Req' => ''
			);
		$this->load->view('pages/type/form', $data);
	}

	public function save(){
		$cek = $this->Mod_crud->checkData('typeComunity', 't_comunity_type', array('typeComunity = "'.$this->input->post('Name').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Type has been registered'));
		}else{

			$save = $this->Mod_crud->insertData('t_comunity_type', array(
						'typeComunity'	=> $this->input->post('Name')
           			)
           		);
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
	public function modalEdit(){
		$ID = explode('~',$this->input->post('id'));
		$data = array(
				'modalTitle' => 'Edit '.$ID[1],
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_comunity_type', null, null, null, array('typeID = "'.$ID[0].'"')),
				'formAction' => base_url('type/edit'),
				'Req' => ''
			);
		$this->load->view('pages/type/form', $data);
	}

	public function edit(){
		$cek = $this->Mod_crud->checkData('typeComunity', 't_comunity_type', array('typeComunity = "'.$this->input->post('Name').'"', 'typeID != "'.$this->input->post('ID').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Type has been registered'));
		}else{

			$update = $this->Mod_crud->updateData('t_comunity_type', array(
						'typecomunity'	=> $this->input->post('Name')
           			), array('typeID ' => $this->input->post('ID'))
           		);
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
	public function delete(){
		helper_log('delete','Delete Type Comunity ( '.name_typecomunity($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
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
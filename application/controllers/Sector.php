<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH."controllers/CommonDash.php");

class Sector extends CommonDash {

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
						"dashboards/js/pages/sector-index-script.js",
				)
			),
			'titleWeb' => "Company Sector",
			'breadcrumb' => explode(',', 'Company Profile , Sector'),
			'dMaster' => $this->Mod_crud->getData('result','*', 't_company_sector'),
		);
		$this->render('dashboard', 'pages/sector/index', $data);
	}

	public function modalAdd(){
		$data = array(
				'modalTitle' => 'Add Sector ',
				'formAction' => base_url('sector/save'),
				'Req' => ''
			);
		$this->load->view('pages/sector/form', $data);
	}

	public function save(){
		$cek = $this->Mod_crud->checkData('sectorCompany', 't_company_sector', array('sectorCompany = "'.$this->input->post('Name').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Sector has been registered'));
		}else{

			$save = $this->Mod_crud->insertData('t_company_sector', array(
						'sectorCompany'	=> $this->input->post('Name')
           			)
           		);
			helper_log('add','Add New Sector ( '.$this->input->post('Name').' )',$this->session->userdata('userlog')['sess_usrID']);
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
				'dMaster' => $this->Mod_crud->getData('row', '*', 't_company_sector', null, null, null, array('sectorID = "'.$ID[0].'"')),
				'formAction' => base_url('sector/edit'),
				'Req' => ''
			);
		$this->load->view('pages/sector/form', $data);
	}

	public function edit(){
		$cek = $this->Mod_crud->checkData('sectorCompany', 't_company_sector', array('sectorCompany = "'.$this->input->post('Name').'"', 'sectorID != "'.$this->input->post('ID').'"'));
		if ($cek){
			echo json_encode(array('code' => 256, 'message' => 'Sector has been registered'));
		}else{

			$update = $this->Mod_crud->updateData('t_company_sector', array(
						'sectorCompany'	=> $this->input->post('Name')
           			), array('sectorID ' => $this->input->post('ID'))
           		);
			helper_log('edit','Edit Sector ( '.$this->input->post('Name').' )',$this->session->userdata('userlog')['sess_usrID']);

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
		helper_log('delete','Delete Sector ( '.name_sector($this->input->post('id')).' )',$this->session->userdata('userlog')['sess_usrID']);
		$query 		= $this->Mod_crud->deleteData('t_company_sector', array('sectorID' => $this->input->post('id')));
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

/* End of file sector.php */
/* Location: ./application/controllers/sector.php */
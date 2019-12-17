<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
//contorller login aplikasi
	function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_crud');
	}

	public function index()
	{
		
	}
	
	public function login()//login index
	{				
		if ($this->session->userdata('userlog')['is_login'] == TRUE) ://jika session is_login bernilai true
			redirect(base_url('dashboard')) ;//redirect ke dashboard
		endif;
		$data = array(
		    'titleWeb' => 'Login Business Profile',//title aplikasi
		);
		$this->template->load('login', null, $data);//load view login
	}

	public function do_login()//aksi login
	{
		//cek email pengguna
		$cekUser = $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$this->input->post('email').'"'));
		if ($cekUser == false){//jika tak ada
			echo json_encode(array('code' => 366, 'message' => 'Email not found'));
		}else{
			//cek password user
			$cekPass = $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$this->input->post('email').'"', 'passworD = "'.MD5($this->input->post('password')).'"'));
			if ($cekPass == false){//jika tidak sama
				echo json_encode(array('code' => 367, 'message' => 'Wrong password'));
			}else{
				//jika role id 11 dan 22 (admin hc dan admin department)
				if ($cekPass->roleID == 11 OR $cekPass->roleID == 22) {
					//ambil data admin department
					$user 	= $this->Mod_crud->getData('row', '*', 't_admin', null, null, null, array('emaiL = "'.$cekPass->emaiL.'"'));
					$login['sess_usrID']  	= $user->adminID;
					$login['sess_deptID'] 	= $user->deptID;
					$login['sess_name']		= $user->fullName;
					$login['sess_email'] 	= $cekPass->emaiL;
					$login['sess_role'] 	= $cekPass->roleID;
					$login['is_login'] 		= TRUE;
					$login['sess_pass'] 	= md5($this->input->post('password'));
					$login['sess_avatar'] 	= base_url('assets/file/pic_admin/default.png');

					$lokasi = base_url('dashboard');//lokasi home
					$this->session->set_userdata('userlog',$login);//set session login
					//set alert sukses
					$this->alert->set('bg-success', 'Welcome '.$login['sess_name'].', you login as '.what_role($login['sess_role']).' !');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
				}else {//jika role id lain tidak di perkenankan
					$lokasi = base_url('auth/login');//kembali ke login
					//set alert ditolak
					$this->alert->set('bg-warning', 'Access Denied!');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
				}
			
			}
		}
	}

	public function logout(){//keluar aplikasi
		//destroy session
		$this->session->unset_userdata('userlog');
		redirect(base_url('dashboard'));
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Mod_crud');
	}

	public function index()
	{
		
	}

	public function login()
	{				
		if ($this->session->userdata('userlog')['is_login'] == TRUE) :
			redirect(base_url('dashboard')) ;
		endif;
		$data = array(
		    'titleWeb' => 'Login Page',
		);
		$this->template->load('login', null, $data);
	}

	public function do_login()
	{
		$cekUser = $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$this->input->post('email').'"'));
		if ($cekUser == false){
			echo json_encode(array('code' => 366, 'message' => 'Email not found'));
		}else{
			$cekPass = $this->Mod_crud->getData('row', '*', 't_login', null, null, null, array('emaiL = "'.$this->input->post('email').'"', 'passworD = "'.MD5($this->input->post('password')).'"'));
			if ($cekPass == false){
				echo json_encode(array('code' => 367, 'message' => 'Wrong password'));
			}else{
				// 	$avatar = base_url('assets/dashboards/images/avatars/default_avatar.png');
				// if ($this->input->post("chkremember")){
    //                    $this->input->set_cookie('u_mail', $this->input->post('email'), 86500); /* Create cookie for store emailid */
    //                    $this->input->set_cookie('u_pass', $this->input->post('password'), 86500); /* Create cookie for password */
    //                }
				if ($cekPass->roleID == 11 OR $cekPass->roleID == 22) {
					$user 	= $this->Mod_crud->getData('row', '*', 't_admin', null, null, null, array('emaiL = "'.$cekPass->emaiL.'"'));
					$login['sess_usrID']  = $user->adminID;
					$login['sess_deptID'] = $user->deptID;
					$login['sess_name']		= $user->fullName;
					$login['sess_email'] 	= $cekPass->emaiL;
					$login['sess_role'] 	= $cekPass->roleID;
					$login['is_login'] 		= TRUE;
					$login['sess_pass'] 	= md5($this->input->post('password'));
					$login['sess_avatar'] 	= base_url('assets/file/pic_admin/default.png');

					$lokasi = base_url('dashboard');
					$this->session->set_userdata('userlog',$login);
					$this->alert->set('bg-success', 'Welcome '.$login['sess_name'].', you login as '.what_role($login['sess_role']).' !');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
				}else {
					$lokasi = base_url('auth/login');
					$this->alert->set('bg-warning', 'Access Denied!');
					echo json_encode(array('code' => 200, 'aksi' => "window.location.href = '".$lokasi."'"));
				}
			
			}
		}
	}

	public function logout(){
		$this->session->unset_userdata('userlog');
		redirect(base_url('dashboard'));
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */
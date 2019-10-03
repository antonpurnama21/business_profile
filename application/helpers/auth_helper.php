<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// THE HELPER

if (!function_exists('auth_check'))
{
	function auth_check()
	{
		$CI =& get_instance();
		$log = $CI->session->userdata('userlog');
		if ($log['is_login'] == FALSE)
		{
			redirect(base_url('auth/login'),'refresh');
		}else{
			return true;
		}
	}
}

if (!function_exists('auth_level'))
{
	function auth_level($type = null, $level = null, $module = null)
	{
		$CI =& get_instance();
		
		if(is_null($level) || is_null($type)){
			return false;
		}
		
		if(is_null($module)){
			$module = 'home';
		}
		
		$CI->load->model('user_model');
		$check = $CI->user_model->check_user_level($type, strtolower($module), $level);
		
		return $check;
	}
}

if (!function_exists('level_check'))
{
	function level_check($level = null, $module = null)
	{
		$CI =& get_instance();
		$module = $CI->module;
		if(isset($_SESSION['is_login']) && $_SESSION['is_login']){
			
			if(auth_level($_SESSION['type'], $level, $module)){
				return true;
			}
			
			return false;
		}
		
		return false;
	}
}

if (!function_exists('auth_redirect'))
{
	function auth_redirect()
	{
		$CI =& get_instance();
		$log = $CI->session->userdata('userlog');
		switch($log['LevelUser']){
			case '1':
				redirect(base_url('baak/dashboard'),'refresh');
				break;
			case '2':
				redirect(base_url('jurusan/dashboard'),'refresh');
				break;
			case '3':
				redirect(base_url('dosen/dashboard'),'refresh');
				break;
			case '4':
				redirect(base_url('mahasiswa/dashboard'),'refresh');
				break;
			default:
				redirect(base_url(),'refresh');
				break;
		}
	}
}

if (!function_exists('what_level'))
{
	function what_level($level)
	{
		switch($level){
			case '2':
				return 'Administrator BPSK';
				break;
			case '3':
				return 'Sekretariat BPSK';
				break;
			case '4':
				return 'Ketua BPSK';
				break;
			case '5':
				return 'Anggota BPSK';
				break;
			case '6':
				return 'User';
				break;
			default:
				return 'Super Admin';
				break;
		}
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('what_role'))
{
	function what_role($role)
	{

		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'roleName', 't_role', null, null, null, array("roleID = '".$role."'"));
		if ($get) :
			return $get->roleName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('helper_log'))
{
	function helper_log($tipe = null, $str = null, $usrID = null)
	{
		$CI =& get_instance();
		$CI->load->library('user_agent');
		$CI->db->trans_start();
		if ($CI->agent->is_browser())
		{
		    $agent = $CI->agent->browser().' '.$CI->agent->version();
		}
		elseif ($CI->agent->is_robot())
		{
		    $agent = $CI->agent->robot();
		}
		elseif ($CI->agent->is_mobile())
		{
		    $agent = $CI->agent->mobile();
		}
		else
		{
		    $agent = 'Unidentified User Agent';
		}

		$typelog = $CI->Mod_crud->getData('result','*','t_log_type');

		if ($typelog) {
        	$i= 1;
    	    foreach ($typelog as $key) {
    	    	if (strtolower($tipe) == $key->typeName) {
    	    		$logtype = $key->logTypeID;
    	    	}
        	}
    	}
		$cLog = $CI->Mod_crud->insertData('t_log_activity', array(
				'logUsrID' 		=> $usrID,
				'logTime' 		=> date('Y-m-d H:i:s'),
				'logTypeID' 	=> $logtype,
				'logDesc'		=> $str,
				'logBrowser' 	=> $agent,
				'logIP'			=> $CI->input->ip_address(),
				'logPlatform' 	=> $CI->agent->platform()
			)
		);

		if($cLog) {
			$CI->db->trans_complete();
		}
	}
}

if (!function_exists('update_workscope'))
{
	function update_workscope()
	{
		$CI =& get_instance();
		$CI->db->trans_start();

		$get = $CI->Mod_crud->qry('result','SELECT * FROM `t_project_scope` as ps RIGHT JOIN t_workscope as ws ON ps.projectScopeID = ws.projectScopeID');

		if ($get) {
    	    foreach ($get as $key) {
    	    	$workscopeID 	= $key->workscopeID;
				$startDate 		= $key->startDate;
				$endDate    	= $key->endDate;
				$dateNow 		= date('Y-m-d');

				if ($key->statusWorkscope=='pending') {
					if ($dateNow >= $startDate) {
						$update = $CI->Mod_crud->updateData('t_workscope', array(
		           				'statusWorkscope'	=> 'on-progress',
		           			), array('workscopeID' 	=> $workscopeID)
		           		);
		           		if($update) {
						$CI->db->trans_complete();
						}
					}
				}elseif ($key->statusWorkscope=='on-progress') {
					if ($dateNow > $endDate) {
						$update = $CI->Mod_crud->updateData('t_workscope', array(
		           				'statusWorkscope'	=> 'done',
		           			), array('workscopeID' 	=> $workscopeID)
		           		);
		           		if($update) {
						$CI->db->trans_complete();
						}
					}
				}
        	}
    	}
	}
}

if (!function_exists('update_project'))
{
	function update_project()
	{
		$CI =& get_instance();
		$CI->db->trans_start();

		$get = $CI->Mod_crud->qry('result','SELECT * FROM `t_project_scope`');

		if ($get) {
    	    foreach ($get as $key) {
    	    	$projectScopeID = $key->projectScopeID;
				$endDate    	= $key->endDate;
				$dateNow 		= date('Y-m-d');

				if ($dateNow > $endDate) {
					$update = $CI->Mod_crud->updateData('t_project_scope', array(
		           			'isTaken'	=> '0'
		           		), array('projectScopeID' => $projectScopeID)
		           	);
		           	if($update) {
					$CI->db->trans_complete();
					}
				}
        	}
    	}
	}
}

if (!function_exists('update_task'))
{
	function update_task()
	{
		$CI =& get_instance();
		$CI->db->trans_start();

		$get = $CI->Mod_crud->qry('result','SELECT * FROM `t_task` ');

		if ($get) {
    	    foreach ($get as $key) {
    	    	$taskID 		= $key->taskID;
				$startDate 		= $key->startDate;
				$endDate    	= $key->endDate;
				$dateNow		= date('Y-m-d');

				if ($key->statusTask=='pending') {
					if ($dateNow >= $startDate) {
						$update = $CI->Mod_crud->updateData('t_task', array(
		           				'statusTask'	=> 'on-progress',
		           			), array('taskID' 	=> $taskID)
		           		);

		           		if($update) {
						$CI->db->trans_complete();
						}
					}
				}elseif ($key->statusTask=='on-progress') {
					if ($dateNow > $endDate) {
						$update = $CI->Mod_crud->updateData('t_task', array(
		           				'statusTask'	=> 'done',
		           			), array('taskID' 	=> $taskID)
		           		);
		           		if($update) {
						$CI->db->trans_complete();
						}
					}
				}
        	}
    	}
	}
}
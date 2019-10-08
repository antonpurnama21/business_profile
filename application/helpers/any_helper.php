<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// THE HELPER


/*
* @Function_name : Generate_Css
* @Return_type : String
* @Author : Samirah Rahayu /085723211904
*/
if (!function_exists('generate_css'))
{
	function generate_css($_CSS = NULL)
	{
		if(!isset($_CSS) or $_CSS == NULL) {
			return NULL;
		}
		if(is_array($_CSS)) {
			$str = "";
			foreach ($_CSS as $key => $value) {
				$str .= '<link href="'.base_url('assets').'/'.$value.'" type="text/css" rel="stylesheet">';
			}
			return $str;
		} else if(is_string($_CSS)) {
			return '<link href="'.base_url('assets').'/'.$_CSS.'" type="text/css" rel="stylesheet">';
		}
	}
}

/*
* @Function_name : Generate_Js
* @Return_type : String
* @Author : Samirah Rahayu /085723211904
*/	
if (!function_exists('generate_js'))
{
	function generate_js($JS =  NULL)
	{
		if(!isset($JS) or $JS == NULL) {
			return NULL;
		}
		if(is_array($JS)) {
			$str = "";
			foreach ($JS as $key => $value) {
				$str .= '<script src="'.base_url('assets').'/'.$value.'" type="text/javascript"></script>';
			}
			return $str;
		} else if(is_string($JS)) {
			return '<script src="'.base_url('assets').'/'.$JS.'" type="text/javascript"></script>';
		}
	}
}

/*
* @Function_name : getActiveCtlr
* @Return_type : String
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('getActiveCtlr'))
{
	function getActiveCtlr($ctlr = null)
	{
		$CI =& get_instance();

		$aktif =  $CI->uri->segment(1);
		if (in_array($aktif, $ctlr)) {
		    return "active open";
		}else{
			return false;
		}
	}
}

/*
* @Function_name : getArrowCtlr
* @Return_type : String
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('getArrowCtlr'))
{
	function getArrowCtlr($ctlr = null)
	{
		$CI =& get_instance();

		$aktif =  $CI->uri->segment(1);
		if (in_array($aktif, $ctlr)) {
		    return "open";
		}else{
			return false;
		}
	}
}


/*
* @Function_name : getActiveFunc
* @Return_type : String
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('getActiveFunc'))
{
	function getActiveFunc($funct = null)
	{
		$CI =& get_instance();

		$ctlr =  $CI->uri->segment(1);
		$func =  $CI->uri->segment(2);
		if (empty($func)){
			$func = "index";
		}
		if ($funct == $ctlr."/".$func) {
		    return "class='active'";
		}else{
			return false;
		}
	}
}

if (!function_exists('getActiveFunction'))
{
	function getActiveFunction($funct = null)
	{
		$CI =& get_instance();

		$ctlr =  $CI->uri->segment(1);
		$func =  $CI->uri->segment(2);
		$func3 =  $CI->uri->segment(3);
		if (empty($func)){
			$func = "index";
		}
		if ($funct == $ctlr."/".$func."/".$func3) {
		    return "class='active'";
		}else{
			return false;
		}
		echo $funct;
	}
}

if (!function_exists('getFlag'))
{
	function getFlag($semester)
	{
		$ganjil = array(1,3,5);
		if (in_array($semester, $ganjil)) {
		    return "Ganjil";
		}else{
			return "Genap";
		}
	}
}
	
/*
* @Function_name : showLevel
* @Return_type : String
* @Author : Restu Adtywarman /085797090845
*/	
if ( ! function_exists('showLevel'))
{
	function showLevel($level)
	{
		$currentLevel = $_SESSION['userlog']['sess_role'];
		
		if (in_array($currentLevel, $level)) {
		    return "";
		}else{
			return "display: none;";
		}	
	}
}

/*
* @Function_name : uploadPic
* @Return_type : Array
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('uploadPic'))
{
	function uploadPic($File, $location, $format)
	{
		$aExt = array("jpeg", "jpg", "png");
		$t = explode(".", $File["name"]);
		$ext = end($t);
		if ((($File["type"] == "image/png") || ($File["type"] == "image/jpg") || ($File["type"] == "image/jpeg")) && ($File["size"] < 2000000)&& in_array($ext, $aExt))
			{
				if ($File["error"] > 0){
						$data = array('code' => 500, 'message' => 'Terjadi kesalahan pada file yang di upload');
				}else{
					$sPath = $File['tmp_name'];
					$nPic = $format.".".$ext;
					$tPath = "./assets/global/".$location."/".$nPic;
					move_uploaded_file($sPath,$tPath);
					$data = array('code' => 200, 'upload_data' => $nPic);
				}
			}else{
				$data = array('code' => 500, 'message' => 'Terjadi kesalahan pada file yang di upload');
			}
		return $data;
	}
}

/*
* @Function_name : deletePic
* @Return_type : Array
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('deletePic'))
{
	function deletePic($File, $location)
	{
		if (file_exists("./assets/global/".$location."/". $File)) {
			unlink("./assets/global/".$location."/". $File);
			$data = array('code' => 200, 'message' => 'Gambar berhasil di hapus');
		}else{
			$data = array('code' => 505, 'message' => 'File not found');
		}
		return $data;
	}
}

/*
* @Function_name : uploadFile
* @Return_type : Array
* @Author : Restu Adtywarman /085797090845
*/	
if (!function_exists('uploadFile'))
{
	function uploadFile($File, $location,$format)
	{
		$aExt = array("jpeg", "jpg", "png");
		$t = explode(".", $File["name"]);
		$ext = end($t);
		if (($File["size"] < 50000000))
			{
				if ($File["error"] > 0){
						$data = array('code' => 500, 'message' => 'Terjadi kesalahan pada file yang di upload');
				}else{
					$lokasi = "./assets/global/".$location;
					if (!file_exists($lokasi)) {
					    mkdir($lokasi, 0777, true);
					}

					$sPath = $File['tmp_name'];
					$nPic = "file_".$format.".".$ext;
					$tPath = $lokasi.$nPic;
					move_uploaded_file($sPath,$tPath);
					$data = array('code' => 200, 'upload_data' => $nPic, 'lokasi_data' => $lokasi);
				}
			}else{
				$data = array('code' => 500, 'message' => 'file terlalu besar');
			}
		return $data;
	}
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

if (!function_exists('email'))
{
	function email($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'emaiL', 't_login', null, null, null, array("loginID = '".$id."'"));
		if ($get) :
			return $get->emaiL;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_sector'))
{
	function name_sector($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'sector', 't_company_sector', null, null, null, array("sector = '".$id."'"));
		if ($get) :
			return $get->sector;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_university'))
{
	function name_university($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'universityName', 't_university', null, null, null, array("universityID = '".$id."'"));
		if ($get) :
			return $get->universityName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('get_universityID'))
{
	function get_universityID($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'universityID', 't_university', null, null, null, array("universityID = '".$id."'"));
		if ($get) :
			return $get->universityID;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_faculty'))
{
	function name_faculty($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'facultyName', 't_faculty', null, null, null, array("facultyID = '".$id."'"));
		if ($get) :
			return $get->facultyName;
		else :
			return false;
		endif;
	}
}
if (!function_exists('get_facultyID'))
{
	function get_facultyID($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'facultyID', 't_faculty', null, null, null, array("facultyID = '".$id."'"));
		if ($get) :
			return $get->facultyID;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_dept'))
{
	function name_dept($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'deptName', 't_department', null, null, null, array("deptID = '".$id."'"));
		if ($get) :
			return $get->deptName;
		else :
			return false;
		endif;
	}
}
if (!function_exists('get_deptID'))
{
	function get_deptID($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'deptID', 't_admin', null, null, null, array("adminID = '".$id."'"));
		if ($get) :
			return $get->deptID;
		else :
			return false;
		endif;
	}
}

if (!function_exists('residence'))
{
	function residence($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'residenceName', 't_residence', null, null, null, array("residenceID = '".$id."'"));
		if ($get) :
			return $get->residenceName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('gender'))
{
	function gender($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'genderName', 't_gender', null, null, null, array("genderID = '".$id."'"));
		if ($get) :
			return $get->genderName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_project'))
{
	function name_project($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'projectName', 't_project', null, null, null, array("projectID = '".$id."'"));
		if ($get) :
			return $get->projectName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('get_projectID'))
{
	function get_projectID($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'projectID', 't_project_scope', null, null, null, array("projectScopeID = '".$id."'"));
		if ($get) :
			return $get->projectID;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_projectscope'))
{
	function name_projectscope($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'projectScope', 't_project_scope', null, null, null, array("projectScopeID = '".$id."'"));
		if ($get) :
			return $get->projectScope;
		else :
			return false;
		endif;
	}
}

if (!function_exists('get_scopeID'))
{
	function get_scopeID($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'projectScopeID', 't_workscope', null, null, null, array("mahasiswaID = '".$id."'"));
		if ($get) :
			return $get->projectScopeID;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_mhs'))
{
	function name_mhs($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'fullName', 't_mahasiswa', null, null, null, array("mahasiswaID = '".$id."'"));
		if ($get) :
			return $get->fullName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_admin'))
{
	function name_admin($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'fullName', 't_admin', null, null, null, array("adminID = '".$id."'"));
		if ($get) :
			return $get->fullName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_category'))
{
	function name_category($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'categoryName', 't_category', null, null, null, array("categoryID = '".$id."'"));
		if ($get) :
			return $get->categoryName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_task'))
{
	function name_task($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'taskName', 't_task', null, null, null, array("taskID = '".$id."'"));
		if ($get) :
			return $get->taskName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('chk_statsTask'))
{
	function chk_statsTask($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'statusTask', 't_task', null, null, null, array("taskID = '".$id."'"));
		if ($get) :
			return $get->statusTask;
		else :
			return false;
		endif;
	}
}


if (!function_exists('chk_statsMhs'))
{
	function chk_statsMhs($id = null)
	{
		$CI =& get_instance();

		$dsn = $CI->Mod_crud->checkData('statusActive', 't_mahasiswa', array('mahasiswaID = "'.$id.'"','statusActive = 1'));
		if ($dsn) :
			return true;
		else :
			return false;
		endif;
	}
}
if (!function_exists('chk_applyMhs'))
{
	function chk_applyMhs($id = null)
	{
		$CI =& get_instance();
		$mahasiswaID = $CI->session->userdata('login')['sess_usrID'];
		$dsn = $CI->Mod_crud->checkData('*', 't_project_scope_temp', array('projectScopeID = "'.$id.'"','mahasiswaID = "'.$mahasiswaID.'"','type = "Applied"'));
		if ($dsn) :
			return true;
		else :
			return false;
		endif;
	}
}

if (!function_exists('chk_typeTemp'))
{
	function chk_typeTemp($id = null)
	{
		$CI =& get_instance();
		$mahasiswaID = $CI->session->userdata('login')['sess_usrID'];
		$dsn = $CI->Mod_crud->getData('row','type','t_project_scope_temp',null,null,null, array('projectScopeID = "'.$id.'"','mahasiswaID = "'.$mahasiswaID.'"'));
		if ($dsn) :
			return $dsn->type;
		else :
			return false;
		endif;
	}
}

if (!function_exists('chk_statsTemp'))
{
	function chk_statsTemp($id = null)
	{
		$CI =& get_instance();
		$mahasiswaID = $CI->session->userdata('login')['sess_usrID'];
		$dsn = $CI->Mod_crud->getData('row','statusTemp','t_project_scope_temp',null,null,null, array('projectScopeID = "'.$id.'"','mahasiswaID = "'.$mahasiswaID.'"'));
		if ($dsn) :
			return $dsn->statusTemp;
		else :
			return false;
		endif;
	}
}

if (!function_exists('chk_totalApply'))
{
	function chk_totalApply($id = null)
	{
		$CI =& get_instance();
		$dsn = $CI->Mod_crud->countData('result','projectScopeID','t_project_scope_temp',null,null,null,array('projectScopeID = "'.$id.'"'));
		return $dsn;
	}
}

if (!function_exists('chk_totalTask'))
{
	function chk_totalTask($id = null)
	{
		$CI =& get_instance();
		$dsn = $CI->Mod_crud->countData('result','workscopeID','t_task',null,null,null,array('workscopeID = "'.$id.'"'));
		return $dsn;
	}
}

if (!function_exists('chk_totalTaskDone'))
{
	function chk_totalTaskDone($id = null)
	{
		$CI =& get_instance();
		$dsn = $CI->Mod_crud->qry('row','SELECT COUNT(taskID) as total FROM `t_task` WHERE (statusTask = "done" OR statusTask = "done-delay") AND (workscopeID = "'.$id.'")');
		if ($dsn) :
			return $dsn->total;
		else :
			return false;
		endif;
	}
}

if (!function_exists('chk_workMhs'))
{
	function chk_workMhs($id=null)
	{
		$CI =& get_instance();
		$dsn = $CI->Mod_crud->checkData('*', 't_workscope', array('mahasiswaID = "'.$id.'"'));
		if ($dsn) :
			return true;
		else :
			return false;
		endif;
	}
}

if (!function_exists('logtype'))
{
	function logtype($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'typeName', 't_log_type', null, null, null, array("logTypeID = '".$id."'"));
		if ($get) :
			return $get->typeName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_company'))
{
	function name_company($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'companyName', 't_company', null, null, null, array("companyID = '".$id."'"));
		if ($get) :
			return $get->companyName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('name_comunity'))
{
	function name_comunity($id=null)
	{
		$CI =& get_instance();

		$get = $CI->Mod_crud->getData('row', 'comunityName', 't_comunity', null, null, null, array("comunityID = '".$id."'"));
		if ($get) :
			return $get->comunityName;
		else :
			return false;
		endif;
	}
}

if (!function_exists('pencarian_highlight'))
{
	function pencarian_highlight($record_dari_tabel_db, $pencarian)
	{
	    preg_match_all('~\w+~', $pencarian, $m);
	    if(!$m)
	    	return $record_dari_tabel_db;
	   	$re = '~\\b(' . implode('|', $m[0]) . ')\\b~'; 
	    	return preg_replace($re, '<b>$0</b>', $record_dari_tabel_db);
	}
}

if (!function_exists('highlightKeywords'))
{
	function highlightKeywords($text, $keyword) {
		$result = preg_replace('#'. preg_quote($keyword).'#i', '<b>\\0</b>', $text);
		if ($result) {
			return $result;
		}else{
			return false;
		}

	}
}
// if (!function_exists('highlightKeywords'))
// {
// 	function highlightKeywords($text, $keyword) {
// 		$wordsAry = explode(" ", $keyword);
// 		$wordsCount = count($wordsAry);

// 		for($i=0;$i<$wordsCount;$i++) {
// 			$highlighted_text = "<span style='font-weight:bold;'>$wordsAry[$i]</span>";
// 			$text = str_ireplace($wordsAry[$i], $highlighted_text, $text);
// 		}

// 		return $text;
// 	}
// }


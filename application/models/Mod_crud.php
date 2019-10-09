<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mod_crud extends CI_Model {

	function getData($type = null, $select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null, $like = null)
	{
		$command = "SELECT $select FROM $table";
	 	if ($joins != null)
			{	
				foreach($joins as $key => $values)
				{
					$command .= " LEFT JOIN $key ON $values ";
				}
			}

		if ($like != null AND $where != null)
			{	
				$command .= ' WHERE '.$like.' AND '.implode(' AND ',$where);
			}

		if ($where != null AND $like == null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}

		if ($like != null AND $where == null) {
				$command .= ' WHERE '.$like;
			}

		if ($group != null)
			{	
				$command .= ' GROUP BY '.implode(', ',$group);
			}

		if ($order != null)
			{	
				$command .= ' ORDER BY '.implode(', ',$order);
			}
		if ($limit != null)
			{
				if ($offset != null)
					{
						$command .= " LIMIT $offset, $limit";
					}else{
						$command .= " LIMIT $limit";
					}	
			}
		$data = $this->db->query($command);
		if ($data->num_rows() > 0)
		{
			return  ($type == 'result') ? $data->result() : $data->row();
		}else{
			return false;
		}
	}

	function countData($type = null, $select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null, $like = null)
	{
		$command = "SELECT $select FROM $table";
	 	if ($joins != null)
			{	
				foreach($joins as $key => $values)
				{
					$command .= " LEFT JOIN $key ON $values ";
				}
			}
			
		if ($like != null AND $where != null)
			{	
				$command .= ' WHERE '.$like.' AND '.implode(' AND ',$where);
			}

		if ($where != null AND $like == null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}

		if ($like != null AND $where == null) {
				$command .= ' WHERE '.$like;
			}

		if ($group != null)
			{	
				$command .= ' GROUP BY '.implode(', ',$group);
			}

		if ($order != null)
			{	
				$command .= ' ORDER BY '.implode(', ',$order);
			}
		if ($limit != null)
			{
				if ($offset != null)
					{
						$command .= " LIMIT $offset, $limit";
					}else{
						$command .= " LIMIT $limit";
					}	
			}
		$data = $this->db->query($command);
		return $data->num_rows();
	}

	function qry($type = null, $command)
	{
		$data = $this->db->query($command);
		if ($type != null)
		{
			if ($type == 'bool') {
				return $data;
			}else{
				return ($type == 'result') ? $data->result() : $data->row();
			}
		}else{
			if ($data->num_rows() > 0)
			{
				return true;
			}else{
				return false;
			}
		}
	}

	function query($command)
	{
		$data = $this->db->query($command);
		return $data;
	}

	function checkData($row, $table, $where)
	{
		$command = "SELECT $row FROM $table";
		if ($where != null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}
		//return $command;
		$data = $this->db->query($command);
		if ($data->num_rows() > 0)
		{
			return true;
		}else{
			return false;
		}

	}

	function insertData($table,$data)
	{
		$data = $this->db->insert($table,$data);
		return $data;
	}

	function updateData($table,$data,$where)
	{
		foreach ($where as $key => $values) {
			$this->db->where($key, $values);
		}
		$data = $this->db->update($table,$data);
		return $data;
	}

	function deleteData($table,$where)
	{
		foreach ($where as $key => $values) {
			$this->db->where($key, $values);
		}
		$data = $this->db->delete($table);
		return $data;
	}

	function autoNumber($field, $table, $format, $digit)
	{
		$qry = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS KodeAkhir FROM $table WHERE $field LIKE '$format%'");
		if ($qry->num_rows() > 0){
			$nextCode = $qry->row('KodeAkhir') + 1;
		}else{
			$nextcode = 1;
		}
		$kode = $format.sprintf("%0".$digit."s", $nextCode);
		return $kode;
	}

	public function insert_multiple_mhs($data,$id){
	    $this->db->insert_batch('mahasiswa', $data);
	  }
	
	function get_table_list(){
		$table = $this->db->list_tables();
		$table_list = array();
		$x=0;
		foreach($table as $val){
			$ex = explode('_',$val);
			if($ex[0] <> 'sysx' ){
				$table_list[$x] = $val;
				$x++;
			}
		}
		return $table_list;
	}

	function qry_field_info($select, $table, $limit = null, $offset = null, $joins = null, $where = null, $group = null, $order = null, $like = null)
	{
		$command = "SELECT $select FROM $table";
	 	if ($joins != null)
			{	
				foreach($joins as $key => $values)
				{
					$command .= " LEFT JOIN $key ON $values ";
				}
			}
			
		if ($like != null AND $where != null)
			{	
				$command .= ' WHERE '.$like.' AND '.implode(' AND ',$where);
			}

		if ($where != null AND $like == null)
			{	
				$command .= ' WHERE '.implode(' AND ',$where);
			}

		if ($like != null AND $where == null) {
				$command .= ' WHERE '.$like;
			}

		if ($group != null)
			{	
				$command .= ' GROUP BY '.implode(', ',$group);
			}

		if ($order != null)
			{	
				$command .= ' ORDER BY '.implode(', ',$order);
			}
		if ($limit != null)
			{
				if ($offset != null)
					{
						$command .= " LIMIT $offset, $limit";
					}else{
						$command .= " LIMIT $limit";
					}	
			}
		$data = $this->db->query($command);
		return $data->field_data();
	}
	
	function get_field_info($table_name){
		return $this->db->field_data($table_name);
	}
	
	function create_field_user_input($table_name){
		$this->load->dbforge();
		if (!$this->db->field_exists('user_input', $table_name)){
				$fields = array( 'user_input' => array('type' => 'INT'));
				$this->dbforge->add_column($table_name, $fields);
		}
		
	}
	
	function get_count($table_name){
      return $this->db->count_all($table_name);
	}


}

/* End of file Mod_crud.php */
/* Location: ./application/models/Mod_crud.php */
<?php	if (!defined('BASEPATH')) {exit('Access Denied');}
class Release_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('release',true);
	}

	function get_all_project()
	{
		$query = $this->db->get('rel_project');
		return $query->result_array();
	}

	function get_project_name($id)
	{
		$sql = 'SELECT project_name FROM rel_project WHERE project_id = ?';
		$query = $this->db->query($sql,$id);		
		return $query->row()->project_name;
	}
	
	function get_version_count($id)
	{
		$sql = 'SELECT version_type FROM rel_version WHERE project_id = ? GROUP BY version_type';
		$query = $this->db->query($sql,$id)->result_array();
		$res = array();
		for ($i = 0;$i < count($query);$i++){
			$res[$i] = $query[$i]['version_type'];
		}
		return $res;
	}
	
	
	function get_project_version($id,$type)
	{
		$sql = 'SELECT * FROM rel_version WHERE project_id = ? AND version_type = ?';
		$data = array($id,$type);
		$query = $this->db->query($sql,$data);
		return $query->result_array();
	}

	function delete_version($id)
	{
		$sql = 'DELETE FROM rel_version WHERE version_id = ?';
		$this->db->query($sql,$id);
		return $this->db->affected_rows();
	}

	function insert_version($version_name,$version_date,$project_id,$file_name,$file_url,$version_type)
	{
		$sql = 'INSERT INTO rel_version VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$data = array(null,$version_name,$version_date,$project_id,$file_name,$file_url,null,$version_type);
		$this->db->query($sql,$data);
		return $this->db->affected_rows();
	}
	
	
	
	
}

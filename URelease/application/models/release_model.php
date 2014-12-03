<?php	if (!defined('BASEPATH')) {exit('Access Denied');}
class Release_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('release',true);
	}

	function get_all_project()
	{
		$sql = 'SELECT P.project_id,P.project_name,P.page_url,Va.version_name AS android_version,Vb.version_name AS ios_version 
				FROM rel_project AS P 
				LEFT JOIN rel_version AS Va ON (Va.project_id = P.project_id AND Va.is_publish = 1 AND Va.version_type = 1)
				LEFT JOIN rel_version AS Vb ON (Vb.project_id = P.project_id AND Vb.is_publish = 1 AND Vb.version_type = 2)';
		$query = $this->db->query($sql);
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

	function insert_version($version_name,$version_date,$project_id,$file_name,$file_url,$version_type,$is_publish)
	{
		if($is_publish == 1){
			$sql = 'UPDATE rel_version SET is_publish = 0 WHERE is_publish = 1 AND project_id = ? AND version_type = ?';
			$this->db->query($sql,array($project_id,$version_type));
		}
		$sql = 'INSERT INTO rel_version VALUES (?, ?, ?, ?, ?, ?, ?, ?,?)';
		$data = array(null,$version_name,$version_date,$project_id,$file_name,$file_url,null,$version_type,$is_publish);
		$this->db->query($sql,$data);
		return $this->db->affected_rows();
	}
	
	function update_version_publish($version_id)
	{
		$sql = 'SELECT project_id,version_type FROM rel_version WHERE version_id = ?';
		$data = $this->db->query($sql,$version_id);	
			if ($data->num_rows() == 1){
				$row = $data->row_array();
				$sql = 'UPDATE rel_version SET is_publish = 0 WHERE project_id = ? AND version_type = ?';
				$this->db->query($sql,array($row['project_id'],$row['version_type']));
				$sql = 'UPDATE rel_version SET is_publish = 1 WHERE version_id = ?';
				$this->db->query($sql,(int)$version_id);
			}
		return $this->db->affected_rows();
	}
	
	
}

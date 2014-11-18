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

}

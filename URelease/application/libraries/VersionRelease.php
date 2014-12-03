<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class VersionRelease {
		
	public function __construct()
	{
		log_message('debug', "VersionRelease Class Initialized");
		$this->CI =& get_instance();		
	}
	
	function get_project_data($p_list){
		$this->CI->load->library('Widget');
		$p_data = array();
		if(0<count($p_list)){
			for($i = 0; $i < count($p_list); $i++){
				$p_data[$i][0] = $p_list[$i]['project_id'];
				$p_data[$i][1] = $p_list[$i]['project_name'];
				$p_data[$i][2] = $p_list[$i]['page_url'];
				$p_data[$i][3] = $p_list[$i]['android_version'];
				$p_data[$i][4] = $p_list[$i]['ios_version'];
				$p_data[$i][5] = $this->CI->widget->version_button($p_list[$i]['project_id'],ENTER);
			}
		}
		return $p_data;
	}
	
	function get_version_data($v_list){
		$this->CI->load->library('Widget');
		$v_data = array();
		if(0<count($v_list)){
			for($i = 0; $i < count($v_list); $i++){
				$v_id = $v_list[$i]['version_id'];
				$v_data[$i][0] = $v_list[$i]['version_name'];
				$v_data[$i][1] = $v_list[$i]['version_date'];
				$v_data[$i][2] = $v_list[$i]['file_url'];
				$v_data[$i][3] = $this->CI->widget->public_radio($v_list[$i]['version_type'],$v_id,$v_list[$i]['is_publish']);
				$v_data[$i][4] = $this->CI->widget->delete_version($v_id,DELETE);
			}
		}
		return $v_data;
	}
	
	
	
	
	
}
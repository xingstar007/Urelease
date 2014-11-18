<?php

class MY_Loader extends CI_Loader {
	
	public function __construct() {
		parent::__construct ();
		$this->_ci_view_paths = array (
				FCPATH . '/templates/' => TRUE 
		);
	}
}
// FCPATH 是和 application、system、index.php 同级的文件目录
?>
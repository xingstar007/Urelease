<?php	if (!defined('BASEPATH')) {exit('Access Denied');}

if( !function_exists("get_project_data")){
	function get_project_data($p_list){
		$p_data = array();
		if(0<count($p_list)){
			for($i = 0; $i < count($p_list); $i++){
				$p_data[$i][0] = $p_list[$i]['project_id'];
				$p_data[$i][1] = $p_list[$i]['project_name'];
				$p_data[$i][2] = $p_list[$i]['page_url'];
				$p_data[$i][3] = '<a href = "./release/version/'.$p_list[$i]['project_id'].'"><button type="button" class="btn btn-outline btn-default btn-xs">Default</button></a>';
			}
		}
		return $p_data;
	}
}


if( !function_exists("get_version_data")){
	 function get_version_data($v_list){
		$v_data = array();
		if(0<count($v_list)){
			for($i = 0; $i < count($v_list); $i++){
				$v_data[$i][0] = $v_list[$i]['version_name'];
				$v_data[$i][1] = $v_list[$i]['version_date'];
				$v_data[$i][2] = $v_list[$i]['file_url'];
				$v_data[$i][3] = '<button type="button"  onclick = "del_version('.$v_list[$i]['version_id'].')" class="btn btn-outline btn-default btn-xs">Default</button>';
			}
		}
		return $v_data;
	}
}

if( !function_exists("default_table_style")){
	function default_table_style(){
		$dataTables = array (
		
				'table_open'          => '<table class="table table-striped table-bordered table-hover">',
		
				'heading_row_start'   => '<tr>',
				'heading_row_end'     => '</tr>',
				'heading_cell_start'  => '<th>',
				'heading_cell_end'    => '</th>',
		
				'row_start'           => '<tr class="odd gradeX">',
				'row_end'             => '</tr>',
				'cell_start'          => '<td>',
				'cell_end'            => '</td>',
		
				'row_alt_start'       => '<tr class="even gradeC">',
				'row_alt_end'         => '</tr>',
				'cell_alt_start'      => '<td>',
				'cell_alt_end'        => '</td>',
		
				'table_close'         => '</table>'
		);
		return	$dataTables;		
	}
}


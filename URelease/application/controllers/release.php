<?php	if (!defined('BASEPATH')) {exit('Access Denied');}
class Release extends CI_Controller {
	
	
	
	
	function __construct()
	{
		parent::__construct();
		//加载项目列表数据	
		$this->load->model('Release_model');
		//加载HTML表格库
		$this->load->library('table');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->helper('release_helper');

	}
	
	public function index(){
		$projectlist = $this->Release_model->get_all_project();
		$project_data = get_project_data($projectlist);

		//页面信息
		$page_data['page_title'] = '产品发布管理';
		$page_data['project_table_title'] = '项目列表';
		
		//设置表格样式dataTables
		$dataTables = array (
		
				'table_open'          => '<table class="table table-striped table-bordered table-hover" id="dataTables-example">',
		
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
		$this->table->set_template($dataTables);
		
		//设置表格列名称
		$this->table->set_heading('项目ID', '项目名称', '项目下载页面地址','操作');
		
		$project_table = $this->table->generate($project_data);
		
		$page_data['project_table'] = $project_table;

		$this->load->view('AdminTwo/project',$page_data);
	}
	
	public function version($id,$name)
	{
		$versionlist = $this->Release_model->get_project_version($id,1);
		$version_data = get_version_data($versionlist);

		//页面信息
		$page_data['page_title'] = $name;
		
		//页面信息
		$page_data['android_table_title'] = '安卓版本列表';
		$page_data['IOS_table_title'] = '苹果版本列表';

		//设置表格样式dataTables
		$dataTables = array (
		
				'table_open'          => '<table class="table table-striped table-bordered table-hover" id="dataTables-example">',
		
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
		$this->table->set_template($dataTables);
	
		$this->table->set_heading('版本号', '上传时间', '文件地址','操作');
	
		$version_table = $this->table->generate($version_data);
	
		$page_data['version_table'] = $version_table;
	
		$this->load->view('AdminTwo/version_page',$page_data);
	}
	
	public function version_delete()
	{
		$this->load->library('input');
		$del_version_id = $this->input->post('del_version_id');
		$del_result = $this->Release_model->delete_version($del_version_id);
		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		return json_encode($del_result);
	}
	
	
}
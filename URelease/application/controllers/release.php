<?php	if (!defined('BASEPATH')) {exit('Access Denied');}
class Release extends CI_Controller {
				
	function __construct()
	{
		parent::__construct();

		$this->load->model('Release_model');
		$this->load->helper('release_helper');
		$this->load->helper('array');
	}
	
	public function index(){

		$this->load->library('table');
		
		$projectlist = $this->Release_model->get_all_project();
		$project_data = get_project_data($projectlist);

		$page_data['page_title'] = '产品发布管理';
		$page_data['project_table_title'] = '项目列表';
					
		$this->table->set_template(default_table_style());
		
		$this->table->set_heading('项目ID', '项目名称', '项目下载页面地址','操作');
		
		$project_table = $this->table->generate($project_data);
		
		$page_data['project_table'] = $project_table;

		$this->load->view('AdminTwo/project_page',$page_data);
	}
	
	public function version($project_id)
	{	
		$this->load->library('table');
		$this->load->library('form_validation');
		$this->load->library('input');
		$this->load->helper('form');
		
		$version_page_data['page_title'] = $this->Release_model->get_project_name($project_id);
		$version_page_data['project_id'] = $project_id;
		
		$version_count = $this->Release_model->get_version_count($project_id);
		for ($i =0 ; $i < count($version_count);$i++){
			$versionlist = $this->Release_model->get_project_version($project_id,$version_count[$i]);
			if($version_count[$i] == 1){
				$version_table[$i]['tittle'] = '安卓版本列表';				
			}else if($version_count[$i] == 2){
				$version_table[$i]['tittle'] = '苹果版本列表';
			}
			$this->table->set_template(default_table_style());
			$this->table->set_heading('版本号', '上传时间', '文件地址','操作');
			$version_table[$i]['data'] = $this->table->generate(get_version_data($versionlist));
		}
		$version_page_data['version_table'] = $version_table;
		
		$this->load->view('AdminTwo/version_page',$version_page_data);
		
	}

	
	function create_version_submit()
	{
		$product_result = $this->product_fild_upload();
		if (array_keys($product_result)[0]== 'success'){
			$product = element('success', $product_result);
			$project_id = $this->input->post('project_id');
			$version_type = $this->input->post('version_type');
			$version_name = $this->input->post('version_name');
						
			$file_name = $product['file_name'];
			$file_url = $product['full_path'];
			
			$this->load->helper('date');
			$version_date =  mdate("%Y-%m-%d", time());
			
			$this->Release_model->insert_version($version_name,$version_date,$project_id,$file_name,$file_url,$version_type);
			$this->version($project_id);
		}else {
			$error = element('error', $product_result);
			
		}
			
	}
	
	function product_fild_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '10000';
	
		$this->load->library('upload', $config);
	
		if ( ! $this->upload->do_upload('product')) {
			$error = array('error' => $this->upload->display_errors());
			return $error;
		}else {
			$upload_data = array('success' => $this->upload->data());
			return $upload_data;
		}
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
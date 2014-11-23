<?php	if (!defined('BASEPATH')) {exit('Access Denied');}
class Release extends CI_Controller {
				
	function __construct()
	{
		parent::__construct();

		$this->load->model('Release_model');
		$this->load->helper('array');
		$this->load->helper('constant');
		$this->load->library('table');
		$this->load->library('versionrelease');
	}
	
	function index()
	{
		$projectlist = $this->Release_model->get_all_project();
 		$project_data = $this->versionrelease->get_project_data($projectlist);
		
		$page_data['page_title'] = PROJECT_PAGETITLE;
		$page_data['project_table_title'] = PROJECT_TABLETITLE;
			
		$this->table->set_template(default_table_style());
	
		$this->table->set_heading(project_table_heading());
	
		$project_table = $this->table->generate($project_data);
	
		$page_data['project_table'] = $project_table;
	
		$this->load->view('AdminTwo/project_page',$page_data);
	}
	
	function version()
	{		
		$this->load->library('input');
		$this->load->helper('form');
		
		$project_id = $this->input->post('project_id');
			
		$version_page_data['page_title'] = $this->Release_model->get_project_name($project_id);
		$version_page_data['project_id'] = $project_id;
		
		$version_page_data['version_table'] = $this->version_talbe($project_id);
		$this->load->view('AdminTwo/version_page',$version_page_data);	
	}

	function version_talbe($project_id)
	{
		$version_count = $this->Release_model->get_version_count($project_id);
		for ($i =0 ; $i < count($version_count);$i++)
		{
			$versionlist = $this->Release_model->get_project_version($project_id,$version_count[$i]);
			if($version_count[$i] == 1)
			{
				$version_table[$i]['tittle'] = VERSION_ANDROIDTITLE;
			}
			else if($version_count[$i] == 2)
			{
				$version_table[$i]['tittle'] = VERSION_IOSTITLE;
			}
			$this->table->set_template(default_table_style());
			$this->table->set_heading(version_table_heading());
			$version_table[$i]['data'] = $this->table->generate($this->versionrelease->get_version_data($versionlist));
		}
		$version_table_data['version_table'] = $version_table;
		return $this->load->view('AdminTwo/version_table',$version_table_data,TRUE);				
	}
			
	function create_version_submit()
	{
		$this->load->library('form_validation');

		$project_id = $this->input->post('project_id');
		$version_type = $this->input->post('version_type');
		$version_name = $this->input->post('version_name');
		
		if(($project_id =='')||$version_type==''||$version_name =='')
		{
			$res = array ('result'=>'0','msg'=>CREATE_VERSION_ERROR1);
			echo json_encode($res);
		}
		else
		{
			$product_result = $this->product_fild_upload();
			if (array_keys($product_result)[0]== 'success')
			{
				$product = element('success', $product_result);
				
				$file_name = $product['full_path'];
				$file_url = base_url().'uploads/'.$product['file_name'];
					
				$this->load->helper('date');
				$version_date =  mdate("%Y-%m-%d", time());
					
				$this->Release_model->insert_version($version_name,$version_date,$project_id,$file_name,$file_url,$version_type);
				echo $this->version_talbe($project_id);
			}
			else
			{
				$error = element('error', $product_result);
				echo $error;
			}
		}
						
	}
	
	function product_fild_upload()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = '10000';
		$config['encrypt_name'] = 'TRUE';
		
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
		echo json_encode($del_result);
	}
	
	
}
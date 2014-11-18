<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * hills-admin
 *
 * 
 * 
 *
 * @package     
 * @author      hillsdong@163.com
 * @copyright   Copyright (c) 2013 - 2013, hills.
 * @license     GNU General Public License 2.0
 * @link        
 * @version     0.1.0
 */
 
// ------------------------------------------------------------------------

/**
 *  自定义类
 *
 *  通用于各数据表的增删改查操作
 *
 * @package     DECDS
 * @subpackage  Controller Model
 * @category    Library
 * @author      hillsdong@163.com
 * @link        
 */
class Commen_model{
	protected $CI; //框架原始函数引用
    protected $data;
     /**
     * 解析函数
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
    	$this->CI =& get_instance(); //框架原始函数引用
    	$this->CI->load->database();
    }
    /**
     * 根据提交submit的值执行各种操作 并 根据条件调出最新结果
     * 
     * @access public
     * @param  data
     * @return null
     */
    public function run($data)
    {
    	$this->data = $data;
    	$query = $_REQUEST;
		//获取字段元数据
		$this->data['title_re'] = $this->get_field();
		$this->data['item_title_n'] = count($this->data['title_re']);
    	/*新建数据行*/
    	if(isset($query['insert'])&&is_numeric($query['insert'])){
    		$this->data['insert_n'] = $query['insert'];
    		$view_crud_do = TRUE; 
            //查找关联项
            if(isset($data['config']['field_tool'])){
                foreach($data['config']['field_tool'] as $key=>$val){
                    if($val=='select'&&isset($data['config']['field_tool'][$key.'_config'])){
                        $select_config = $data['config']['field_tool'][$key.'_config'];
                        $select_config[3] = isset($select_config[3])?$select_config[3]:'';
                        $this->data['select_re'][$key] =  $this->get_select($select_config[0],$select_config[1].','.$select_config[2],$select_config[3]);
                    }
                    if($val=='arr_select'&&isset($data['config']['field_tool'][$key.'_config'])){
                        $select_config = $data['config']['field_tool'][$key.'_config'];
                        $this->CI->config->load($select_config[0]);
                        $this->data['select_re'][$key] =  $this->CI->config->item($select_config[1]);
                    }
                }
            }		
    	}
    	/*复制数据行*/
    	if(isset($query['copy'])&&(is_numeric($query['copy'])||isset($query['check_id']))){
    		$ids = is_numeric($query['copy'])?$query['copy']:$query['check_id'];
			$this->data['copy_re'] = $this->get_by_ids($ids);
			if(!isset($this->data['copy_re'])){
				$this->data['insert_n'] = 1;
			}
			$view_crud_do = TRUE;
		}
    	/*编辑数据行*/
    	if(isset($query['edit'])&&(is_numeric($query['edit'])||isset($query['check_id']))){
    		$ids = is_numeric($query['edit'])?$query['edit']:$query['check_id'];
			$this->data['edit_re'] = $this->get_by_ids($ids);
			$view_crud_do = TRUE;
		}
    	/*删除数据行*/
    	if(isset($query['remove'])&&(is_numeric($query['remove'])||isset($query['check_id']))){
    		$ids = is_numeric($query['remove'])?$query['remove']:$query['check_id'];
			$this->data['remove_re'] = $this->get_by_ids($ids);
			$view_crud_do = TRUE;
		}
		if(isset($view_crud_do)){
			$this->CI->load->view('header', $this->data);
	        $this->CI->load->view('commen/crud_do');
	        $this->CI->load->view('footer');
	        return;
		}
		/*提交后-添加新建数据行*/
    	if(isset($query['submit_insert'])){
    		unset($query['submit_insert']);
    		$insert_n = $query['arr_length'];
    		unset($query['arr_length']);
    		for($i=0;$i<$insert_n;$i++){
    			foreach($query as $key=>$val){
    				$insert_data[$i][$key] = $val[$i];
    			}		
    		}   		
            $this->data['run_re'] = $this->insert($insert_data);
    	}
		/*提交后-更新编辑数据行*/
    	if(isset($query['submit_update'])){
    		unset($query['submit_update']);
    		$insert_n = $query['arr_length'];
    		unset($query['arr_length']);
    		for($i=0;$i<$insert_n;$i++){
    			foreach($query as $key=>$val){
    				$insert_data[$i][$key] = $val[$i];
    			}		
    		}   		
            $this->data['run_re'] = $this->update($insert_data);
    	}
		/*提交后-删除数据行*/
    	if(isset($query['submit_remove'])){
    		unset($query['submit_remove']);
    		$insert_n = $query['arr_length'];
    		unset($query['arr_length']);
    		for($i=0;$i<$insert_n;$i++){
    			$ids[$i]=$query['id'][$i];		
    		}
            $this->data['run_re'] = $this->delete($ids);
    	}
		/*查找表中数据*/
		//页数
		$this->data['page'] = isset($query['page'])?$query['page']:1;	
		//每页显示个数
		if(isset($query['per_page_n'])) $_SESSION['per_page_n'] = $query['per_page_n'];//session临时保存每页项数	
		$this->data['per_page_n'] = isset($_SESSION['per_page_n'])?$_SESSION['per_page_n']:15;
		//构造过滤参数
		if(isset($query['filter_query_clear'])||(isset($query['filter_content'])&&$query['filter_content']=='')){
			unset($_SESSION[$data['model_name'].'_filter_query']);
			unset($_SESSION[$data['model_name'].'_filter_content']);
		} 
		if(isset($query['filter_content'])&&$query['filter_content']!=''){
			$query_filter_query = "";
			foreach ($this->data['title_re'] as $key => $value){
				$query_filter_query .= $data['model_name'].".".$value->name." LIKE '%".$query['filter_content']."%' OR ";
			}			
			$_SESSION[$data['model_name'].'_filter_query']  =  $query_filter_query.$data['model_name'].'.id = 0';
			$_SESSION[$data['model_name'].'_filter_content']  =  $query['filter_content'];
		}
        if(isset($query['filter_a'])){
            $query_filter_query = $query_filter_content = "";
            unset($query['filter_a']);
            foreach ($query as $key => $value){
                $query_filter_query .= $data['model_name'].".".$key." = ".$value." AND ";
                $query_filter_content .= $data['model_name'].".".$key." = ".$value;
            }           
            $_SESSION[$data['model_name'].'_filter_query']  =  $query_filter_query.$data['model_name'].'.id != 0';
            $_SESSION[$data['model_name'].'_filter_content']  =  $query_filter_content;
        }
		$this->data['filter_query'] = isset($_SESSION[$data['model_name'].'_filter_query'])?$_SESSION[$data['model_name'].'_filter_query']:$data['model_name'].'.id != 0';
		//构造排序参数
		if(isset($query['order_clear'])) unset($_SESSION[$data['model_name'].'_order']);
		if(isset($query['order'])){			
			$_SESSION[$data['model_name'].'_order']  =  $data['model_name'].".".$query['order'];
		}
		$this->data['filter_order'] = isset($_SESSION[$data['model_name'].'_order'])?$_SESSION[$data['model_name'].'_order']:$data['model_name'].'.id DESC';
        /*导出excel数据*/
        if(isset($query['excel_out'])){
            if(!isset($query['check_field'])){ echo "未选导出字段！"; return;}
            if($query['out_end']-$query['out_start']<0){ echo "导出范围有误！"; return;}
            $is_out = array('out_start'=>$query['out_start']-1,'out_number'=>$query['out_end']-$query['out_start']+1);
            $is_out['out_fields'] = $this->data['model_name'].'.'.implode(','.$this->data['model_name'].'.', $query['check_field']);
            $data_out =  $this->find_all($is_out);

            $out_time = date("Y-m-d H:i:s");
            $out_title = isset($data['config']['chinese']['ha_model_name'])?$data['config']['chinese']['ha_model_name']:$data['model_name'];
            $data_range = $query['out_start'].'-'.$query['out_end'];
            header("Content-type:application/vnd.ms-excel");
            header("Content-Disposition:attachment;filename=".$out_title."_".date("Y-m-d")."_".$data_range.".xls");
            echo $out_title;
            echo "\n\n";
            echo"数据范围："."\t".$query['out_start'].'-'.$query['out_end']."\t";
            echo "导出日期："."\t".$out_time;
            echo "\n\n"; 
            foreach($query['check_field'] as $key=>$val){
                if(isset($data['config']['chinese'][$val])) echo $data['config']['chinese'][$val]; else echo $val;
                echo "\t"; 
            }
            echo   "\n";
            foreach($data_out as $key=>$val){
                foreach($val as $item){
                    echo $item."\t";
                }
                echo "\n";
            }
            return;
        }		
        //进行查找
		$this->data['find_re'] =  $this->find_all();
        //var_dump($this->data['find_re']);
		$this->data['count_all'] =  $this->get_count();

		$this->CI->load->view('header', $this->data);
        $this->CI->load->view('commen/crud');
        $this->CI->load->view('footer');
        return;	
    }
    /**
     * 获取字段元数据
     * 
     * @access public
     * @param  model_name
     * @return array
     */
    public function get_field()
    {
    	return $this->CI->db->field_data($this->data['model_name']);
    }
    /**
     * 获取总行数
     * 
     * @access public
     * @param  model_name
     * @return int
     */
    public function get_count()
    {
    	$this->CI->db->where($this->data['filter_query']);
    	return $this->CI->db->count_all_results($this->data['model_name']);
    }
    /**
     * 添加一到多行数据
     * 
     * @access public
     * @param  insert_data model_name
     * @return insert_id or false
     */
    public function insert($insert_data)
    {
        if (is_array($insert_data[0]))
        {
        	if($this->CI->db->insert_batch($this->data['model_name'], $insert_data))
        	{
        		return  $this->CI->db->insert_id(); 
        	}     
        }else{
			if($this->CI->db->insert($this->data['model_name'], $insert_data))
        	{
        		return  $this->CI->db->insert_id(); 
        	}     	
        }
        return false;
    }
    /**
     * 更新一到多行数据
     * 
     * @access public
     * @param  insert_data model_name
     * @return insert_id or false
     */
    public function update($update_data)
    {
        if (is_array($update_data[0]))
        {
        	$this->CI->db->update_batch($this->data['model_name'], $update_data,'id');
        	if($this->CI->db->affected_rows())
        	{
        		return  $update_data[0]['id']; 
        	}     
        }else{
        	$this->CI->db->update($this->data['model_name'], $update_data,'id');
			if($this->CI->db->affected_rows())
        	{
        		return  $update_data['id'];
        	}     	
        }
        return false;
    }
    /**
     * 删除一到多行数据
     * 
     * @access public
     * @param  id or ids
     * @return true or false
     */
	public function delete($ids){
		if(is_array($ids)){
			$arr_with_ids = $ids;
		}elseif(is_numeric($ids)){
			$arr_with_ids[0] = $ids;
		}else{
			return false;
		}
		//删除数据
		if ($arr_with_ids){
			$this->CI->db->where_in('id',$arr_with_ids);
			$this->CI->db->delete($this->data['model_name']);
		}
		if($this->CI->db->affected_rows()) return true;
		return false;	
	}
    /**
     * 获取数据行
     * 
     * @access public
     * @param  filter_order filter_query page per_page_n model_name
     * @return result_array or false
     */
    public function find_all($is_out=null)
    {
        //根据配置构建与其他表的关联
        $select_str = "";
        if(isset($this->data['config']['field_add'])){
            foreach($this->data['config']['field_add'] as $key=>$val){
                if(is_array($val['name'])){
                    $this->CI->db->join($val['name'][1],$this->data['model_name'].".".$val['name'][0]." = ".$val['name'][1].".".$val['name'][2]);
                    $select_str .= ",".$val['name'][1].".".$val['name'][3]." AS ".$val['name'][1]."_".$val['name'][3];
                }
            }
        }
        $this->CI->db->order_by($this->data['filter_order']);
        if(!empty($is_out)){
            $this->CI->db->limit($is_out['out_number'],$is_out['out_start']);
            $this->CI->db->select($is_out['out_fields']);
        }else{
            $this->CI->db->limit($this->data['per_page_n'],($this->data['page']-1)*$this->data['per_page_n']);
            $this->CI->db->select($this->data['model_name'].'.*'.$select_str);            
        }


		if($query = $this->CI->db->get_where($this->data['model_name'], $this->data['filter_query']))
		{
			return $query->result_array();
		}
		return false;
    }
    /**
     * 通过id获取一到多行数据
     * 
     * @access public
     * @param  id
     * @return result_array or false
     */
	public function get_by_ids($ids)
	{
	  if(is_array($ids)){
	  		$this->CI->db->where_in('id',$ids);
	  		$query = $this->CI->db->get($this->data['model_name']);
	  		return $query->result_array();
	  }elseif(is_numeric($ids)){
	  		$query = $this->CI->db->get_where($this->data['model_name'], array('id' => $ids));
	  		return $query->result_array();
	  }
	  return false;	  		
	}
    /**
     * 新建数据行时获取关联的数据
     * 
     * @access public
     * @param  
     * @return result_array or false
     */
    public function get_select($table,$fields,$where)
    {
      if(isset($table)&&isset($fields)){
            $this->CI->db->select($fields);
            if(!empty($where))  $this->CI->db->where($where);
            $query = $this->CI->db->get($table);
            return $query->result_array();
      }
      return false;         
    }
}

 /*End of file Commen_model.php */
 /* Location: ./application/libraries/Commen_model.php */
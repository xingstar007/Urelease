<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * hills-admin
 *
 * 
 * 
 *
 * @package		
 * @author		hillsdong@163.com
 * @copyright	Copyright (c) 2013 - 2013, hills.
 * @license		GNU General Public License 2.0
 * @link		
 * @version		0.1.0
 */
 
// ------------------------------------------------------------------------

/**
 * 
 *
 *	
 *
 * @package		
 * @subpackage	Controllers
 * @category	Back-controllers
 * @author		hillsdong@163.com
 * @link		
 */
class Main extends CI_Controller {
	 /**
     * 解析函数
     * 
     * @access public
     * @return void
     */
  	public function __construct()
  	{
    	parent::__construct();
    	//$this->load->model('source_model');
  	}
	/**
     * index
     * 
     * @access public
     * @param  void
     * @return void
     */
	public function index()
	{
        /** 页面初始化 */
        $data['page_title'] = "系统用户";
        $data['page_description'] = "页面描述";
        $data['page_keywords'] = "页面关键字";

        /*一些配置项*/
        $data['config'] = array(
            'chinese' => array( //中文翻译
                'ha_model_name' => "系统用户", //数据表名称
                'username' => '用户名', //字段名称
                'password' => '密码',
                'realname' => '真实姓名',
                'role' => '用户角色',
                'add_time' =>'注册时间',
                'login_time' => '登录次数',
                'last_login_time' => '最后登录时间',
                'phone_num' =>'电话号码',
                'img_dir' => '头像地址',
                'ip'=>'最后登录IP',
                ),
 //           'invisible' => array( //是否可见
 //               'ha_delete', //操作是否可见 添加，复制，编辑，删除，导出 分别对应 ha_new ha_copy ha_edie ha_delete ha_out
  //              'ip', //不可见字段
 //               ),
            /*
            'field_add'=>array( //添加其他字段
                'equip'=>array(
                    'title'=>'设备',
                    'name'=>'查看设备',
                    'a_title'=>'查看详情',
                    'a_state'=>'manage/equip',
                    'a_key'=>array('area_id','id'),
                    'a_blank'=>1,
                    ),
                ),
                */
            'field_tool' => array( //数据添加时的日历，图片上传等工具
                'ha_required'=>array('username','password','role'), //必选字段
                'password' => 'md5', //加密
                'add_time' => 'datetime', //日期选择
                'last_login_time' => 'datetime',
                'img_dir' => 'upload', //图片上传
                'role' => 'arr_select', //关联自定义配置数组
                'role_config' => array('ha_config','role','id','name'), //关联配置文件名，配置数组的key，提交值的key，显示值的key
                ),
            );
        $data['model_name'] = "user"; //设置数据表名称      
        $this->load->library('commen_model'); //导入类
        $this->commen_model->run($data); //执行
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * hills_admin
 *
 * 
 * 
 *
 * @package		DECDS
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
class ajax extends CI_Controller {
	 /**
     * 解析函数
     * 
     * @access public
     * @return void
     */
  	public function __construct()
  	{
    	parent::__construct();
  	}
	/**
     * index
     * 
     * @access public
     * @param  void
     * @return void
     */
    /**
     * get_md5_password
     * 
     * @access public
     * @param  void
     * @return void
     */
    public function get_md5_password()
    {
        if(isset($_POST['password'])&&strlen($_POST['password'])>5)
            echo md5($_POST['password'].'DECDS');
        else
            echo "";
    }
    public function get_file_dir()
    {   
        $file_dir = 'uploads/user_header/'.$_FILES['upload_file']['name'];
        if(!file_exists($file_dir))
            move_uploaded_file($_FILES['upload_file']['tmp_name'],iconv('utf-8','gb2312',$file_dir));
        //输出图片文件<img>标签
        echo "<textarea>".$file_dir."</textarea>";
    }
}

/* End of file ajax.php */
/* Location: ./application/controllers/ajax.php */
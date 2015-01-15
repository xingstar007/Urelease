<?php 
date_default_timezone_set('PRC');

class Discuz extends CI_Controller
{
	private $host = 'localhost';
	private $username = 'root';
	private $password = '123456';
	private $database_name = 'ultrax';
	private $_db = null;
	private $fid = null;
	private $title = null;
	private $content = null;
	private $author = null;
	private $author_id = null;
	private $current_time = null;
	private $displayorder = null; //0:正常，-2:待审核
	
	function __construct()
	{
		parent::__construct();
	
		$this->db = $this->load->database('discuz',true);
		$this->load->library('input');
		$this->load->helper('form');
		
		$this->load->helper('array');
	}
	
	
	function index($return = '提交结果')
	{
		$this->load->view('test',array('result' => $return));
	}
	
	function reply($return = '提交结果')
	{
		$this->load->view('test2',array('result' => $return));
	}
	
	
	
	public function post_posts() 
	{
		
		
		$this->fid = $this->input->post('fid');
		$this->title = $this->input->post('title');
		$this->content = $this->input->post('content');
		$this->author = $this->input->post('author');
		$this->author_id = $this->input->post('author_id');
		$this->current_time = time();
		$this->displayorder = $this->input->post('displayorder');
		
		$this->imgurl = $this->input->post('imgurl');
		$this->content = $this->content.'[img]'.$this->imgurl.'[/img]';
		
		$tid = $this->do_pre_forum_thread();
		if(!$tid)
		{
			$return = '更新表 pre_forum_thread 失败<br />';
		}
		$pid = $this->do_pre_forum_post_tableid();
		if(!$this->do_pre_forum_post($pid, $tid))
		{
			$return = '更新表 pre_forum_post 失败<br />';
		}
		if(!$this->do_pre_forum_forum())
		{
			$return = '更新表 pre_forum_forum 失败<br />';
		}
		if($this->displayorder == -2)
		{
			if(!($this->do_pre_forum_thread_moderate($tid)))
			{
				$return = '更新表 pre_forum_thread_moderate 失败<br />';
			}
		}
		if(!$this->do_pre_common_stat())
		{
			$return = '更新表 pre_common_stat 失败<br />';
		}
		if(!$this->do_pre_forum_newthread($tid))
		{
			$return = '更新表 pre_common_stat 失败<br />';
		}
		$return = ($this->do_pre_common_member_count()) ? '发帖成功<br />' : '更新表 pre_pre_common_member_count 失败<br />';
	
		$this-> index($return);
	}
	
	public function post_reply()
	{
		$this->tid = $this->input->post('tid');
		$this->fid = $this->input->post('fid');
		$this->content = $this->input->post('content');
		$this->author = $this->input->post('author');
		$this->author_id = $this->input->post('author_id');
		$this->current_time = time();
	
		$this->imgurl = $this->input->post('imgurl');
		$this->content = $this->content.'[img]'.$this->imgurl.'[/img]';
	
		$pid = $this->do_pre_forum_post_tableid();
		if(!$this->do_reply_pre_forum_post($pid, $this->tid))
		{
			$return = '更新表 pre_forum_post 失败<br />';
		}
		if(!$this->do_reply_pre_forum_thread())
		{
			$return = '更新表pre_forum_thread 失败<br />';
		}
		if(!$this->do_reply_pre_forum_forum())
		{
			$return = '更新表 pre_forum_forum 失败<br />';
		}
		if(!$this->do_reply_pre_common_stat())
		{
			$return = '更新表 pre_common_stat 失败<br />';
		}
		$return = ($this->do_reply_pre_common_member_count()) ? '回复成功<br />' : '更新表 pre_pre_common_member_count 失败<br />';
	
		$this-> reply($return);
	}
	
	
	
	
	private function do_pre_forum_thread()
	{
		$data = array();
		$data['fid'] = $this->fid;
		$data['author'] = $this->author;
		$data['authorid'] = $this->author_id;
		$data['subject'] = $this->title;
		$data['dateline'] = $this->current_time;
		$data['lastpost'] = $this->current_time;
		$data['lastposter'] = $this->author;
		$data['displayorder'] = $this->displayorder;
		
		$this->db->insert('pre_forum_thread', $data);
		$result = $this->db->affected_rows();
		if($result == 1)
		{
			$tid = $this->get_last_id();
		}
		return $tid;
	}
	
	private function do_pre_forum_post_tableid()
	{
		$sql = "INSERT INTO `pre_forum_post_tableid`(`pid`) VALUES(NULL)";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		if($result == 1)
		{
			$pid = $this->get_last_id();
		}
		return $pid;
	}
	
	private function do_pre_forum_post($pid, $tid)
	{
		$data = array();
		$data['pid'] = $pid;
		$data['fid'] = $this->fid;
		$data['tid'] = $tid;
		$data['first'] = 1;
		$data['author'] = $this->author;
		$data['authorid'] = $this->author_id;
		$data['subject'] = $this->title;
		$data['dateline'] = $this->current_time;
		$data['message'] = $this->content;
		
		$this->db->insert('pre_forum_post', $data);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_pre_forum_forum()
	{
		$sql = "UPDATE `pre_forum_forum` SET `threads`=threads+1,`posts`=posts+1,`todayposts`=todayposts+1 WHERE `fid`={$this->fid}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}

	private function do_pre_forum_thread_moderate($tid)
	{
		$data = array();
		$data['tid'] = $tid;
		$data['status'] = 0;
		$data['dateline'] = $this->current_time;
		$this->db->insert('pre_forum_thread_moderate', $data);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_pre_common_member_count()
	{
		$sql = "UPDATE `pre_common_member_count` SET `threads`=threads+1,`posts`=posts+1 WHERE `uid`={$this->author_id}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_pre_common_stat()
	{
		$daytime = date('Ymd',$this->current_time);
		$sql = "UPDATE `pre_common_stat` SET `thread`=thread+1 WHERE `daytime` = {$daytime} ";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_pre_forum_newthread($tid)
	{
		$data = array();
		$data['fid'] = $this->fid;
		$data['tid'] = $tid;
		$data['dateline'] = $this->current_time;
		$res = false;
		$this->db->insert('pre_forum_newthread', $data);
		$result = $this->db->affected_rows();
		if($result == 1)
		{
			$res = true;
		}
		return $res;
	}
	
	
	private function get_last_id()
	{
		$sql = "SELECT LAST_INSERT_ID()";
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result))
		{
			$id = $row['LAST_INSERT_ID()'];
		}
		return $id;
	}

	private function do_reply_pre_forum_thread()
	{
		$sql = "UPDATE `pre_forum_thread` SET `replies`=replies+1 WHERE `tid`={$this->tid}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_reply_pre_forum_forum(){
		$sql = "UPDATE `pre_forum_forum` SET `posts`=threads+1,`todayposts`=todayposts+1 WHERE `fid`={$this->fid}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
		
	}
	
	private function do_reply_pre_common_stat(){
		$daytime = date('Ymd',$this->current_time);
		$sql = "UPDATE `pre_common_stat` SET `post`=post+1 WHERE `daytime` = {$daytime} ";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_reply_pre_common_member_count(){
		$sql = "UPDATE `pre_common_member_count` SET `posts`=posts+1 WHERE `uid`={$this->author_id}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function do_reply_pre_forum_post($pid, $tid)
	{
		$data = array();
		$data['pid'] = $pid;
		$data['fid'] = $this->fid;
		$data['tid'] = $tid;
		$data['first'] = 0;
		$data['author'] = $this->author;
		$data['authorid'] = $this->author_id;
		$data['dateline'] = $this->current_time;
		$data['message'] = $this->content;
	
		$this->db->insert('pre_forum_post', $data);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
}

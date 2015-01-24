<?php 
date_default_timezone_set('PRC');

class Discuz extends CI_Controller
{
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
	
	function edit($return = '提交结果')
	{
		$this->load->view('test3',array('result' => $return));
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

		//在主题内容最后加上图片
		$this->imgurl = $this->input->post('imgurl');
		$this->content = $this->content.'[img]'.$this->imgurl.'[/img]';

		//获取tid
		$tid = $this->do_pre_forum_thread();
		if(!$tid)
		{
			$return = '更新表 pre_forum_thread 失败<br />';
		}
		//获取pid
		$pid = $this->do_pre_forum_post_tableid();
		
		//更新帖子主表
		if(!$this->do_pre_forum_post($pid, $tid))
		{
			$return = '更新表 pre_forum_post 失败<br />';
		}
		
		//更新论坛板块表的主题计数
		if(!$this->do_pre_forum_forum())
		{
			$return = '更新表 pre_forum_forum 失败<br />';
		}
		
		//如果设置帖子状态为未审核，需要添加到主题审核表中
		if($this->displayorder == -2)
		{
			if(!($this->do_pre_forum_thread_moderate($tid)))
			{
				$return = '更新表 pre_forum_thread_moderate 失败<br />';
			}
		}
		//更新趋势统计表的主题数量和帖子数量
		if(!$this->do_pre_common_stat())
		{
			$return = '更新表 pre_common_stat 失败<br />';
		}
		
		//更新最新主题表
		if(!$this->do_pre_forum_newthread($tid))
		{
			$return = '更新表 pre_common_stat 失败<br />';
		}
		
		//更新会员发帖数量
		$return = ($this->do_pre_common_member_count()) ? '发帖成功<br />' : '更新表 pre_pre_common_member_count 失败<br />';
// 		$this-> index($return);
		$this->load->view('test',array('result' => $return));
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
	
// 		$this-> reply($return);
		$this->load->view('test',array('result' => $return));
	}
	
	public function edit_post()
	{
		$isThread = $this->input->post('isthread');
		$this->pid = $this->input->post('pid');
		$this->fid = $this->input->post('fid');
		$this->content = $this->input->post('content');
		$this->title = $this->input->post('title');

		
		
		if($this->update_pre_forum_post($this->pid))
		{
			if($isThread){
				if($this->update_pre_forum_thread($this->get_tid($this->pid))){
					$return = '更新成功2';
				}else {
					$return = '更新失败2';
				}
			}else {
				$return = '更新成功'.$isThread;
			}
		}else {
			$return = '更新失败';
		}
		$this->load->view('test3',array('result' => $return));
	}
	
	private function get_tid($pid)
	{
		$sql = "SELECT tid FROM pre_forum_post WHERE pid = {$pid} ";
		$query = $this->db->query($sql);
		return $query->row()->tid;
	}
	
	
	private function update_pre_forum_thread($tid)
	{
		$subject = $this->title;
		$sql = "UPDATE `pre_forum_thread` SET `subject`= '{$subject}' WHERE `tid`= {$tid}";
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
	}
	
	private function update_pre_forum_post($pid)
	{
		$message = $this->content;
		if(is_null($this->title))
		{
			$sql = "UPDATE `pre_forum_post` SET `message`= '{$message}' WHERE `pid`= {$pid}";
		}else {
			$subject = $this->title;
			$sql = "UPDATE `pre_forum_post` SET `subject`= '{$subject}',`message`= '{$message}' WHERE `pid`= {$pid}";
		}
		$this->db->query($sql);
		$result = $this->db->affected_rows();
		return ($result == 1) ? true : false;
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
		$data['htmlon'] = 1;
		
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

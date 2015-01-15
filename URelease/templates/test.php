<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>Welcome to CodeIgniter!</h1>
	<div>
		<label>
			<?php 
				echo $result;
			?>
		</label>
	</div>
	<div id="body">
	
	<?php echo form_open('discuz/post_posts'); ?>
	<div>
	<?php
		echo form_label("fid 版块ID 比如 38 ");
		$fid = array(
				'id'	=>	'fid',
				'name'	=>	'fid',
				'maxlength'	=>	'100',
		);
		echo form_input($fid);
	?>
	</div>
	<div>
	<?php
		echo form_label("title 话题标题");
		$title = array(
				'id'	=>	'title',
				'name'	=>	'title',
				'maxlength'	=>	'100',
		);
		echo form_input($title);
	?>
	</div>
	<div>
	<?php
		echo form_label("content  话题内容");
		$content = array(
				'id'	=>	'content',
				'name'	=>	'content',
				'maxlength'	=>	'100',
		);
		echo form_input($content);
	?>
	</div>
	<div>
	<?php
		echo form_label("imgurl  图片URL");
		$imgurl = array(
				'id'	=>	'imgurl',
				'name'	=>	'imgurl',
				'maxlength'	=>	'100',
		);
		echo form_input($imgurl);
	?>
	</div>
	<div>
	<?php
		echo form_label("author 用户名 比如 test ");
		$author = array(
				'id'	=>	'author',
				'name'	=>	'author',
				'maxlength'	=>	'100',
		);
		echo form_input($author);
	?>
	</div>
	<div>
	<?php
		echo form_label("author_id 用户ID 比如 2 ");
		$author_id = array(
				'id'	=>	'author_id',
				'name'	=>	'author_id',
				'maxlength'	=>	'100',
		);
		echo form_input($author_id);
	?>
	</div>
	<div>
	<?php
		echo form_label("displayorder  帖子级别 -2 ~ 3  正常为0 ，板块置顶 为 1");
		$displayorder = array(
				'id'	=>	'displayorder',
				'name'	=>	'displayorder',
				'maxlength'	=>	'100',
		);
		echo form_input($displayorder);	
	?>
	<div>
		<button type="submit" name="project_id">提交</button>
	</div>
	</div>

</div>

</body>
</html>
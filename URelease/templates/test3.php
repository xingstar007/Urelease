<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
    <link href="<?php echo base_url().__TEMPLATES_FOLDER__ ?>css/bootstrap.min.css" rel="stylesheet">
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
	<h1>
		<input type="button" class="button" value="发表主题" onclick="location='./index'"/> 
		<input type="button" class="button" value="发表回复" onclick="location='./reply'"/>
		<input type="button" class="button" value="编辑主题/回复" onclick="location='./edit'"/>
	</h1>
	<div class="col-lg-12">
		<label> <?php  echo $result; ?> </label>
	</div>
		<?php echo form_open('discuz/edit_post'); ?>
	<div class="col-lg-12">
	<?php echo form_label("是否为主题"); 
		$isthread = array(
			'name'	=>	'isthread',
			'value'	=>	'1',
			'checked' =>	'checked',
		);
		echo form_checkbox($isthread);
	?>
	</div>
		<div class="col-lg-12">
	<?php
		echo form_label("pid 话题ID 比如18");
	?>
	</div>
	<div class="col-lg-12">
	<?php
		$pid = array(
				'id'	=>	'pid',
				'name'	=>	'pid',
				'maxlength'	=>	'100',
		);
		echo form_input($pid);
	?>
	</div>
	<div class="col-lg-12"> <?php echo form_label("title 话题标题"); ?> </div>
	<div class="col-lg-12">
	<?php
		$title = array(
				'id'	=>	'title',
				'name'	=>	'title',
				'maxlength'	=>	'100',
		);
		echo form_input($title);
	?>
	</div>
	<div class="col-lg-12">
	<?php echo form_label("content  话题内容"); ?>
	</div>
	<div class="col-lg-12">
	<?php
		$content = array(
				'id'	=>	'content',
				'name'	=>	'content',
		);
		echo form_input($content);
	?>
	</div>
	<div id = 'body'>
		<button type="submit" name="project_id">提交</button>
	</div>
	
</div>

</body>
</html>
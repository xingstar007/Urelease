<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>hills_admin&raquo; <?php echo $page_title;?></title>
	<meta name="Keywords" content="<?php echo $page_keywords;?>" />
	<meta name="Description" content="<?php echo $page_description;?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="<?php echo base_url().'templates/css/bootstrap.min.css';?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().'templates/css/bootstrap-responsive.min.css';?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url().'templates/css/hills-admin.css';?>" rel="stylesheet" type="text/css" />
	<!-- Bootstrap CSS fixes for IE6 -->
	<!--[if lt IE 7]><link rel="stylesheet" href="<?php echo base_url().'templates/css/bootstrap-ie6.min.css';?>"><![endif]-->
	<style type="text/css">

	</style>
	<script type="text/javascript" src="<?php echo base_url().'templates/js/jquery-1.9.1.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'templates/js/bootstrap.min.js';?>"></script>
</head>
<body>
<!--Main wrapper-->
<div id="ha-wrapper" class="fluid">
	<div id="ha-header">
		<div id="ha-header-top">
			<div class="ha-container clearfix">
				<div id="ha-logo-wrap">
					<div id="ha-logo">
						<div id="ha-logo-img">
							<a href="#">HILLS-ADMIN</a>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div id="ha-header-bottom">
			<div class="ha-container clearfix">
			<ul class="breadcrumb">
			  <li><a href="<?php echo site_url('main/index');?>">首页</a> <span class="divider">/</span></li>
			  <?php if(isset($nav_arr[$this->uri->rsegment(1)])){?>
			  <li><a href="<?php echo site_url($this->uri->rsegment(1).'/index');?>"><?php echo $nav_arr[$this->uri->rsegment(1)]['name'];?></a> <span class="divider">/</span></li>
			  <li class="active"><?php $now_nav=($this->uri->rsegment(2)=='index')?'首页':$nav_arr[$this->uri->rsegment(1)]['son'][$this->uri->rsegment(2)]; echo $now_nav;?></li>
			  <?php }?>
			</ul>
			</div>
		</div>		
	</div>
	<!--Main content-->
	<div id="ha-content">
		<!--Main container-->
		<div class="ha-container clearfix">
			<div id="ha-sidebar-separator"></div>
			<div id="ha-sidebar">
				<div id="ha-main-nav">
				导航
				</div>
			</div>
		
			<!--Main content-wrap-->
			<div id="ha-content-wrap" class="clearfix">
		


<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Widget {
	
	var $button;
	
	public function __construct()
	{
		log_message('debug', "Widget Class Initialized");
	}
	
	function version_button($data,$content)
	{
		$f = 'onClick = "enter_version('.$data.');"';
		$b = '<button type="button"'.$f.' class="btn btn-outline btn-default btn-xs">';
		$end = '</button>';
		return $b.$content.$end;
	}
	
	function delete_version($data,$content)
	{
		$v = 'value ='.$data;
		$b = '<button type="button"'.$v.' class="btn btn-outline btn-default btn-xs delete-version">';
		$end = '</button>';
		return $b.$content.$end;
	}
	
	function public_radio($type,$id,$bool)
	{
		if($bool)
		{
			$r = '<input class="publish-flag" name="'.$type.'" type="radio" value='.$id.' checked/>';
		}else {
			$r = '<input class="publish-flag" name="'.$type.'" type="radio" value='.$id.'/>';
		}
		return $r;
	}
	
}

	<h3>
		<?php if(isset($remove_re)){?>
			确定删除以下 <?php if(isset($config['chinese']['ha_model_name'])) echo $config['chinese']['ha_model_name']; else echo $model_name;?>？
		<?php }else{?>
			<?php if(isset($copy_re)){echo "复制";}elseif(isset($edit_re)){echo "编辑";}else{echo "添加";}?>
			<?php if(isset($config['chinese']['ha_model_name'])) echo $config['chinese']['ha_model_name']; else echo $model_name;?>
		<?php }?>
	</h3>
	<?php if(isset($copy_re)){ ?>	
		<p>现有数据仅供参看，不会覆盖原数据！</p>
	<?php } ?>
	<form action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
	
	<?php 
		if(isset($copy_re)) $get_re = $copy_re;
		if(isset($edit_re)) $get_re = $edit_re;
		if(isset($remove_re)) $get_re = $remove_re;
		if(isset($insert_n)){for($i=0;$i<$insert_n;$i++) $get_re[] = array();}
	?>
	<?php $upload_i=0; foreach($get_re as $get_key=>$get_item){ ?>
	<table class="table table-striped table-bordered table-hover table-condensed">
		<!--title-->
		<tr class="">
				<th class="">序号</th><th class="">字段</th><th class="">数据类型</th><th class="">值</th>
		</tr>
		<!--list-->
		
		<?php foreach($title_re as $key=>$item){ ?>
		<tr class="">
				<td class=""><?php echo $key+1;?></td>
				<td class="">
					<?php if($get_key == 0 && isset($config['chinese'][$item->name]))
								$title_re[$key]->chinese_name = $config['chinese'][$item->name];
							echo isset($item->chinese_name)?$item->chinese_name:$item->name;
					?>
						
				</td>	
				<td class="">
					<?php echo $item->type;?>[<?php echo $item->max_length;?>]
				</td>
				<td class="">
				<?php if((isset($edit_re) || isset($remove_re)) && $item->primary_key == 1){?>
					<input type="hidden"  name="<?php echo $item->name;?>[]" value="<?php if(isset($get_item[$item->name])) echo $get_item[$item->name]?>" />
					<input type="text" disabled name="<?php echo $item->name;?>[]" value="<?php if(isset($get_item[$item->name])) echo $get_item[$item->name]?>" />
				<?php }elseif($item->primary_key != 1){?>
					<?php 
						$input_val = isset($get_item[$item->name])?$get_item[$item->name]:"";
						$input_required = isset($config['field_tool']['ha_required'])&&in_array($item->name,$config['field_tool']['ha_required'])?"required":"";
						$input_str = '<input type="text" '.$input_required.'  name="'.$item->name.'[]" value="'.$input_val.'" />';
					?>
					<?php if(isset($config['field_tool'][$item->name])){
						switch ($config['field_tool'][$item->name]) {
							case 'md5':
								echo '<div class="input-append">';
								echo $input_str;
								echo "<input type='button' class='btn md5_btn' value='加密' />";
								echo '</div>';
								break;
							case 'datetime':
								echo '<div class="input-append date datetime">';
								echo $input_str;
								echo '<span class="add-on"><i class="icon-calendar"></i></span>';
								echo '</div>';
								break;	
							case 'upload':
								echo '<div class="input-append">';
								echo $input_str;
								echo "<input type='button' id='upload_".$upload_i++."' class='btn upload_btn' value='上传' />";
								echo '</div>';
								break;
							case 'select':
								echo '<select name="'.$item->name.'[]" >';
								$optino_val_key = $config['field_tool'][$item->name.'_config'][1];
								$optino_name_key = $config['field_tool'][$item->name.'_config'][2];
								foreach($select_re[$item->name] as $option_key=>$option_val){
									echo '<option value="'.$option_val[$optino_val_key].'">'.$option_val[$optino_name_key].'</option>';
								}
								echo '</select>';
								break;	
							case 'arr_select':
								echo '<select name="'.$item->name.'[]" >';
								$optino_val_key = $config['field_tool'][$item->name.'_config'][2];
								$optino_name_key = $config['field_tool'][$item->name.'_config'][3];
								foreach($select_re[$item->name] as $option_key=>$option_val){
									echo '<option value="'.$option_val[$optino_val_key].'">'.$option_val[$optino_name_key].'</option>';
								}
								echo '</select>';
								break;							
							default:
								echo $input_str;
								break;
						}
					}else{
						echo $input_str;	
					}?>
				<?php } ?>
				</td>		
		</tr>
		<?php } ?>
	</table>
	<?php } ?>
			<input type="hidden" name="arr_length" value="<?php echo count($get_re);?>" />
	
		<?php if(isset($copy_re)){ ?>
			<input type="submit" class="btn" name="submit_insert" value="复制"/>
		<?php }elseif(isset($edit_re)){ ?>
			<input type="submit" class="btn" name="submit_update" value="更新"/>
		<?php }elseif(isset($remove_re)){?>
			<input type="submit" class="btn" name="submit_remove" value="删除"/>
		<?php }else{ ?>
			<input type="submit" class="btn" name="submit_insert" value="添加"/>
		<?php } ?>
		<a  class="btn" href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>">取消</a>
	</form>
	<!-- md5加密 -->
	<script type="text/javascript">
	$('.md5_btn').click(function(){
		prev = $(this).prev('input');
		if(prev.val().length>5){
			$.ajax({
			   type: "POST",
			   url: "<?php echo site_url('ajax/get_md5_password');?>",
			   data: "password="+prev.val(),
			   success: function(data){
			     prev.val(data);
			   }
			});
		}else{
			alert('密码需大于6位');
		}
		return false;
	});
	</script>
	<!-- 图片上传 -->
	<form id="upload_form" method="post" class="hide" action="<?php echo site_url('ajax/get_file_dir');?>" target="upload_target" enctype="multipart/form-data">
	     <input type="file" name="upload_file" id="upload_file">        <!-- 添加上传文件 -->
	</form>
	<iframe id="upload_target" class="hide" name="upload_target"></iframe>
	<script type="text/javascript">
	$('.upload_btn').click(function(){
		$('#upload_file').attr('callback_id',$(this).attr('id'));
		$('#upload_file').click();
	});
    //选择文件成功则提交表单
	$("#upload_file").change(function(){
		if($("#upload_file").val() != '') $("#upload_form").submit();
		$('#'+$(this).attr('callback_id')).prev('input').val("上传中……");
	});
	//iframe加载响应，初始页面时也有一次，此时data为null。
	$("#upload_target").load(function(){
		var data = $(window.frames['upload_target'].document.body).find("textarea").html();
		//若iframe携带返回数据，则显示在feedback中
		if(data != null){
			$('#'+$('#upload_file').attr('callback_id')).prev('input').val(data);
			$("#upload_file").val('');
			$('#upload_file').attr('callback_id',"");
		}
	});
	</script>
	<!-- 日期选择 -->
	<link href="<?php echo base_url().'templates/css/bootstrap-datetimepicker.css';?>" rel="stylesheet" type="text/css" />

	<script type="text/javascript" src="<?php echo base_url().'templates/js/bootstrap-datetimepicker.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo base_url().'templates/js/bootstrap-datetimepicker.zh-CN.js';?>" charset="UTF-8"></script>
	<script type="text/javascript">
		$(".datetime").datetimepicker({
			format: 'yyyy-mm-dd hh:ii',
			autoclose: true,
			todayBtn: true,
			todayHighlight: true,
			minView: 0,
			forceParse:true,
		});
	</script>

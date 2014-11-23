<div class="row">
	<div class="col-lg-8">
    	<h1 class="page-header"><?php echo $page_title?></h1>
    </div>
	<div class="col-lg-4">
		<button type="button" class="btn btn-outline btn-default btn-lg btn-right-header create-version">新增版本</button>
	</div>
</div>
<!-- /.row -->
<div class="row edit-version" style = "display:none">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo validation_errors(); ?>
				<?php echo form_open_multipart('release/create_version_submit',array('id' => 'version_form')); ?>
				<div class="row">
					<div class="col-lg-2">
						<label>选择版本类型</label>
						<select name="version_type" class="form-control">
							<option value ="1">android</option>
							<option value ="2">IOS</option>
						</select>
					</div>
					<div class="col-lg-4">
						<label>版本号</label>
						<input name="version_name" class="form-control">
					</div>
					<div class="col-lg-4">
						<label>版本上传</label>
 						<input type="file" name="product" >
					</div>
					<div class="col-lg-2">
						<button id= "myForm2" type="submit" name="project_id" value="<?php  echo $project_id; ?>" class="btn btn-outline btn-default ">提交</button>
					</div>
				</div>
				</form>
			</div>
		</div>
		<!-- /.panel -->
	</div>
</div>
<!-- /.row -->                    
<div id="version_table">
	<?php echo $version_table;?>
</div>
<script type="text/javascript">
	$(document).ready(function() { 
    	var options = 
        	{ 
				target:			'#version_table',
				beforeSubmit:	showRequest,
				success:		showResponse,
				clearForm:		true
			}; 
		$("#version_form").ajaxForm(options);
		$("button.create-version").click(function() {
			$("div.edit-version").toggle(400);
		});
	});

	function showRequest(formData, jqForm, options) {
		var queryString = $.param(formData); 
		alert('About to submit: \n\n' + queryString); 
		return true; 
	} 
 
	function showResponse(responseText, statusText)  {
    	$("#version_table").html(responseText);
    	$("div.edit-version").hide(400);
	}
</script>
 

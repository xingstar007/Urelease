<?php  foreach ($version_table as $table){  ?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
  			<div class="panel-heading">
   				<?php echo $table['tittle']; ?>
			</div>
			<!-- /.panel-heading -->
 			<div class="panel-body">
				<div class="table-responsive">
					<?php echo $table['data']; ?>
				</div>
				<!-- /.table-responsive -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>
<!-- /.row -->
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".delete-version").click(function() {
			var $this = $(this)		
			$.ajax({
					type:"POST",
					url: "release/version_delete/",
					dataType:"json",
					data:{"del_version_id":$(this).val()},
					success:function(data){
						if(data>0){
							$this.parent().parent().remove();			
						}
						return false;
					},
					error:function(XMLHttpRequest){
						alert('error');
						alert(XMLHttpRequest.readyState);
						alert(XMLHttpRequest.status);
						return false;
					}
			});
		});	
	});
</script>
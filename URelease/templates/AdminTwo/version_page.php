<?php	if (!defined('BASEPATH')) {exit('Access Denied');}  
		include 'header.php';
?>

<body>

    <div id="wrapper">
    
		<?php include 'navigation.php';?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="page-header"><?php echo $page_title?></h1>
                </div>
                <div class="col-lg-4">
                    <button type="button" class="btn btn-outline btn-default btn-lg btn-right-header">Default</button>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        	<?php echo validation_errors(); ?>
							<?php echo form_open_multipart('release/create_version_submit'); ?>
                            <div class="row">
                                <div class="col-lg-2">
                                	<label>Selects</label>
                                    <select name="version_type" class="form-control">
                                    	<option value ="1">android</option>
                                        <option value ="2">IOS</option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                	<label>Text Input</label>
                                    <input name="version_name" class="form-control">
                                </div>
                                <div class="col-lg-4">
                                	<label>File input</label>
                                    <input type="file" name="product" >
                                </div>
                                <div class="col-lg-2">
                                	<button type="submit" name="project_id" value="<?php  echo $project_id; ?>" class="btn btn-outline btn-default ">Default</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->                    
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
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
</body>

<?php	include 'footer.php'; ?>
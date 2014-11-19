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
                <!-- /.col-lg-12 -->
            </div>
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
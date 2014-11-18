
<div class="ha-table-box clearfix">
	<h2 class="ha-table-title">
		<?php if(isset($config['chinese']['ha_model_name'])) echo $config['chinese']['ha_model_name']; else echo $model_name;?>
		<?php if(!isset($config['invisible'])||!in_array('ha_out',$config['invisible'])){?>
			<a href="#myModal" role="button" class="btn" data-toggle="modal">导出</a>
		<?php } ?>
		<?php if(!isset($config['invisible'])||!in_array('ha_new',$config['invisible'])){?>
		<form class="ha-table-title-right" action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
			<div class="input-prepend input-append">
			  <span class="add-on">添加</span>
			  <input class="input-mini" name="insert" type="text" value="1" />
			  <span class="add-on">行数据</span>
			  <button class="btn" type="submit">确定</button>
			</div>
		</form>
		<?php } ?>
	</h2>
	<div class="ha-table-header">
		<form class="pull-left form-search" action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
			<div class="input-append">
			    <input type="text" name="filter_content" class="span2 search-query" value="<?php if(isset($_SESSION[$model_name.'_filter_content'])) echo $_SESSION[$model_name.'_filter_content'];?>">
			    <button type="submit" class="btn">搜索</button>
			</div>
		</form>
		<form class="pull-right" action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
			<div class="input-prepend input-append">
			  <span class="add-on">每页显示</span>
			  <input class="input-mini" name="per_page_n" type="text" value="<?php echo $per_page_n;?>" />
			  <span class="add-on">行数据</span>
			  <button class="btn" type="submit">更新</button>
			</div>
		</form>
	</div>	
	<div class="ha-table-content">
		<form class="" action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
		<table class="table table-striped table-hover table-condensed table-bordered">
			<!--title-->
			<tr class="">
					<th class=""><input class="checkall" type="checkbox"/></th>
					<th class="">序号</th><th class="">操作</th>
				<?php foreach($title_re as $key=>$item){ ?>
					<?php if(!isset($config['invisible'])||!in_array($item->name,$config['invisible'])){?>
					<th class="">				
						<?php $order = ' ASC'; if(isset($_SESSION[$model_name.'_order'])&&$_SESSION[$model_name.'_order']== $item->name.' ASC') $order = ' DESC';?>
						<?php $icon=false; if(isset($_SESSION[$model_name.'_order'])&&($_SESSION[$model_name.'_order']== $item->name.' ASC'||$_SESSION[$model_name.'_order']== $item->name.' DESC')) $icon=true;?>
						<a title="<?php if($order==' DESC') echo '递减'; else echo '递增';?>" href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?order=<?php echo $item->name.$order;?>">
							<?php if(isset($config['chinese'][$item->name])) echo $config['chinese'][$item->name]; else echo $item->name;?>
							<?php if($icon){?>
								<i class="<?php if($order==' DESC') echo ' icon-chevron-up'; else echo ' icon-chevron-down';?>"></i>
							<?php }?>
						</a>
					</th>
					<?php } ?>	
				<?php } ?>
				<?php if(isset($config['field_add'])){?>
				<?php foreach($config['field_add'] as $key=>$item){ ?>
					<th class="">
							<?php echo $item['title'];?>
					</th>
				<?php } ?>	
				<?php } ?>	
			</tr>
			<!--list-->
			<?php if(!empty($find_re)){?>
				<?php foreach($find_re as $key=>$item){ ?>
				<tr i="" class=" <?php if(isset($run_re)&&$run_re===$item['id']) echo 'success';?>">
						<td class=""><input class="check_id" name="check_id[]" type="checkbox" value="<?php echo $item['id'];?>"/></td>
						<td class=""><?php echo $per_page_n*($page-1)+$key+1;?></td>
						<td class="">
						<?php if(!isset($config['invisible'])||!in_array('ha_copy',$config['invisible'])){?>	
							<a class="icon icon-plus" href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?copy=<?php echo $item['id'];?>" title="复制"></a>
						<?php }?>
						<?php if(!isset($config['invisible'])||!in_array('ha_edit',$config['invisible'])){?>
							<a class="icon icon-edit" href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?edit=<?php echo $item['id'];?>" title="编辑"></a>
						<?php }?>
						<?php if(!isset($config['invisible'])||!in_array('ha_delete',$config['invisible'])){?>
							<a class="icon icon-trash" href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?remove=<?php echo $item['id'];?>" title="删除"></a>
						<?php }?>
						</td>	
					<?php $i=1; foreach($item as $key2=>$item2){ 
							if($i>$item_title_n){break;} $i++;
						?>
						<?php if(!isset($config['invisible'])||!in_array($key2,$config['invisible'])){?>
							<td class="">
								<?php echo $item2;?>
							</td>
						<?php }?>
					<?php } ?>	
					<?php if(isset($config['field_add'])){?>
					<?php foreach($config['field_add'] as $key3=>$item3){ ?>
						<th class="">
							<?php if(isset($item3['a_state'])){?>
								<?php $a_key_str = ""; if(isset($item3['a_key'])){$a_key_str = "?filter_a=1&".$item3['a_key'][0]."=".$item[$item3['a_key'][1]];}?>
								<a href="<?php echo site_url($item3['a_state']).$a_key_str;?>" target="<?php echo isset($item3['a_title'])&&$item3['a_title']?"_blank":"";?>" title="<?php echo isset($item3['a_title'])?$item3['a_title']:"";?>">
							<?php }?>
								<?php if(is_array($item3['name'])) echo $item[$item3['name'][1]."_".$item3['name'][3]]; else echo $item3['name'];?>
							<?php if(isset($item3['a_state'])){?>
								</a>
							<?php } ?>
						</th>
					<?php } ?>	
					<?php } ?>	
				</tr>
				<?php } ?>
			<?php }else{?>
				<tr class="warning" ><td colspan="<?php echo $item_title_n+3;?>">暂无内容！</td></tr>
			<?php } ?>
		</table>
		
		<?php if($count_all/$per_page_n>1){?>
		<div class="pagination pull-right">
		  <ul>
		  	<?php if($page!=1){?>
		  		<li class=""><a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?page=1" >&laquo;</a></li>
		   	 	<li class=""><a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?page=<?php echo $page-1;?>" >&lsaquo;</a></li>
		  	<?php } ?>
		    <?php for($i=0;$i<$count_all/$per_page_n;$i++){?>
		    	<li class="<?php if($i+1==$page) echo'active';?>"><a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?page=<?php echo $i+1;?>" ><?php echo $i+1;?></a></li>
		    <?php } ?>
		    <?php if($page!=$i){?>
		    	<li class=""><a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?page=<?php echo $page+1;?>" >&rsaquo;</a></li>
		   	 	<li class=""><a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?page=<?php echo $i;?>" >&raquo;</a></li>
		  	<?php } ?>
		  </ul>
		</div>
		<?php } ?>
		<div class="">
		<?php if(!isset($config['invisible'])||!in_array('ha_copy',$config['invisible'])){?>	
			<input type="submit" name="copy" class="btn" value="批量复制" />
		<?php } ?>
		<?php if(!isset($config['invisible'])||!in_array('ha_edit',$config['invisible'])){?>
			<input type="submit" name="edit" class="btn" value="批量编辑" />
		<?php } ?>
		<?php if(!isset($config['invisible'])||!in_array('ha_delete',$config['invisible'])){?>
			<input type="submit" name="remove" class="btn" value="批量删除" />
		<?php } ?>
		</div>
		</form>
	</div>	

	<div class="ha-table-footer">

		<p>
			<?php if($count_all>0){?>					
			<?php echo ($per_page_n*($page-1)+1).'-'.($per_page_n*($page-1)+$key+1).'条/'.$count_all.'条'?>
			<?php } ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isset($_SESSION[$model_name.'_order'])){?>
				排序：<span class="label label-info"><?php echo $_SESSION[$model_name.'_order'];?></span> <a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?order_clear=1">清除排序</a>
			<?php } ?>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<?php if(isset($_SESSION[$model_name.'_filter_content'])){?>
				搜索：<span class="label label-info"><?php echo $_SESSION[$model_name.'_filter_content'];?></span> <a href="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>?filter_query_clear=1">清除搜索条件</a>
			<?php } ?>
		</p>
		
		
	</div>
	

</div>
<?php if(!isset($config['invisible'])||!in_array('ha_out',$config['invisible'])){?>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form class="form-horizontal" target="_blank" action="<?php echo site_url($this->uri->rsegment(1).'/'.$this->uri->rsegment(2));?>" method="POST">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="registerLabel">EXCEL导出</h3>
  </div>
  <div class="modal-body">
     <label>导出字段：</label>
     <label class="checkbox inline">
     	<input class="checkall_field" type="checkbox" checked />所有
     </label>
	 <?php foreach($title_re as $key=>$item){
	 	if(!isset($config['invisible'])||!in_array($item->name,$config['invisible'])){ 
	 		echo '<label class="checkbox inline">';
	 		echo  '<input class="check_field" name="check_field[]" checked type="checkbox" value="'.$item->name.'"/>';
			if(isset($config['chinese'][$item->name])) echo $config['chinese'][$item->name]; else echo $item->name; 
			echo '</label>';
		}
	} ?> 
	<hr >
	<label>导出范围：</label>
	<input class="input-mini" min="0" max="<?php echo $count_all;?>" name="out_start" type="number" value="1" />-
	<input class="input-mini" min="0" max="<?php echo $count_all;?>" name="out_end" type="number" value="<?php echo $count_all;?>" />条
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <input type="submit" name="excel_out" class="btn btn-primary" value="确定">
  </div>
  </form>
</div>
<?php } ?>
<script>
	$('.checkall').click(function(){
		if(this.checked){ 
			$("input.check_id").each(function(){this.checked=true;}); 
		}else{
			$("input.check_id").each(function(){this.checked=false;}); 
		} 
	});
	$('.checkall_field').click(function(){
		if(this.checked){ 
			$("input.check_field").each(function(){this.checked=true;}); 
		}else{
			$("input.check_field").each(function(){this.checked=false;}); 
		} 
	});
</script>
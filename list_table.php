<?php
	$table_row_total=0;
	$table_unavaliable_row_total=0;
	while($row_result = mysql_fetch_assoc($result)){
		$test_query = "SELECT * FROM `".$row_result["fBarcode"]."` ORDER BY `tID` DESC LIMIT 1";
		$test_query_result = mysql_query($test_query);
		$test_query_rowresult = @mysql_fetch_assoc($test_query_result);
		$unavaliable = ( $test_query_rowresult["tReturnTime"]=="" || $test_query_rowresult["tReturnTime"]=="0" );
		$table_unavaliable_row_total = ($unavaliable) ? $table_unavaliable_row_total+1 : $table_unavaliable_row_total ;
		$table[$table_row_total]['unavaliable']=$unavaliable;
		$table[$table_row_total]['fBarcode']=$row_result["fBarcode"];
		$table[$table_row_total]['fName']=$row_result["fName"];
		$table[$table_row_total]['fDesc']=$row_result["fDesc"];
		$sql_item_query = "SELECT * FROM `".$row_result["fBarcode"]."`\n" . "ORDER BY `".$row_result["fBarcode"]."`.`tID` DESC\n" . "LIMIT 1";
		$row_item_result = mysql_fetch_assoc(mysql_query($sql_item_query));
		$table[$table_row_total]['tBorrower']=$row_item_result["tBorrower"];
		$table[$table_row_total]['tUssage']=$row_item_result["tUssage"];
		$table_row_total=$table_row_total+1;
	}
?>

<div class="row">
	<div class="col-xs-6">
		<small>目前外借 <?php echo $table_unavaliable_row_total;?> 筆</small>
	</div>
	<div class="col-xs-6 " align="right">
		<small>共 <?php echo $table_row_total;?> 筆</small>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<table class='table table-bordered table-hover'> 
			<thead><tr>
				<th class='col-sm-1 text-center'>#</th> <th class='col-sm-2'>名稱</th><th class='col-sm-3 hidden-xs'>描述</th><th class='col-sm-3'>狀態</th><th class='col-sm-3'>操作</th>
			</thead></tr>
<?php			for ($i=0; $i < $table_row_total; $i++) { ?>
					
					<?php 
					$row_num=$i+1;
					if ($table[$i]['unavaliable']) {
						echo "<tr class=danger > <th scope='row' class='text-center'>".$row_num."</th>";
					}else{
						echo "<tr> <th scope='row' class='text-center'>".$row_num."</th>";
					}?>
					<td><a href='item.php?id=<?php echo $table[$i]['fBarcode'];?>'><?php echo $table[$i]['fName'];?></a></td>

					<td class='hidden-xs'><?php echo $table[$i]['fDesc'];?></td>
					<?php 
					if (!$table[$i]['unavaliable']) {
						echo "<td><span class='label label-success'>可借用</span></td>";
					} else {
						echo "<td><span class='label label-default'>".$table[$i]['tBorrower']." 使用於 ".$table[$i]['tUssage']."</span></td>";
					}?>
					<td>
						<div class='btn-toolbar' role='toolbar'>
							<div class='btn-group' role='group'>
								<?php
								if ($table[$i]['unavaliable']){
									echo "<a class='btn btn-xs btn-success' href='return.php?id=".$table[$i]['fBarcode']."&fName=".$table[$i]['fName']."'><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> 歸還</a>";
								}else{
									echo "<a class='btn btn-xs btn-default disabled' ><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> 歸還</a>";
								}?>
								<button type='button' class='btn btn-default btn-xs' data-toggle='modal' data-target='.<?php echo $table[$i]['fBarcode'];?>'><span class='glyphicon glyphicon-option-horizontal' aria-hidden='true'></span> 紀錄</button>
								<div class='modal fade <?php echo $table[$i]['fBarcode'];?>' tabindex='-1' role='dialog' aria-labelledby='myLargeModalLabel' aria-hidden='true'>
									<div class='modal-dialog modal-lg'>
										<div class='modal-content'>
											<div class="modal-header">
											    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											    <h3 class="modal-title"><?php echo $table[$i]['fName'];?></h3>
											</div>
											<div class="modal-body">
											    <p>
											    <?php show_record_table($table[$i]['fBarcode']); ?>
											    </p>
											</div>
											<div class="modal-footer">
											    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class='btn-group hidden-xs' role='group'>
								<a class='btn btn-xs btn-default' href='facility_modify.php?id=<?php echo $table[$i]['fBarcode'];?>'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span> 修改</a>
								<a class='btn btn-xs btn-default' href='facility_remove.php?id=<?php echo $table[$i]['fBarcode'];?>'><span class='glyphicon glyphicon-trash' aria-hidden='true'></span> 刪除</a>
							</div>
							<!-- &nbsp;<span class='glyphicon glyphicon-barcode' aria-hidden='true'></span>";  -->
						</div>
					</td>
					</tr>
<?php 			} ?>
		</table>
	</div>
</div>
<?php
	require_once("ta_connMysql.php");
	if (isset($_GET["search"]))
	{
		$_GET["search"]=trim($_GET["search"]);
		$sql_query = "SELECT * FROM `facility` WHERE `fBarcode` = '".$_GET['search']."'";
		$total_records = mysql_num_rows(mysql_query($sql_query));
		if ($total_records==1) 
		{
			$redirect='Location:item.php?id='.$_GET['search'];
			//echo $redirect;
			header($redirect);
			exit();
			$title = "搜尋包含「".$_GET['search']."」的名稱";
		} 
		else 
		{		
			$sql_query = "SELECT * FROM `facility` WHERE `fName` LIKE '%".$_GET['search']."%' ORDER BY `facility`.`fName` ASC";
			$result = mysql_query($sql_query);

			$title = "搜尋包含「".$_GET['search']."」的名稱";
		}
	}
	else
	{
		$sql_query = "SELECT * FROM `facility` ORDER BY `facility`.`fName` ASC";	
		$result = mysql_query($sql_query);

		$title = "器材列表";
	}
	require("modules/header.php"); 
?>
<!-- <body> -->
<div class="row">
	<div class="col-sm-2 ">
		<p><a href="borrow.php" class="btn btn-warning" role="button"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> 借東西</a></p>
	</div>
	<div class="col-sm-6 col-sm-offset-1  col-xs-10 col-xs-offset-1">
	 	<form class="form-search pull-left" action="" method="get">
			<div class="input-group" >
				<input type="text" class="form-control" placeholder="i.e. 相機" name='search' autofocus>
				<span class="input-group-btn">
			     	<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> 搜尋</button>
				</span>
			</div>
			<div class='text-center'><?php show_recently_lookup();?></div>
		</form>
	</div>
	<div class="col-sm-3" >
	</div>
</div>



<p></p>

<?php require("list_table.php"); ?>


<div class="row">
	<div class="col-sm-2 col-sm-offset-1  col-xs-6 col-xs-offset-3">
		<p align='center'><a class="btn btn-default btn-block" href='facility_add.php'><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 新增器材</a></p>
	</div>
	<div class="col-sm-2 col-sm-offset-1 col-xs-6 col-xs-offset-3">
		<p align='center'><a class="btn btn-default btn-block" target='_blank' href='barcode_output.php'><span class="glyphicon glyphicon-barcode" aria-hidden="true"></span> 所有條碼</a></p>
	</div>
	<div class="col-sm-4 col-sm-offset-1 col-xs-12" align="center">
		<small><abbr title='這是TAshare的容量喔 (啾咪>.^)~'>磁碟空間</abbr></small>
		<?php show_disk_ussage("D:");?>
	</div>
</div>
<!-- </body> -->
<?php require('modules/footer.php');?>





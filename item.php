<?php
	require("ta_connMysql.php");
	$sql_db = "SELECT * FROM `".$_GET["id"]."` ORDER BY `tID` DESC";
	$result = mysql_query($sql_db);
	
	$sql_item_query = "SELECT * FROM `facility` WHERE fBarcode = '".$_GET["id"]."'";
	$item_rowresult = mysql_fetch_assoc(mysql_query($sql_item_query));
	
	$title = $item_rowresult["fName"]." 借用記錄";
	require("modules/header.php"); ?>

<!-- <body> -->	

<div class="row">
	<div class="col-sm-8">
		<p><a class="btn btn-primary" href="index.php">回器材列表</a></p>
	</div>
<?php 
	$test_query = "SELECT * FROM `".$_GET["id"]."` ORDER BY `tID` DESC LIMIT 1";
	$test_query_result = mysql_query($test_query);
	$test_query_rowresult = @mysql_fetch_assoc($test_query_result);
	$unavaliable = ( $test_query_rowresult["tReturnTime"]=="" || $test_query_rowresult["tReturnTime"]=="0" );?>
<?php if (!$unavaliable){ ?>
	<div class="col-sm-2">
		<p><a class="btn btn-warning btn-block" href="borrow.php?id=<?php echo $_GET["id"];?>"><span class="glyphicon glyphicon-list" aria-hidden="true"></span> 借 </a></p>
	</div>
	<div class="col-sm-2">
		<p><a class="btn btn-default btn-block disabled" href=""><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> 還 </a></p>
	</div>
<?php }else{ ?>
	<div class="col-sm-2">
		<p><a class="btn btn-default btn-block disabled" href=""><span class="glyphicon glyphicon-list" aria-hidden="true"></span> 借 </a></p>
	</div>
	<div class="col-sm-2">
		<p><a class="btn btn-success btn-block" href="return.php?id=<?php echo $_GET["id"];?>&fName=<?php echo $item_rowresult["fName"];?>&quick=1"><span class='glyphicon glyphicon-repeat' aria-hidden='true'></span> 還 </a></p>
	</div>
<?php } ?>
</div>


<div class="row">
	<div class="col-sm-5 col-sm-offset-1 col-xs-5 col-xs-offset-1">
		<h4>敘述</h4>
		<p><?php echo $item_rowresult["fDesc"]; ?></p>
	</div>
	<div class="col-sm-6 hidden-xs" >
		<h4>條碼</h4>
		<p>
			<?php echo " <code>".$_GET["id"]."</code>";?><br>
			<?php echo "<img src='http://barcode.tec-it.com/barcode.ashx?code=Code128&modulewidth=fit&data=".$_GET["id"]."'' alt='".$_GET["id"]."'/>";?>
		</p>
	</div>
</div>


<div class="row">
	<div class="col-sm-5 col-sm-offset-1 col-xs-5 col-xs-offset-1">
		<h4>記錄</h4>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<?php show_record_table($_GET["id"]); ?>

		<p class="text-center"><a href="#title" id="bottom">go to top</a></p>
	</div>
</div>

<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->





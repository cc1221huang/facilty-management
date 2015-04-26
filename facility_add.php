<?php $title = "新增器材資料";?>
<?php
require_once("ta_connMysql.php");
if (isset($_POST["action"])&&($_POST["action"]=="add"))
{
	$_POST["fName"]=delete_special_mark($_POST["fName"]);
	$_POST["fDesc"]=delete_special_mark($_POST["fDesc"]);
	$_POST["fBarcode"]=delete_special_mark($_POST["fBarcode"]);
	$_POST["fBarcode"]=trim($_POST["fBarcode"]);
	if(($_POST["fName"]!="")
		// &&($_POST["fDesc"]!="")
		&&($_POST["fBarcode"]!=""))
	{
		// new a facility row
		$sql_query = "INSERT INTO `facility`(`fName`, `fBarcode`, `fDesc`) VALUES (";
		$sql_query .= "'".$_POST["fName"]."', ";
		$sql_query .= "'".$_POST["fBarcode"]."',";
		$sql_query .= "'".$_POST["fDesc"]."')";
		echo $sql_query ."<br>";
		mysql_query($sql_query);
		// new a barcode table
		$sql_addItem_query = "CREATE TABLE `".$_POST["fBarcode"]."` ( ";
		$sql_addItem_query .= "`tID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,";
		$sql_addItem_query .= "`tBorrower` text CHARACTER SET UTF8 collate utf8_unicode_ci ,";
		$sql_addItem_query .= "`tUssage` text CHARACTER SET UTF8 collate utf8_unicode_ci,";
		$sql_addItem_query .= "`tBorrowTime` INT(10),";
		$sql_addItem_query .= "`tReturnTime` INT(10),";
		$sql_addItem_query .= "`tBorrowTA` text CHARACTER SET UTF8 collate utf8_unicode_ci,";
		$sql_addItem_query .= "`tReturnTA` text CHARACTER SET UTF8 collate utf8_unicode_ci,";
		$sql_addItem_query .= "`tDesc` text CHARACTER SET UTF8 collate utf8_unicode_ci,";
		$sql_addItem_query .= "`tBorrowIP` CHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,";
		$sql_addItem_query .= "`tReturnIP` CHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL);";
		echo $sql_addItem_query."<br>";
		mysql_query($sql_addItem_query);
		// add an initial row
		$sql_itemInit_query = "INSERT INTO `manage`.`".$_POST["fBarcode"]."` (`tID`, `tBorrower`, `tUssage`, `tBorrowTime`, `tReturnTime`, `tBorrowTA`, `tReturnTA`, `tDesc`) VALUES ('1', '---', '---', ".time().", ".time().", '---', '---', '現在新增一筆設備');";
		echo $sql_itemInit_query;
		mysql_query($sql_itemInit_query);
		
		logging_query($sql_itemInit_query);
		logging_query($sql_addItem_query);
		logging_query($sql_query);
		
		header("Location: index.php");
		exit();
	}else{
		// echo "資料不全或錯誤";
		$err = true;
	}
}?>

<?php require("modules/header.php");?>
<!-- <body> -->
<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
<?php 
if (isset($err) && $err) {
echo "
	<div class='alert alert-danger' role='alert'>
	<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
	</button>
	資料不全或錯誤!
	</div>";
} ?>

<form class="form-horizontal" action="" method="post" name="formAdd">
	<div class="form-group">
		<label class="col-sm-2 control-label">名稱*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="fName" autofocus>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">敘述</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="fDesc" >
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label">條碼*</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="fBarcode"  placeholder="(英數)">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<span class="help-block">*不可為空 不能含有英文單雙引號</span>
			<input name="action" type="hidden" value="add">
			<input class="btn btn-default" type="reset" name="button2" value="重填">
			<input class="btn btn-primary" type="submit" name="button" value="新增">
		</div>
	</div>
</form>

	</div>
</div>

<!-- </body> -->
<?php require("modules/footer.php");?>
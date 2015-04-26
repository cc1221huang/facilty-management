<?php 
require_once("ta_connMysql.php");
if (isset($_POST["action"]) &&($_POST["action"]=="borrow"))
{
	$_POST["tBorrower"]=delete_special_mark($_POST["tBorrower"]);
	$_POST["tUssage"]=delete_special_mark($_POST["tUssage"]);
	$_POST["tBorrowTA"]=delete_special_mark($_POST["tBorrowTA"]);
	$_POST["tDesc"]=delete_special_mark($_POST["tDesc"]);
	if(($_POST["tBarcode"]!="") &&($_POST["tBorrower"]!="") &&($_POST["tUssage"]!="") &&($_POST["tBorrowTA"]!=""))
	{
		$test_query = "SELECT * FROM `".$_POST["tBarcode"]."` ORDER BY `tID` DESC LIMIT 1";
		$test_query_result = mysql_query($test_query);
		$test_query_rowresult = mysql_fetch_assoc($test_query_result);
		if (is_null($test_query_rowresult["tReturnTime"])) { 
			// echo "物品條碼[".$_POST["tBarcode"]."]不存在資料庫內或已外借";
			$err=1; $errBarcode=$_POST["tBarcode"];
		}else{
			$php_unix_timestamp_borrow = strtotime( $_POST["tBorrowTime"] );
			$sql_query = "INSERT INTO `".$_POST["tBarcode"]."` ";
			$sql_query .= "(`tBorrower` ,`tUssage` ,`tBorrowTime` ,`tBorrowTA` ,`tDesc` ,`tBorrowIP`) VALUES (";
			$sql_query .= "'".$_POST["tBorrower"]."',";
			$sql_query .= "'".$_POST["tUssage"]."',";
			$sql_query .= "'".$php_unix_timestamp_borrow."',";
			$sql_query .= "'".$_POST["tBorrowTA"]."',";
			$sql_query .= "'".$_POST["tDesc"]."',";
			$sql_query .= "'".GetIP()."')" ;
			$tbchk = mysql_query($sql_query);
			logging_query($sql_query);
			if ($tbchk) {
				header("Location: item.php?id=".$_POST["tBarcode"]);
				exit();
			} else {
				// echo "物品條碼不存在資料庫內";
				$err=1;
			}
		}
	}else{
		// echo "資料不全或錯誤";
		$err=2;
	}
}

if(isset($_GET["id"])) {
	$quick=$_GET["id"];
}else{
	$quick=NULL;
}

$title = "借用表格";
require("modules/header.php");
?>

<!-- <body> -->
	<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<?php 
		if (isset($err)) {
			if ($err==1) {
				echo "
				<div class='alert alert-danger' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				    物品條碼[".$_POST["tBarcode"]."]不存在資料庫內或已外借
				</div>";
			} else if ($err==2){
				echo "
				<div class='alert alert-danger' role='alert'>
				<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
					<span aria-hidden='true'>&times;</span>
				</button>
				資料不全或錯誤!
				</div>";
			}
		}
		?>
		<form class="form-horizontal" action="" method="post" name="formBorrow">
			<div class="form-group">
				<label class="col-sm-2 control-label">借用人*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tBorrower" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">用途*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tUssage" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">借出時間</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tBorrowTime" value="<?php echo date("Y/m/d H:i:s");?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">借出值班TA*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tBorrowTA" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">備註</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tDesc" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">條碼*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tBarcode" value='<?php echo $quick;?>'>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<span id="helpBlock" class="help-block">*不可為空 不能含有英文單雙引號</span>
					<input name="action" type="hidden" value="borrow">
					<input class="btn btn-default" type="reset" name="button2" id="button2" value="重填">
					<input class="btn btn-primary" type="submit" name="button" id="button" value="借用">
				</div>
				<div class="col-sm-offset-2 col-sm-10 text-right">
					<!-- <small>IP:<?php echo GetIP(); ?></small> -->
				</div>
			</div>
		</form>
	</div>
</div>

<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->
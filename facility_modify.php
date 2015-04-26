<?php
require_once("ta_connMysql.php");
if (isset($_POST["action"])&&($_POST["action"]=="modify")) 
{
	$_POST["fName"]=delete_special_mark($_POST["fName"]);
	$_POST["fDesc"]=delete_special_mark($_POST["fDesc"]);
	$sql_query = "UPDATE `facility` SET ";
	$sql_query .= "`fName`='".$_POST["fName"]."',";
	$sql_query .= "`fDesc`='".$_POST["fDesc"]."' ";
	// $sql_query .= "`fBarcode`='".$_POST["fBarcode"]."' ";
	$sql_query .= "WHERE `fBarcode`='".$_POST["fBarcode"]."'";
	echo $sql_query;
	mysql_query($sql_query);
	logging_query($sql_query);
	header("Location: index.php");
	exit();
}
$sql_db = "SELECT * FROM `facility` where `fBarcode`='".$_GET["id"]."'";
$result = mysql_query($sql_db);
$row_result=mysql_fetch_assoc($result);
?>

<?php $title = "修改器材資料";?>
<?php require("modules/header.php");?>
<!-- <body> -->	
<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>
<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form class="form-horizontal" action="" method="post" name="formModify" >
			<div class="form-group">
				<label class="col-sm-2 control-label">名稱*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="fName" value="<?php echo $row_result["fName"]; ?>" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">敘述</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="fDesc" value="<?php echo $row_result["fDesc"]; ?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">條碼*</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="fBarcode"  placeholder="(英數)" value="<?php echo $row_result["fBarcode"]; ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<span class="help-block">*不可為空 不能含有英文單雙引號</span>
					<input name="action" type="hidden" value="modify">
					<input name="fBarcode" type="hidden" value="<?php echo $row_result["fBarcode"];?>">
					<input class="btn btn-default" type="reset" name="button2" value="重填">
					<input class="btn btn-primary" type="submit" name="button" value="修改">
				</div>
			</div>
		</form>
	</div>
</div>
<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->
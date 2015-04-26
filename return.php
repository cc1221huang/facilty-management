<?php $title = "器材歸還";?>
<?php
require_once("ta_connMysql.php");
if (isset($_POST["action"])&&($_POST["action"]=="return")) 
{
	$_POST["tReturnTA"]=delete_special_mark($_POST["tReturnTA"]);
	$_POST["tDesc"]=delete_special_mark($_POST["tDesc"]);
	if ($_POST["tReturnTime"]!="" && $_POST["tReturnTA"]!="" && $_POST["tBarcode"]!="") 
	{
		$php_unix_timestamp_borrow = strtotime( $_POST["tBorrowTime"] );
		$php_unix_timestamp_return = strtotime( $_POST["tReturnTime"] );
		$sql_query = "UPDATE `".$_POST["tBarcode"]."` SET ";
		$sql_query .= "`tBorrower`='".$_POST["tBorrower"]."',";
		$sql_query .= "`tUssage`='".$_POST["tUssage"]."',";
		$sql_query .= "`tReturnTime`='".$php_unix_timestamp_return."',";
		$sql_query .= "`tReturnTA`='".$_POST["tReturnTA"]."',";
		$sql_query .= "`tBorrowTime`='".$php_unix_timestamp_borrow."',";
		$sql_query .= "`tBorrowTA`='".$_POST["tBorrowTA"]."' ,";
		$sql_query .= "`tDesc`='".$_POST["tDesc"]."' ,";
		$sql_query .= "`tReturnIP`='".GetIP()."' ";
		$sql_query .= "WHERE `tID`='".$_POST["tID"]."'";
		echo $sql_query."<br>";
		logging_query($sql_query);
		$tbchk = mysql_query($sql_query);
		if ($tbchk) {
			header("Location: index.php");
			exit();
		} else {
			// echo "物品條碼不存在資料庫內";
			$err=1;
		}
	}
	else
	{
		$err=2;
	}
}
$sql_db = "SELECT * FROM `".$_GET["id"]."` order by `tID` desc limit 1";
$result = mysql_query($sql_db);
$row_result=mysql_fetch_assoc($result);
if(isset($_GET["quick"]) && $_GET["quick"]=1)
{
	$quick=$_GET["id"];
}
else
{
	$quick=NULL;
}
?>

<?php require("modules/header.php");?>
<!-- <body> -->	
<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>
<?php if (isset($err) && $err==1) {
	echo "
	<div class='bs-docs-example'>
	  <div class='alert alert-error fade in'>
	    <button type='button' class='close' data-dismiss='alert'>×</button>
	    <strong>物品條碼不存在資料庫內!</strong>
	  </div>
	</div>
	"; 
}else if(isset($err) && $err==2){
	echo "
	<div class='bs-docs-example'>
	  <div class='alert alert-error fade in'>
	    <button type='button' class='close' data-dismiss='alert'>×</button>
	    <strong>有空格!</strong>
	  </div>
	</div>
	"; 
}
?>
<code><?php echo "借用記錄序號:".$row_result["tID"];?></code>

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
		<form class="form-horizontal" action="" method="post" name="formReturn">
			<div class="form-group">
				<label class="col-sm-2 control-label">借用人</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tBorrower" value="<?php echo $row_result["tBorrower"]; ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">用途</label>
				<div class="col-sm-10">
					<input type="text" name="tUssage" class="form-control" value="<?php echo $row_result["tUssage"]; ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">借出時間</label>
				<div class="col-sm-10">
					<input type="text" name="tBorrowTime" class="form-control" value="<?php echo date("Y/m/d H:i:s", $row_result["tBorrowTime"]); ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">借出值班TA</label>
				<div class="col-sm-10">
					<input type="text" name="tBorrowTA" class="form-control" value="<?php echo $row_result["tBorrowTA"]; ?>" readonly>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">歸還時間</label>
				<div class="col-sm-10">
					<input type="text" name="tReturnTime" class="form-control" value="<?php echo date("Y/m/d H:i:s");?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">歸還值班TA*</label>
				<div class="col-sm-10">
					<input type="text" name="tReturnTA" class="form-control" autofocus >
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">備註</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="tDesc" value="<?php echo $row_result["tDesc"]?>">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label">條碼*</label>
				<div class="col-sm-10">
					<input type="text" name="tBarcode" class="form-control" <?php  echo "value='".$quick."'"; ?> >
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<span id="helpBlock" class="help-block">*不可為空 不能含有英文單雙引號</span>
					<input name="tID" type="hidden" value="<?php echo $row_result["tID"];?>">
					<input name="action" type="hidden" value="return">
					<input class="btn btn-default" type="reset" name="button2" id="button2" value="重新">
					<input class="btn btn-success" type="submit" name="button" id="button" value="歸還">
				</div>
			</div>
		</form>
	</div>
</div>

<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->
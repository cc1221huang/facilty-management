<?php $title = "刪除器材資料";?>
<?php
require_once("ta_connMysql.php");
if(isset($_POST["action"])&&($_POST["action"]=="remove")){	
	// drop a row in facility table
	$sql_query = "DELETE FROM `manage`.`facility` WHERE `facility`.`fID` = ".$_POST["fID"];
	echo $sql_query."<br>";
	mysql_query($sql_query);
	logging_query($sql_query);
	// drop table 
	$sql_dropTable_query = "DROP TABLE `".$_POST["fBarcode"]."`";
	echo $sql_dropTable_query;
	mysql_query($sql_dropTable_query);
	logging_query($sql_dropTable_query);
	//重新導向回到主畫面
	header("Location: index.php");
	exit();
}
$sql_db = "SELECT * FROM `facility` where `fBarcode`='".$_GET["id"]."'";
$result = mysql_query($sql_db);
$row_result=mysql_fetch_assoc($result);
?>

<?php require("modules/header.php");?>

	<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>
	<p><strong>借用記錄將一起清除</strong></p>
	
	<table class="table">
		<thead>
		<tr>
			<th>欄位</th><th>資料</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>名稱</td><td><?php echo $row_result["fName"]; ?></td>
		</tr>
		<tr>
			<td>敘述</td><td><?php echo $row_result["fDesc"]; ?></td>
		</tr>
		<tr>
			<td>條碼</td><td><?php echo $row_result["fBarcode"]; ?></td>
		</tr>
		</tbody>
	</table>
	
	<form action="" method="post" name="formRemove" id="formRemove">
		<input name="action" type="hidden" value="remove">
		<input name="fID" type="hidden" value="<?php echo $row_result["fID"];?>">
		<input name="fBarcode" type="hidden" value="<?php echo $row_result["fBarcode"];?>">
		<input type="submit" name="button" id="button" value="刪除" class="btn btn-danger" autofocus> <a class="btn btn-default" href="index.php">取消</a>	
	</form>




<?php require("modules/footer.php");?>

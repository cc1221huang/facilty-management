<?php
require_once("ta_connMysql.php");
if (isset($_POST["action"])&&($_POST["action"]=="rec_modify")) 
{
	$php_unix_timestamp_borrow = strtotime( $_POST["tBorrowTime"] );
	$php_unix_timestamp_return = strtotime( $_POST["tReturnTime"] );
	$sql_query = "UPDATE `".$_POST["id"]."` SET ";
	$sql_query .= "`tBorrower` = '".$_POST["tBorrower"]."',";
	$sql_query .= "`tUssage` = '".$_POST["tUssage"]."',";
	$sql_query .= "`tBorrowTime` = '".$php_unix_timestamp_borrow."',";
	$sql_query .= "`tBorrowTA` = '".$_POST["tBorrowTA"]."',";
	$sql_query .= "`tReturnTime` = '".$php_unix_timestamp_return."',";
	$sql_query .= "`tReturnTA` = '".$_POST["tReturnTA"]."',";
	$sql_query .= "`tDesc` = '".$_POST["tDesc"]."' ";
	$sql_query .= "WHERE tID = '".$_POST["tID"]."'";
	echo $sql_query;
	mysql_query($sql_query);
	logging_query($sql_query);
	header("Location: item.php?id=".$_POST["id"]);
	exit();
}
$sql_db = "SELECT * FROM `".$_GET["id"]."` WHERE tID = ".$_GET["tID"];
$result = mysql_query($sql_db);
$row_result = mysql_fetch_assoc($result);
?>
<?php $title = "修改記錄"; ?>
<?php require("modules/header.php"); ?>

<p><a href="item.php?id=<?php echo $_GET["id"]?>">回記錄列表</a></p>

<form action="" method="post" name="rec_modify_form">
	<table border="1" cellpadding="4">
		<tr><th>欄位</th><th>資料</th></tr>

		<tr><td>設備條碼</td><td><input type="text" name="id" value="<?php echo $_GET["id"];?>" readonly></td></tr>
		<tr><td>序號</td><td><input type="text" name="tID" id="tID" value="<?php echo $row_result["tID"];?>" readonly></td></tr>
		<tr><td>借用人</td><td><input type="text" name="tBorrower" id="tBorrower" value="<?php echo $row_result["tBorrower"];?>"></td></tr>
		<tr><td>用途</td><td><input type="text" name="tUssage" id="tUssage" value="<?php echo $row_result["tUssage"];?>"></td></tr>
		<tr>
			<td>借用時間</td>
			<td><input type="text" name="tBorrowTime" id="tBorrowTime" value="<?php if($row_result["tBorrowTime"]!="0") { echo date("Y-m-d H:i:s",$row_result["tBorrowTime"]);} ?>"></td>
		</tr>
		<tr><td>借出值班TA</td><td><input type="text" name="tBorrowTA" id="tBorrowTA" value="<?php echo $row_result["tBorrowTA"];?>"></td></tr>
		<tr>
			<td>歸還時間</td>
			<td><input type="text" name="tReturnTime" id="tReturnTime" value="<?php if($row_result["tReturnTime"]!="0") { echo date("Y-m-d H:i:s",$row_result["tReturnTime"]);} ?>"></td>
		</tr>
		<tr><td>歸還值班TA</td><td><input type="text" name="tReturnTA" id="tReturnTA" value="<?php echo $row_result["tReturnTA"];?>"></td></tr>
		<tr><td>備註</td><td><textarea row="3" cols="20" name="tDesc"><?php echo $row_result["tDesc"];?></textarea></td></tr>
		<tr>
			<td colspan="2" align="center">
			<input name="action" type="hidden" value="rec_modify">
  			<input class="btn  btn-default" type="reset" name="button2" id="button2" value="重填">
  			<input class="btn  btn-default" type="submit" name="button" id="button" value="送出">
 			</td>
 		</tr>
	</table>
</form>

<?php require('modules/footer.php');?>
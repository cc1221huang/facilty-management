
require_once("ta_connMysql.php");

$sql_query = "SELECT * FROM `facility` ORDER BY `facility`.`fName` ASC";	
$result = mysql_query($sql_query);
$i=1;
while($row_result = mysql_fetch_assoc($result)){
	$sql = "ALTER TABLE `".$row_result['fBarcode']."` ADD `tBorrowIP` CHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ADD `tReturnIP` CHAR(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;";
	$alter_result = mysql_query($sql);
	echo $i++.". ".$alter_result."<br>";
	if ($alter_result!=1) {
		echo $sql."<br>";
	}
}
echo "adding tBorrowIP tReturnIP columns done.";





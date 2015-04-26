<?php 
	date_default_timezone_set('Asia/Taipei');
  	require_once("functions.php");

	//資料庫主機設定
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "Tkusg201";
	//連線伺服器
	$db_link = @mysql_connect($db_host, $db_username, $db_password);
	if (!$db_link) die("資料連結失敗！");
	//設定字元集與連線校對
	mysql_query("SET NAMES 'utf8'");
	$seldb = @mysql_select_db("manage");
	if (!$seldb) die("manage資料庫選擇失敗！");	
	
	header("Content-Type: text/html; charset=utf-8");
?>
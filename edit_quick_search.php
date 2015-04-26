<?php
	require_once("ta_connMysql.php");

	
	if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'index_page'")) == 0) 
	{
		echo "creat table";
		$sql = "CREATE TABLE index_page ( quick_search char(255), id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY )";
		mysql_query($sql);
		$sql = "INSERT INTO `manage`.`index_page` (`quick_search`, `id`) VALUES ('new', '1');";
		mysql_query($sql);
	}
	elseif (isset($_POST["action"])&&($_POST["action"]=="modify")) 
	{
		$sql_query = "UPDATE `index_page` SET ";
		$sql_query .= "`quick_search`='".$_POST["quick_search"]."'";
		echo $sql_query;
		mysql_query($sql_query);
		header("Location: index.php");
		exit();
	}
	$sql = "SELECT * FROM `index_page`";
	$result=mysql_query($sql);


	$title = "編輯快速搜尋";
	require("modules/header.php"); 
?>
<!-- <body> -->
<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>

<div class="row">
	<div class="col-sm-8 col-sm-offset-2">
		<form class="form-horizontal" action="" method="post" >
			<?php $row_result = mysql_fetch_assoc($result); ?>
		  	<div class="form-group">
			    <label class="col-sm-2 control-label"></label>
			    <div class="col-sm-10">
			    	<textarea autofocus class="form-control" rows="3"  name="quick_search"><?php echo $row_result["quick_search"];?></textarea>
			    	<span id="helpBlock" class="help-block">輸入關鍵字<small> (以空格分隔)</small></span>
			    </div>
		  	</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input name="action" type="hidden" value="modify">
					<button type="submit" class="btn btn-primary">確定</button>
				</div>
			</div>
		</form>
	</div>
</div>


<!-- </body> -->


<?php require('modules/footer.php');?>
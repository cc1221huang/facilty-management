<?php
require_once("ta_connMysql.php");

if(mysql_num_rows(mysql_query("SHOW TABLES LIKE 'sql_query_log'")) == 0) 
{
	echo "creat a table";
	$sql = "CREATE TABLE sql_query_log ( time timestamp NOT NULL PRIMARY KEY, IP char(20) NOT NULL, query char(255) );";
	mysql_query($sql);
} 

$title = "sql_query_log";
require("modules/header.php");
?>

<!-- <body> -->
<p><a class="btn btn-primary" href="index.php">回器材列表</a> </p>

<?php $i=1;?>
<div class="row">
	<div class="col-md-12">
		<table class="table table-striped table-condensed">
			<thead> <tr> <th>#</th> <th>time</th> <th>IP</th> <th>query</th> </tr> </thead>
			<tbody>
			<?php 
			$result = mysql_query("SELECT * FROM `sql_query_log` ORDER BY `sql_query_log`.`time` DESC");
			while($row_result = mysql_fetch_assoc($result) ) { ?>
			 <tr> <th scope="row"><?php echo $i++;?></th> 
			 	<td><?php echo $row_result['time'];?></td> 
			 	<td><?php echo $row_result['IP'];?></td> 
			 	<td><?php echo $row_result['query'];?></td> 
			 </tr> 
			<?php } ?>
			</tbody>
		</table>
	
	</div>
</div>

<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->
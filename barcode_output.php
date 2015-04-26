<?php
	header("Content-Type: text/html; charset=utf-8");
	require_once("ta_connMysql.php");
	// look facility from
	$sql_query = "SELECT * FROM `facility`";
	$result = mysql_query($sql_query);
	$total_records = mysql_num_rows($result);
	$title = "barcode layout";
	require("modules/header.php");
?>
<!-- <body> -->	
	<table class="table table-bordered">
		<thead>
		<tr>
			<th>名稱</th><th>條碼</th>
		</tr>
		</thead>
		<tbody>
			<?php
			while($row_result = mysql_fetch_assoc($result)){
				echo "<tr>";
				echo "<td><p>".$row_result["fName"]."</p><p><code>".$row_result["fBarcode"]."</code></p></td>";
				// echo "<td>".$row_result["fBarcode"]."<br>";
				echo "<td>";
				echo "<img src='http://barcode.tec-it.com/barcode.ashx?code=Code128&modulewidth=fit&data=".$row_result["fBarcode"]."'' alt='".$row_result["fBarcode"]."'/>";
				echo "</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

<p><a href="http://www.tec-it.com" title="TEC-IT Barcode, Label and Reporting Software"><img src="http://www.tec-it.com/pics/banner/web/TEC-IT_Banner_120x29.gif" border="0" alt="TEC-IT Barcode, Label and Reporting Software"></a>
<br/>
TEC-IT (<a href="http://www.tec-it.com" title="Barcode, Label and Reporting Software" target="_blank">www.tec-it.com</a>) is a global provider of  <a href="http://www.tec-it.com" title="Barcode Software" target="_blank">barcode software</a>, <a href="http://www.tec-it.com" title="Labeling Software" target="_blank">label software</a> and <a href="http://www.tec-it.com" title="Report Designer and Report Generator Software" target="_blank">reporting software</a>. TEC-IT software is in worldwide use and supports all common operating systems, ERP solutions, standard applications and development environments.</p>
<!-- </body> -->
<?php require("modules/footer.php");?>
<!-- end of html -->
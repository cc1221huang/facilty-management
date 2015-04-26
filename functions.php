<?php

function 
show_record_table($id){
	$sql_db = "SELECT * FROM `".$id."` ORDER BY `tID` DESC";
	$result=mysql_query($sql_db);
	$total_records = mysql_num_rows($result);
	echo "<div align='right'>共列出 ".$total_records." 筆</div>";
	echo "<div class='table-responsive'>";
	echo "<table class='table table-striped table-hover'>
		<thead><tr>
			<th>序號</th><th>借用人</th><th>用途</th><th>借用時間</th><th>借用值班TA</th><th>歸還時間</th><th>歸還值班TA</th><th>備註</th><th>修改</th>
		</tr></thead><tbody>";
		while($row_result = mysql_fetch_assoc($result)){
			echo "<tr>";
			echo "<td>".$row_result["tID"]."</td>";
			echo "<td>".$row_result["tBorrower"]."</td>";
			echo "<td>".$row_result["tUssage"]."</td>";
			if ($row_result["tBorrowTime"]){
				echo "<td>".date("Y-m-d H:i:s",$row_result["tBorrowTime"])."</td>";
			}else{
				echo "<td></td>";
			}
			echo "<td>".$row_result["tBorrowTA"]." (".$row_result["tBorrowIP"].")"."</td>";
			if ($row_result["tReturnTime"]){
				echo "<td>".date("Y-m-d H:i:s",$row_result["tReturnTime"])."</td>";
			}else{
				echo "<td></td>";
			}
			echo "<td>".$row_result["tReturnTA"]." (".$row_result["tReturnIP"].")"."</td>";
			echo "<td>".$row_result["tDesc"]."</td>";
			echo "<td><a class='btn btn-default btn-xs' href=rec_modify.php?id=".$id."&tID=".$row_result["tID"]."><i class='icon-pencil'></i> 修改</a></td>";
			echo "</tr>";
		}
	echo "</tbody></table>";
	echo "</div>";
}

function 
GetIP(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		$cip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		$cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif(!empty($_SERVER["REMOTE_ADDR"])){
		$cip = $_SERVER["REMOTE_ADDR"];
	}
	else{
		$cip = "無法取得IP位址！";
	}
	return $cip;
}

function 
show_recently_lookup(){
	$sql = "SELECT * FROM `index_page`";
	$row_result = mysql_fetch_assoc(mysql_query($sql));
	$list=explode(" ",$row_result["quick_search"]);
	for ($i=0; $i < count($list); $i++) { 
		echo "<a href='index.php?search=".$list[$i]."'>".$list[$i]."</a> ";
	}
	echo "&nbsp;<a href='edit_quick_search.php'>[編輯]</a>";
} 

function 
show_disk_ussage($disk){
	// $disk="D:";
	$HD_free = (disk_free_space($disk) / 1024 / 1024 ) ; 
	$HD_total = (disk_total_space($disk) / 1024 / 1024 ) ;
	$persentage=($HD_total-$HD_free)/$HD_total*100;
	if ($persentage<60) {
		$disk_state="progress-bar-success";
	} elseif (60<=$persentage and $persentage<85) {
		$disk_state=" ";
	} elseif(85<=$persentage and $persentage<95){
		$disk_state="progress-bar-warning";
	} elseif (95<=$persentage) {
		$disk_state="progress-bar-danger";
	} 
	echo "
	<div class='row'>
		<div class='col-sm-12'> 
		    <div class='progress'>
		        <div class='progress-bar ".$disk_state."' role='progressbar' style='min-width: 2em;width: ".$persentage."%;'>   
		           <abbr title='剩下 ".floor($HD_free)." MB / 全部 ".floor($HD_total/1024)." GB'>".$persentage." %</abbr>
		        </div>
		    </div>
		</div>
	</div>";
} 

function 
logging_query($sql){
	require_once("ta_connMysql.php");
	$sql = mysql_real_escape_string($sql);
	$sql = str_replace('"', '', $sql);
	$sql_query = "INSERT INTO `manage`.`sql_query_log` (`time`, `IP`, `query`) VALUES (CURRENT_TIMESTAMP, '".GetIP()."', '".$sql."');";
	// echo $sql_query;
	@mysql_query($sql_query);
} 

function 
delete_special_mark($input_string){
	$arr =  array('"',"'",'/',"\\",'`');
	return str_replace($arr, '', $input_string);
}

?>
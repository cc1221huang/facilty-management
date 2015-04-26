<?php 
$disk1="C:"; 
$HD_free1 = (disk_free_space($disk1) / 1024 / 1024 ) ; $HD_total1 = (disk_total_space($disk1) / 1024 / 1024 ) ;
/*you should do try and catch with disk_free_space() and disk_total_space()*/ ?>

<div class="row">
	<div class="text-center"><small><abbr title="這是TAshare的容量喔 (啾咪>.^)~">磁碟空間使用量</abbr></small></div>
</div>

<?php 
$disk="D:";
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
?>
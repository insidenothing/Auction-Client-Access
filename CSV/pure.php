<?
function pureString($str){
	$str = str_replace('\'','',$str);
	$str = addslashes($str);
	$str = str_replace('#','no.',$str);
	return $str;
}
function recordEvent($str){
	$batch = date('Y-m-d');
	$time = date('H:i:s');
	$log = '/gitbox/Auction-Client-Access/logs/'.date('Y').'/'.date('F').'/'.date('j').'/Address Correction Report.txt';
	if (!file_exists('/gitbox/Auction-Client-Access/logs/'.date('Y'))){
		mkdir ('/gitbox/Auction-Client-Access/logs/'.date('Y'),0777);
	}
	if (!file_exists('/gitbox/Auction-Client-Access/logs/'.date('Y').'/'.date('F'))){
		mkdir ('/gitbox/Auction-Client-Access/logs/'.date('Y').'/'.date('F'),0777);
	}
	if (!file_exists('/gitbox/Auction-Client-Access/logs/'.date('Y').'/'.date('F').'/'.date('j'))){
		mkdir ('/gitbox/Auction-Client-Access/logs/'.date('Y').'/'.date('F').'/'.date('j'),0777);
	}
	if(!file_exists($log)){
		touch($log);
	}
	error_log("$time ".trim($str)."\n", 3, $log);
}

function leading_zeros($value, $places){
    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}
function needLeading($str){
	if (strlen($str) != 2){ 
		return leading_zeros($str,2); 
	}else{ 
		return $str; 
	}
}
function deadline($full){
	$full = strtotime($full);
	$ago = $full - 1555200;
	$now = time();
	$diff = $ago-$now;
	$days=number_format($diff/86400,0);
	$return[d1] = $days;
	$return[d2] = date('m/d/Y',$ago);
	return $return;
}
function newFiles($file){
	$query = "SELECT schedule_id, item_datetime FROM schedule_items WHERE autoStatus = 'NEW' AND file = '".trim($file)."'";
	$resource = @mysql_query($query);
	$data = mysql_fetch_array($resource,MYSQL_ASSOC);
	if ($data[schedule_id]){
		$date = substr($data[item_datetime],0,10);
		return "Transferred $date as auction $data[schedule_id]";
	}
}
function pieceData($field,$data){
	$today=date('Y-m-d');	
	$query = "SELECT schedule_id FROM schedule_items WHERE $field = '$data' AND sale_date > '$today'";
	$resource = @mysql_query($query);
	$data = mysql_fetch_array($resource,MYSQL_ASSOC);
	if (!$data[schedule_id]){
		return "Not Found";
	}else{
		return "Conflict";
	}
}
$_SESSION[total]=0;
$_SESSION[error]=0;
$_SESSION[missing]=0;
$_SESSION[transferred]=0;
$_SESSION[address]=0;
mysql_connect();
mysql_select_db('intranet');
$today = date('Y-m-d');
$q="SELECT * from bursonDB where hwa_sale_date > '$today' order by hwa_sale_date, file_number";
$r=@mysql_query($q);
?>
<style>
.danger { background-color:; }
.warn { background-color:;}
.transfer { background-color:;}

</style>
<? while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ 
$_SESSION[total]++;
$date = $d[hwa_sale_date];
// format time set 1
$time = trim($d[sale_time]);
$time = str_replace('&QUOT;','',$time);
$time = explode(' ',$time);
$time = explode(':',$time[0]);
if (strlen($time[0]) != '2'){
	$time = leading_zeros($time[0],'2').':'.$time[1];
}else{
	$time = $time[0].':'.$time[1];
}
// reprocess if set 1 failed
if (strlen($time) != 5){
	$time = trim($d[sale_time]);
	$time = str_replace('AM',' AM',$time);
	$time = str_replace('PM',' PM',$time);
	$time = str_replace('&QUOT;','',$time);
	$time = explode(' ',$time);
	$time = explode(':',$time[0]);
	if (strlen($time[0]) != '2'){
		$time = leading_zeros($time[0],'2').':'.$time[1];
	}else{
		$time = $time[0].':'.$time[1];
	}
}







// clear a few variables
$foundOn="";

// check the database
        echo $today;
		$query = "SELECT schedule_id FROM schedule_items WHERE address1 = '".pureString(trim($d[address1]))."' AND file = '".trim($d[file_number])."' AND sale_date > '$today' AND sale_date = '".trim($date)."' and sale_time like '".trim($time)."%'";
		echo $query;
		$resource = @mysql_query($query);
		$data = mysql_fetch_array($resource,MYSQL_ASSOC);
		echo $data;
		if(!$data[schedule_id]){
				if (pieceData('file',$d[file_number]) == 'Not Found'){
				$_SESSION[missing]++;
			}else{
				$query33 = "SELECT notes, schedule_id, sale_date, sale_time, item_status, address1 FROM schedule_items WHERE file = '$d[file_number]' AND sale_date > '$today'";
				echo $query33;
				$resource33 = @mysql_query($query33);
				
				while($data33 = mysql_fetch_array($resource33,MYSQL_ASSOC)){
				 if (addslashes(trim($d[address1])) != $data33[address1]){
				 // this is where is get's automated! sync our database to their data source
					$_SESSION[address]++;
					recordEvent("Updated $data33[address1] to $d[address1] for auction $data33[schedule_id]");
					$notes = "Burson Database Update:<br> $data33[address1] to<br> $d[address1] on ".date('m/d/y').", ";
					$notes = addslashes($notes).$data33[notes];
					@mysql_query("update schedule_items set notes='$notes', address1 = '".addslashes(trim($d[address1]))."' where schedule_id = '$data33[schedule_id]'");
				 // end active sync
				 }
				 $foundOn .= $data33[address1].' '.$data33[item_status].'<br>'.$data33[sale_date].' at '.$data33[sale_time].'<br>';
				}
				$_SESSION[error]++;
			}
			$query44 = "SELECT * FROM csvReportHistory WHERE clientFile = '$d[file_number]' AND address1 = '$d[address1]' AND sale_date = '$date' AND sale_time = '$time'";
			echo $query44;
			$resource44 = @mysql_query($query44);
			$data44 = mysql_fetch_array($resource44,MYSQL_ASSOC);
			echo $data44;
			if (!$data44[historyID]){
				@mysql_query("insert into csvReportHistory ( clientFile, sale_date, sale_time, address1, firstReported ) values ( '$d[file_number]', '$date', '$time', '$d[address1]', NOW() )");
			}else{
				@mysql_query("update csvReportHistory set lastReported = NOW() where historyID = '$data44[historyID]'");
				$started = strtotime($data44[firstReported]);
				$days=number_format((time()-$started)/86400,0);
			}
			
			$test = deadline($date);
			if ($test[d1] < 0){
				$deadline = "PAST DEADLINE";
			}else{
				$deadline = "$test[d1] Days ($test[d2])";
			}


			if(newFiles($d[file_number])){
				$_SESSION[transferred]++;
				$class = '99FF99';
			}elseif ($days > 7){
				$class = 'FF0000';
			}elseif($foundOn){
				$class = 'FF33FF';
			}elseif($days > 5){
				$class = 'FFCC66';
			}elseif($days > 3){
				$class = 'FFCC66';
			}elseif($days > 1){
				$class = 'FFFFcc';
			}else{
				$class = 'FFFFFF';
			}



if(newFiles($d[file_number]) == ''){
ob_start();
?>
	<tr bgcolor="#<?=$class?>">
		<td><?=$days?> Days</td>
		<td><?=$d[file_number];?></td>
		<td><?=$d[address1];?></td>
		<td><?=$date;?></td>
		<td><?=$time;?></td>
		<td nowrap="nowrap"><?=pieceData('file',$d[file_number]);?><br><?=$foundOn;?><?=newFiles($d[file_number]);?></td>
		<td><?=$deadline?></td>
	</tr>
<? 

if ($foundOn){
$conflict.=ob_get_clean();
}else{
$missed.=ob_get_clean();
}



}
}

}
?>
<table width="100%" border="1" style="border-collapse:collapse;">
	<tr bgcolor="#CCCCCC">
		<td>Known For</td>
		<td>S&amp;B File Number</td>
		<td>S&amp;B Address</td>
		<td>S&amp;B Sale Date</td>
		<td>S&amp;B Sale Time</td>
		<td>HWA Database Response</td>
		<td>Approx. Deadline</td>
	</tr>
<?=$missed;?>
</table>
<span>
<b>Still Need to Transfer <?=$_SESSION[missing]-$_SESSION[transferred];?></b><br>
Auctions Verified: <?=$_SESSION[total]-$_SESSION[error]-$_SESSION[missing];?><br>
Addresses Updated: <?=$_SESSION[address];?><br>
</span>
<div>Updates and Conflicts</div>
<table width="100%" border="1" style="border-collapse:collapse;">
	<tr bgcolor="#CCCCCC">
		<td>Known For</td>
		<td>S&amp;B File Number</td>
		<td>S&amp;B Address</td>
		<td>S&amp;B Sale Date</td>
		<td>S&amp;B Sale Time</td>
		<td>HWA Database Response</td>
		<td>Approx. Deadline</td>
	</tr>
<?=$conflict;?>
</table>
<?
mysql_connect();
mysql_select_db('intranet');
$r=@mysql_query("SELECT DISTINCT syncDate FROM bursonDB order by syncDate DESC");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$activeSync = $d[syncDate];
$today = date('Y-m-d');
function testActive($file,$date){
	$q="select * from bursonDB where file_number = '$file' and syncDate = '$date'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
	if ($d[file_number]){
		//return "ACTIVE: $q";
	}else{
		$q="select * from bursonDB where file_number = '$file' and syncDate <> '$date'";
		$r=@mysql_query($q);
		$d=mysql_fetch_array($r,MYSQL_ASSOC);
		if ($d[syncDate]){
			return "LAST ACTIVE ON ".$d[syncDate];
		}else{
			return "NOT ACTIVE ON DATA SOURCE";
		}
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

$outlook = mktime(0, 0, 0, date("m")+1, date("d"),   date("Y"));
$outlook = date('Y-m-d',$outlook);

$i=0;
?>
<div style="font-size:20px;" align="center">Data Source Overflow Report: <?=$activeSync;?> | Projected to <?=$outlook;?></div>
<div style="font-size:16px;" align="center"><?=date('r');?></div>
<table width="100%"  border="1" style="border-collapse:collapse;">
	<tr bgcolor="#CCCCCC">
		<td>.</td>
		<td>File Number</td>
		<td>Sale Date</td>
		<td>Sale Time</td>
		<td>Address</td>
		<td>Auction ID</td>
		<td>S&amp;B Data Source Result</td>
		<td>Approx. Deadline</td>
	</tr>	
<?
// loop through all "on schedule burson files"
if ($_GET[bypass]){
	$r=@mysql_query("select sale_date, sale_time, schedule_id, file, address1 from schedule_items where attorneys_id = '1' and item_status = 'ON SCHEDULE' and sale_date > '$today' order by sale_date");
}else{
	$r=@mysql_query("select sale_date, sale_time, schedule_id, file, address1 from schedule_items where attorneys_id = '1' and item_status = 'ON SCHEDULE' and sale_date > '$today' and sale_date < '$outlook' order by sale_date");
}
while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ 
$test = testActive($d['file'],$activeSync); if ($test){ 
$i++;

			$test2 = deadline($d[sale_date]);
			if ($test2[d1] < 0){
				$deadline = "PAST DEADLINE";
			}else{
				$deadline = "$test2[d1] Days ($test2[d2])";
			}


?>
	<tr <? if ($test != 'NOT ACTIVE ON DATA SOURCE'){ echo "bgcolor='#FF0000'"; }?>>
		<td><?=$i;?></td>
		<td><?=$d['file']?></td>
		<td><?=$d[sale_date]?></td>
		<td><?=$d[sale_time]?></td>
		<td><?=$d[address1]?></td>
		<td><?=$d[schedule_id]?></td>
		<td><?=$test;?></td>
		<td><?=$deadline;?></td>
	</tr>	
<? } } ?>
</table>

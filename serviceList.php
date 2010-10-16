<?
include 'header2.php';

function getLogData($date,$att){
	$html = "<tr><td colspan='6' style='border-top:solid 3px;' align='center'><strong>$date</strong></td></tr>";
	if ($_GET[active]==0){
		$r=@mysql_query("select * from ps_packets where alert_date = '$date' and attorneys_id='$att' and service_status='IN PROGRESS' and process_status <> 'DUPLICATE' and process_status <> 'READY' and process_status <> '' and process_status <> 'DAMAGED PDF' and process_status <> 'FILE COPY' and process_status <> 'DUPLICATE/DIFF-PDF'");
		$sent='Active';
	}else{
		$r=@mysql_query("select * from ps_packets where alert_date = '$date' and attorneys_id='$att'");
		$sent='Sent';

	}
	$x=0;
	$test=0;
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		$x++;
				$test=1;
		$html .= "<tr>
		<td nowrap>$d[date_received]</td>
		<td nowrap>$d[client_file]</td>
		<td nowrap>$d[service_status]</td>
		<td nowrap>$d[process_status]</td>
		<td nowrap>$d[affidavit_status]</td>
		<td nowrap><a href='ps_details.php?id=$d[packet_id]&uid=".$_GET[uid]."'>&curren; Service Details</a></td></tr>";
		
	}
	$html .= "<tr><td colspan='6' align='center'><strong>$x Files $sent</strong></td></tr>";
	if ($test){
	return $html;
	}
}
?>
<div style="font-size:20px; padding:5px;">
  Welcome <?=$user[name]?>,<br />
<table align="center">
	<tr>
    	<td>Browse: </td>
    	<td><a href="?active=0&uid=<?=$_GET[uid]?>">ACTIVE</a> | </td>
        <td><a href="?active=1&uid=<?=$_GET[uid]?>">ALL</a></td>
    </tr>
</table>
</div>

<table border='1' width="100%">
<tr>
		<td nowrap>Date File Transfered</td>
		<td nowrap>File Number</td>
		<td nowrap>Service Status</td>
		<td nowrap>Processing Status</td>
		<td nowrap>Affidavit Status</td>
		<td nowrap>Service Links</td></tr>
<? 
$r=@mysql_query("SELECT distinct alert_date from ps_packets where alert_date <> '0000-00-00' AND attorneys_id = '".$user['attorneys_id']."' order by alert_date DESC") or die(mysql_error());
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo getLogData($d['alert_date'],$user[attorneys_id]);
}
?></table><?
include 'footer.php';
?>

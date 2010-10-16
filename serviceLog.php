<?
include 'header2.php';

function getLogData($date,$att){
	$html = "<div style='border:double 3px'>$date";
	$r=@mysql_query("select * from ps_packets where closeOut = '$date' and attorneys_id='$att'");
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		
		if($d[vacantDescription]){
		$vacant= " ! Occupacy Alert - $d[vacantDescription] !";
		}else{
		$vacant='';
		}
		
		
		
		$html .= "<div style='padding-left:100px'>$d[date_received]: $d[client_file]: <a href='ps_details.php?id=$d[packet_id]&uid=".$_GET[uid]."'>&curren; $d[service_status] Details $vacant</a></div>";
	}
	$html .= "</div>";
	return $html;
}
?>
<div style="font-size:20px; padding:5px;">
  Welcome <?=$user[name]?>, Below is a list of all files <b>completed</b>, affidavit is <b>up-to-date</b>.<br />
</div>
<? 
$r=@mysql_query("SELECT distinct closeOut from ps_packets where closeOut <> '0000-00-00' order by closeOut DESC") or die(mysql_error());
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	echo getLogData($d['closeOut'],$user[attorneys_id]);
}
include 'footer.php';
?>

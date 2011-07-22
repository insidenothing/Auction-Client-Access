<?PHP
include 'header2.php';


function timeline($id,$note){
	mysql_select_db ('core');

	$q1 = "SELECT timeline FROM ps_packets WHERE packet_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$access=date('m/d/y g:i A');
	if ($d1[timeline] != ''){
		$notes = $d1[timeline]."<br>$access: ".$note;
	}else{
		$notes = $access.': '.$note;
	}
	$notes = addslashes($notes);
	$q1 = "UPDATE ps_packets set timeline='$notes' WHERE packet_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	@mysql_query("insert into syslog (logTime, event) values (NOW(), 'Packet $id: $note')");
}
if ($_GET[reinvoice] == 1){
$r=@mysql_query("select case_no from ps_packets where packet_id = '$_GET[id]'") or die(mysql_error());
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$case = str_replace('?',0,$d[case_no]);
$case = str_replace('&Oslash;',0,$case);
//echo "<h1>$case</h1>";
@mysql_query("update ps_packets set case_no='$case' where packet_id= '$_GET[id]'") or die(mysql_error());
?>
<table>
<tr><td><iframe frameborder="0" src="http://mdwestserve.com/ps/ps_write_invoice.php?id=<?PHP echo $_GET[id]?>" width="600" height="30"></iframe></td></tr>
</table>
<?PHP }
if ($_GET[cancel] == 1){
	@mysql_query("UPDATE ps_packets SET process_status = 'CANCELLED', service_status='CANCELLED', status='CANCELLED', affidavit_status='CANCELLED', payAuth='1' where packet_id='$_GET[id]'");
	timeline($_GET[id],$user[name]." Cancelled Order");
	portal_log("Cancelled Process Service for file $data[client_file] ($data[adess1] : $data[date_received])", $user[contact_id]);
	$r=@mysql_query("select * from ps_packets where packet_id='$_GET[id]'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
?>
<table>
<tr><td><iframe frameborder="0" scrolling="no" src="http://mdwestserve.com/ps/ps_write_invoice.php?id=<?PHP echo $_GET[id]?>" width="600" height="2"></iframe></td></tr>
</table>
<?PHP
// email client invoice
$to = "Service Updates <mdwestserve@gmail.com>";
$subject = "Cancelled Service for Packet $_GET[id] ($d[client_file])";
$headers  = "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
$headers .= "From: $user[name] <service.cancelled@mdwestserve.com> \n";
$attR = @mysql_query("select ps_to from attorneys where attorneys_id = '$d[attorneys_id]'");
$attD = mysql_fetch_array($attR, MYSQL_BOTH);
$c=-1;
$cc = explode(',',$attD[ps_to]);
$ccC = count($cc)-1;
while ($c++ < $ccC){
$headers .= "Cc: Service Updates <".$cc[$c]."> \n";
}
$headers .= "Cc: Service Updates <zach@mdwestserve.com> \n";
if ($d["attorneys_id"] == 1 || $d["attorneys_id"] == 44){
$filename = $d["client_file"].'-'.$d[date_received]."-"."CLIENT.PDF";
}else{
$filename = $d["case_no"]."-"."CLIENT.PDF";
}
$fname = id2attorneys($d["attorneys_id"]).'/'.$filename;
$body ="<strong>Thank you for selecting MDWestServe as Your Process Service Provider.</strong><br>
Service for packet $_GET[id] (<strong>$d[client_file]</strong>) is cancelled by $user[name], closeout documents as follows:
<li><a href='http://mdwestserve.com/invoices/$fname'>Invoice</a></li>";
$body .= "<br><br>Service@HWestAuctions.com<br>MDWestServe";
mail($to,$subject,$body,$headers);
	//echo "<script>window.location='ps_details.php?id=".$_GET[id]."&uid=".$_GET[uid]."'< /script>";
echo "<div style='background-color:#00FFFF'>$body</div>";
}
$q = "SELECT * FROM ps_packets WHERE packet_id = '$_GET[id]'";		
$r = @mysql_query ($q) or die(mysql_error());
portal_log("Accessing Details for Process Service $data[client_file] ($data[adess1] : $data[date_received])", $user[contact_id]);
$data = mysql_fetch_array($r, MYSQL_ASSOC);
$i=0;
$q1 = "SELECT *, DATE_FORMAT(date_received,'%M %D, $Y at %l:%i%p') as date_received_f FROM ps_packets WHERE packet_id = '$_GET[id]'";		
$r1 = @mysql_query ($q1) or die("Query: $q1<br>".mysql_error());
if ($data[status] == 'RECIEVED'){
	$status='RECEIVED';
}else{
	$status=$data[status];
}
?>
<style>
li, td {font-size:16px}
</style>
<?PHP if($data[extended_notes]){ ?>
<fieldset><legend>Client Service Alert</legend>
<?PHP echo stripslashes($data[extended_notes])?>
</fieldset>
<?PHP }?>
<pre>
File Number: <?PHP echo $data[client_file]?><br>
Service Packet #<?PHP echo $data[packet_id]?><br>
Circuit Court: <?PHP echo $data[circuit_court]?><br>
Case # <?PHP echo $data[case_no]?><br>
<?PHP if ($data[filing_status] == "FILED BY CLIENT" || $data[filing_status] == "FILED WITH COURT" || $data[filing_status] == "FILED WITH COURT - FBS"){ ?>
Ready for Sale.<br>
Service Documents:
</pre>
<?PHP 
$q2="SELECT * from ps_affidavits where packetID = '$_GET[id]'"; 
$r2=@mysql_query($q2) or die("Query $q2<br>".mysql_error());
$d2=mysql_num_rows($r2);
if ($d2 > 0){
	while ($d3=mysql_fetch_array($r2, MYSQL_ASSOC)){
		$dir=explode('http://mdwestserve.com',$d3['affidavit']);
		if ($dir[1] != ''){
			$href='http://mdwestserve.com'.str_replace('/ps','',$dir[1]);
		}
		echo "<li><a target='_blank' href='$href'>".strtoupper($data['name'.$d3[defendantID]]).": $d3[method]</a></li>";
	}
}
}elseif ($data[filing_status] == "CANCELLED" || $data[filing_status] == "DO NOT FILE"){ ?>
Service Cancelled
</pre>
<?PHP }else{ ?>
Service In Progress
</pre>
<?PHP } ?>
<li><a target='_blank' href='<?PHP echo str_replace('portal/','',$data[otd]);?>'>View Papers to Serve</a></li>
<li><a href="ps_details.php?id=<?PHP echo $_GET[id]?>&uid=<?PHP echo $_GET[uid]?>&reinvoice=1">Invoice (will open in popup window)</a></li>
<?PHP if ($data[process_status] != 'CANCELLED'){ ?>
	<li><a href="ps_details.php?id=<?PHP echo $_GET[id]?>&uid=<?PHP echo $_GET[uid]?>&cancel=1">Cancel Service</a></li>
<?PHP }?>
<?PHP
include 'footer.php';
?>

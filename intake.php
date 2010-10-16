<?
include 'header2.php';

function vol($court){
	$r = mysql_query("SELECT packet_id FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' and server_id < '1'");
	return mysql_num_rows($r);
}

function def($court){
	$r = mysql_query("SELECT * FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' and server_id < '1'");
	$total=0;
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	if ($d['name1']){	$total++; }
	if ($d['name2']){	$total++; }
	if ($d['name3']){	$total++; }
	if ($d['name4']){	$total++; }
	}
	return $total;
}

function add($court){
	$r = mysql_query("SELECT * FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' and server_id < '1'");
	$total=0;
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	if ($d['address1']){	$total++; }
	if ($d['address1a']){	$total++; }
	if ($d['address1b']){	$total++; }
	}
	return $total;
}

function vol2($court){
	$r = mysql_query("SELECT packet_id FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' AND case_no='' and server_id < '1'");
	return mysql_num_rows($r);
}

function def2($court){
	$r = mysql_query("SELECT * FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' AND case_no='' and server_id < '1'");
	$total=0;
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	if ($d['name1']){	$total++; }
	if ($d['name2']){	$total++; }
	if ($d['name3']){	$total++; }
	if ($d['name4']){	$total++; }
	}
	return $total;
}

function add2($court){
	$r = mysql_query("SELECT * FROM ps_packets WHERE circuit_court = '$court' AND process_status='READY' AND case_no='' and server_id < '1'");
	$total=0;
	while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){
	if ($d['address1']){	$total++; }
	if ($d['address1a']){	$total++; }
	if ($d['address1b']){	$total++; }
	}
	return $total;
}


function psStatus($status){
	$r = mysql_query("SELECT packet_id FROM ps_packets WHERE status = '$status' and process_status <> 'CANCELLED' AND process_status <> 'DUPLICATE' AND  process_status <> 'DAMAGED PDF'");
	return mysql_num_rows($r);
}
$total ='';
$totala ='';
$totald ='';
include 'menu.php';
?>
<meta http-equiv="refresh" content="120" />

<?
$newx=psStatus('NEW');
?>
<script>document.title='Process Service Live Intake Status'</script>
<table><tr><td valign='top'>
<table border="1" align="center" style="font-variant:small-caps;">
	<tr>
    	<td>County</td>
        <td align="center">Files</td>
        <td align="center">Addresses</td>
        <td align="center">Defendants</td>
    </tr>
<?
$r=@mysql_query("select DISTINCT circuit_court from ps_packets where process_status='READY' and server_id < '1' and case_no <> ''");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$new = vol($d[circuit_court]);
$def = def($d[circuit_court]);
$add = add($d[circuit_court]);
$total = $total + $new;
$totald = $totald + $def;
$totala = $totala + $add;
?>
<tr>
	<td><?=$d[circuit_court];?></td>
    <td align="center"><strong><?=$new;?></strong></td>
    <td align="center"><strong><?=$add;?></strong></td>
    <td align="center"><strong><?=$def;?></strong></td>
</tr>


<? } ?>
<tr>
	<td align="right">Dispatch</td>
 <td align="center"><strong><?=$total?></strong></td>
 <td align="center"><strong><?=$totala?></strong></td>
 <td align="center"><strong><?=$totald?></strong></td>
 </tr>
 <tr>
	<td align="right">Processing</td>
 <td align="center"><strong><?=$newx?></strong></td>
 <td></td>
 </tr>

</table>

</td><td valign='top'>

<table border="1" align="center" style="font-variant:small-caps;">
	<tr>
    	<td>County</td>
        <td align="center">Files</td>
        <td align="center">Addresses</td>
        <td align="center">Defendants</td>
    </tr>
<?
$new='';
$add='';
$def='';
$total='';
$totala='';
$totald='';
$r=@mysql_query("select DISTINCT circuit_court from ps_packets where process_status='READY' and server_id < '1' and case_no = ''");
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$new = vol2($d[circuit_court]);
$def = def2($d[circuit_court]);
$add = add2($d[circuit_court]);
$total = $total + $new;
$totald = $totald + $def;
$totala = $totala + $add;
?>
<tr>
	<td><?=$d[circuit_court];?></td>
    <td align="center"><strong><?=$new;?></strong></td>
    <td align="center"><strong><?=$add;?></strong></td>
    <td align="center"><strong><?=$def;?></strong></td>
</tr>


<? } ?>
<tr>
	<td align="right">Case Lookup</td>
 <td align="center"><strong><?=$total?></strong></td>
 <td align="center"><strong><?=$totala?></strong></td>
 <td align="center"><strong><?=$totald?></strong></td>
 </tr>

</table>
</td></tr></table>


<? include 'footer.php';?>

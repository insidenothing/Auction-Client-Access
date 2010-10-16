<?
include 'header.php';
hardLog($user[name].' Accessing Transfer History ','user');

portal_log("Viewing Packet Transfer Log", $user[contact_id]);
?>
<table cellspacing="0" cellpadding="2" width="100%">
    	<td>Processing Status</td>
    	<td>Files Recieved On</td>
    	<td>File Number</td>

<?
$i=0;
$q="SELECT *, DATE_FORMAT(date_recieved,'%b %D %r') as date_recieved_f FROM ad_packets WHERE contact='$user[contact_id]' ORDER BY date_recieved";
$r=@mysql_query($q) or die(mysql_error());
while($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$i++;
?>	
	<tr bgcolor="<?=row_color_new($i)?>">
    	<td><?=$d[status]?></td>
    	<td><?=$d[date_recieved_f]?></td>
    	<td><?=$d[file]?></td>
	</tr>
<? }?>
</table>

<?
include 'footer.php';
?>

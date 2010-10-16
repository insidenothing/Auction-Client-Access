<?
include 'header.php';

if ($_GET[go]){
	$ip = $_SERVER['REMOTE_ADDR'];
	@mysql_query("UPDATE schedule_items SET pending_cancel='1', pending_by='$user[contact_id]', pending_on=NOW(), pending_ip='$ip' WHERE schedule_id='$_GET[go]'");


	portal_log("Requesting cancellation for auction $_GET[go]", $user[contact_id]);
	portal_note("$user[name] Requesting cancellation",$_GET[go]);
	pub_cost_flag("CANCEL","$_GET[go]",$_POST[ad_cost]);

	$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[go]'";		
	$r = @mysql_query ($q) or die(mysql_error());
	$data = mysql_fetch_array($r, MYSQL_ASSOC);
} else{
	$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[id]'";		
	$r = @mysql_query ($q) or die(mysql_error());
	$data = mysql_fetch_array($r, MYSQL_ASSOC);
}
// ask first
// if not back to details
// if ok set flag to 1
// log in portal
// ad to notes for file
// return to details
// note pending cancelation on details screen

?>
<? if (!$_GET[go]){?>
<div style="font-size:22px">
Auction # <?=$_GET[id]?><br />
<br />
Are you sure you want to cancel the auction for:<br />
File <?=$data[file]?>, <?=$data[address1]?> on <?=$data[sale_date]?>.<br />
<br />
<br />
<a href="?go=<?=$_GET[id]?>&uid=<?=$_GET[uid]?>">[Request Cancellation]</a> or <a href="details.php?id=<?=$_GET[id]?>&uid=<?=$_GET[uid]?>">[Take Me Back to Auction Details]</a>
</div>
<? }else{ ?>

<div style="font-size:22px">
Cancellation Request Recieved for Auction # <?=$_GET[go]?><br />
<br />
File <?=$data[file]?>, <?=$data[address1]?> on <?=$data[sale_date]?>.<br />
<br />
<br />
<a href="details.php?id=<?=$_GET[go]?>&uid=<?=$_GET[uid]?>">[Take Me Back to Auction Details]</a>
</div>

<? }?>
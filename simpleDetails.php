<?
include 'header.php';
mysql_select_db ('intranet');
$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[id]'";		
$r = @mysql_query ($q) or die(mysql_error());
$data = mysql_fetch_array($r, MYSQL_ASSOC);
portal_log("Accessing Details for Auction $data[schedule_id] ($data[address1] : $data[sale_date] @$data[sale_time])", $user[contact_id]);
@mysql_query("INSERT INTO portal_views (user_id, auction_id, stamp_date) values ('".$user[contact_id]."', '$_GET[id]', NOW())");
function washAdURI($uri){
	$uri = str_replace('/var/www/dataFiles/auction/','http://hwestauctions.com/',$uri);
	$uri = str_replace('data/auction/','',$uri);
	return $uri;
}

?>
<table>
	<tr>
		<td valign="top">
<pre>
Status: <?=$data[item_status]?>

Auction: <?=$data[schedule_id]?>

File: <?=$data[file]?>

Sale: <?=$data[sale_date]?> at <?=$data[sale_time]?>

<? if ($data[pending_cancel] == "0" && $data[item_status] == "ON SCHEDULE"){
	echo "<a href='cancel.php?id=$data[schedule_id]&uid=$_GET[uid]'><font size='+2'>Request Auction Cancellation</font></a>
	";
} 
if ($data[pending_cancel] == "1" && $data[item_status] == "ON SCHEDULE"){
	echo "Auction Pending Cancellation
	";
}
?>
Property: <?=$data[address1]?>

<a href="invoice.php?uid=<?=$_GET[uid]?>&auction=<?=$data[schedule_id]?>">Invoice</a>
<? $r67 = @mysql_query("select * from AVC where auction_id = '$_GET[id]' order by ad_id DESC");
$d67 = mysql_fetch_array($r67,MYSQL_ASSOC); if ($d67[uri]){?>

<a href="<?=washAdURI($d67[uri]);?>" target="_Blank">Current Ad in PDF Form</a> 
(right click above link 'save link as' to download)
<? } ?>
</pre>
</td><td valign="top">
<pre>
Access Log
<? 
mysql_select_db ('intranet');
$qn="SELECT *, DATE_FORMAT(stamp_date,'%b %e %h:%i%p') as stamp_date_f FROM portal_views WHERE auction_id = '$_GET[id]' order by stamp_date DESC";
$rn=@mysql_query($qn);
while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){?>
<?=$dn[stamp_date_f];?>: <?=id2contact($dn[user_id]);?>

<? } ?>
</pre>
</td></tr></table>
<? include 'footer.php'; ?>

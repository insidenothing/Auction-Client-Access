<?
include 'header.v2.php';
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
if ($data[pending_cancel] == "1" && $data[item_status] == "ON SCHEDULE"){
	echo "<div style='background-color:#FF0000' align='center'><font size='+2'>Auction Pending Cancellation/font></div>";
}
?>
<a href="details.v2.php?id=<?=$_GET[id]?>">Expanded View</a><?
if ($data[pending_cancel] == "0" && $data[item_status] == "ON SCHEDULE"){
	echo ", <a href='cancel.v2.php?id=$data[schedule_id]&uid=$_GET[uid]'><font>Request Auction Cancellation</font></a>
	";
} ?>
<table>
	<tr>
		<td valign="top">
<pre>
Status: <?=$data[item_status]?>  <?=id2contact($data[canceled_by]);?>

Auction: <?=$data[schedule_id]?>

File: <?=$data[file]?>

Sale: <?=$data[sale_date]?> at <?=$data[sale_time]?>

Property: <?=$data[address1]?>

<? $r67 = @mysql_query("select * from AVC where auction_id = '$_GET[id]' order by ad_id DESC");
$d67 = mysql_fetch_array($r67,MYSQL_ASSOC); if ($d67[uri]){?>

<a href="<?=washAdURI($d67[uri]);?>" target="_Blank">Current Ad in PDF Form</a> 
(right click above link 'save link as' to download)
<? } ?>
</pre>
	<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#99CCFF" border="1">
		<tr>
			<td bgcolor="#FFFF99">Final Invoices</td>
			<td bgcolor="#FFFF99">Estimates</td>
			<td bgcolor="#FFFF99">Legacy Invoices</td>
		</tr>
		<tr>
			<td valign="top">
			<?
			$rfi = @mysql_query("select * from AIVC where auctionID = '$data[schedule_id]' and type = 'FINAL' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://hwestauctions.com$dfi[url]' target='_Blank'>$dfi[stored] ".id2name($dfi[user_id])."</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com$dfi[url]' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
			<td valign="top">			
			<?
			$rfi = @mysql_query("select * from AIVC where auctionID = '$data[schedule_id]' and type = 'ESTIMATE' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://hwestauctions.com$dfi[url]' target='_Blank'>$dfi[stored] ".id2name($dfi[user_id])."</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com$dfi[url]' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
			<td valign="top">
			<?
			$rfi = @mysql_query("select * from AIVC where auctionID = '$data[schedule_id]' and type <> 'FINAL' and type <> 'ESTIMATE' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://hwestauctions.com$dfi[url]' target='_Blank'>$dfi[stored]</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com$dfi[url]' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
		</tr>
	</table>	
<? include 'PDFviewer/news.php'; ?>

</td><td valign="top">
	   <strong>Portal Notes:</strong><br />
        <? 
        $qn="SELECT *, DATE_FORMAT(action_on,'%b %e %h:%i%p') as action_on_f FROM portal_notes WHERE action_file = '$_GET[id]'";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
		echo "$dn[action_on_f]: $dn[action]<br>";
		}
		?>
		<hr />
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
<? include 'footer.v2.php'; ?>

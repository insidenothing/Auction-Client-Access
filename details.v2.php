<?
include 'header.v2.php';
mysql_select_db ('intranet');

$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[id]'";		
$r = @mysql_query ($q) or die(mysql_error());
$data = mysql_fetch_array($r, MYSQL_ASSOC);
portal_log("Accessing Details for Auction $data[schedule_id] ($data[address1] : $data[sale_date] @$data[sale_time])", $user[contact_id]);

@mysql_query("INSERT INTO portal_views (user_id, auction_id, stamp_date) values ('".$user[contact_id]."', '$data[schedule_id]', NOW())");

if ($data[pending_cancel] == "1" && $data[item_status] == "ON SCHEDULE"){
	echo "<div style='background-color:#FF0000' align='center'><font size='+2'>Auction Pending Cancellation</font></div>";
}
?>

<a href="simpleDetails.v2.php?id=<?=$_GET[id]?>">Simple View</a>
<?
if ($data[pending_cancel] == "0" && $data[item_status] == "ON SCHEDULE"){
	echo ", <a href='cancel.v2.php?id=$data[schedule_id]&uid=$_GET[uid]'><font>Request Auction Cancellation</font></a>";
}
?>

<table width="100%"><tr><td valign="top">
<font>Auction Scheduled for <?=$data[sale_date]?> at <?=$data[sale_time]?><br />Details for Auction #<?=$data[schedule_id]?> :: <?=$data[item_status]?> :: <?=id2contact($data[canceled_by]);?></font>


<table border="1" width="100%" style="border-collapse:collapse;" cellspacing="0" cellpadding="5">
	<tr>
    	<td valign="top"><strong>Property Address</strong></td>
    	<td><?=$data[legal_fault]?><br /><?=$data[address1]?><br /><?=$data[city]?>, <?=$data[state]?> <?=$data[zip]?></td>
	</tr>
	<tr>
    	<td><strong>Deposit to Bid</strong></td>
    	<td>$<?=$data[deposit]?>K</td>
	</tr>
	<tr>
    	<td><strong>File #</strong></td>
    	<td><?=$data[file]?></td>
	</tr>
	<tr>
    	<td valign="top"><strong>Publication Information</strong><br /><small>Primary Publication Only</small></td>
    	<td bgcolor="#FFcccc">Published in the <?=$data[paper]?>.<br />Starting on <?=$data[ad_start]?> for <?=$data[pub_dates]?>.<br /><? if ($data[pub_cost_flag] == '3' || $data[pub_cost_flag] == ''){ ?>Total Cost: $<?=$data[ad_cost]?> <? }?></td>
	</tr>
	<tr>
    	<td colspan="2">
		
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
		
		
		</td>
    	
	</tr>
    
    <tr bgcolor="00ff00">
    	<td><b>New Ad Version control</b></td>
        <td>
        <?

		
function washAdURI($uri){
$uri = str_replace('/var/www/dataFiles/auction/','http://mdwestserve.com/',$uri);
$uri = str_replace('data/auction/','',$uri);
return $uri;
}

		
		
		$r67 = @mysql_query("select * from AVC where auction_id = '$_GET[id]' order by ad_id DESC");
while ($d67 = mysql_fetch_array($r67,MYSQL_ASSOC)){
 ?>

<?=$d67[saved_on];?>: <?=id2name($d67[user_id]);?> <a href="<?=washAdURI($d67[uri]);?>" target="_Blank"><small>view</small></a><br />

<? }?>
        
        
        
        
        
        </td>
   </tr>
   <tr>
    	<td><em>Ad Number</em></td>
        <td><?=$data[ad_number]?></td>
   </tr>
      <tr>
    	<td><strong>Process Server Status</strong></td>
        <td>
        <?/*
		mysql_select_db ('core');

        $q="SELECT * FROM ps_packets WHERE client_file = '$data[file]'";
		$r=@mysql_query($q) or die(mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if (!$d[process_status]){
		echo "This auction was not serviced by MDWestServe";
		} else {
		echo "Status: ".$d[process_status]." <a href='ps_details.php?id=$d[packet_id]&uid=$uid'>Details</a>";   
		}
		*/?>
        </td>
   </tr>
</table>    
</td></tr><tr>
<td valign="top">
	   <h1>Portal Notes:</h1>
        <? 		mysql_select_db ('intranet');

        $qn="SELECT *, DATE_FORMAT(action_on,'%b %e %h:%i%p') as action_on_f FROM portal_notes WHERE action_file = '$data[schedule_id]'";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
		echo "$dn[action_on_f]: $dn[action]<br>";
		}
		?>
		

  <h1>Access Log</h1>
        <? 
        $qn="SELECT *, DATE_FORMAT(stamp_date,'%b %e %h:%i%p') as stamp_date_f FROM portal_views WHERE auction_id = '$data[schedule_id]' order by stamp_date DESC";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){?>
		<?=$dn[stamp_date_f];?>:  <?=id2contact($dn[user_id]);?><br>
		<? } ?>
</td></tr></table>
<?

include 'footer.v2.php';
?>

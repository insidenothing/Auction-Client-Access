<?PHP
include 'header.v2.php';
mysql_select_db ('intranet');
function auctioneerPhone($name = ''){

	$r=@mysql_query("select phone from auctioneers where auctioneer = '$name' or name = '$name' or requested_string = '$name' or confirmed_string = '$name' or available_string = '$name'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC)or die(mysql_error());
	return $name.' ('.$d['phone'].') ';
	
}
$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[id]'";		
$r = @mysql_query ($q) or die(mysql_error());
$data = mysql_fetch_array($r, MYSQL_ASSOC);
portal_log("Accessing Details for Auction $data[schedule_id] ($data[address1] : $data[sale_date] @$data[sale_time])", $user[contact_id]);

@mysql_query("INSERT INTO portal_views (user_id, auction_id, stamp_date) values ('".$user['contact_id']."', '".$data['schedule_id']."', NOW())");

if ($data['pending_cancel'] == "1" && $data['item_status'] == "ON SCHEDULE"){
	echo "<div style='background-color:#FF0000' align='center'><font size='+2'>Auction Pending Cancellation</font></div>";
}
?>

<a href="simpleDetails.v2.php?id=<?PHP echo $_GET[id]?>">Simple View</a>
<?PHP
if ($data['pending_cancel'] == "0" && $data['item_status'] == "ON SCHEDULE"){
	echo ", <a href='cancel.v2.php?id=".$data['schedule_id']."'><font>Request Auction Cancellation</font></a>";
}
?>

<table width="100%"><tr><td valign="top">
<font>Auction Scheduled for <?PHP echo $data['sale_date']?> at <?PHP echo $data['sale_time']?><br />Details for Auction #<?PHP echo $data['schedule_id']?> :: <?PHP echo $data['item_status']?> :: <?PHP echo id2contact($data['canceled_by']);?></font>

<br>Auctioneers: <? if ($data['auctioneer'] != ''){ echo auctioneerPhone($data['auctioneer']); } if ($data['auctioneer2'] != ''){ echo auctioneerPhone($data['auctioneer2']); } if ($data['auctioneer3'] != ''){ echo auctioneerPhone($data['auctioneer3']); } ?><br>


<table border="1" width="100%" style="border-collapse:collapse;" cellspacing="0" cellpadding="5">
	<tr>
    	<td valign="top"><strong>Client Notes</strong></td>
    	<td><iframe src="http://portal.hwestauctions.com/notes.php?packet=<?php echo $_GET[id]; ?>" height="250" width="600"></iframe></td>
	</tr>
	<tr>
    	<td valign="top"><strong>Property Address</strong></td>
    	<td><?PHP echo $data['legal_fault']?><br /><?PHP echo $data['address1']?><br /><?PHP echo $data['city']?>, <?PHP echo $data['state']?> <?PHP echo $data['zip']?></td>
	</tr>
	<tr>
    	<td><strong>Deposit to Bid</strong></td>
    	<td>$<?PHP echo $data['deposit']?>K</td>
	</tr>
	<tr>
    	<td><strong>File #</strong></td>
    	<td><?PHP echo $data['file']?></td>
	</tr>
	<tr>
    	<td valign="top"><strong>Publication Information</strong><br /><small>Primary Publication Only</small></td>
    	<td bgcolor="#FFcccc">Published in the <?PHP echo $data['paper']?>.<br />Starting on <?PHP echo $data['ad_start']?> for <?PHP echo $data['pub_dates']?>.<br /><?PHP if ($data['pub_cost_flag'] == '3' || $data['pub_cost_flag'] == ''){ ?>Total Cost: $<?PHP echo $data['ad_cost']?> <?PHP }?></td>
	</tr>
	<tr>
    	<td colspan="2">
		Online File Storage<br>
			<?PHP
			$rfi = @mysql_query("select * from scans where auction = '".$data[schedule_id]."' order by id desc limit 0,1 ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='".$dfi['scan']."' target='_Blank'>".$dfi['method']." ".id2name($dfi['userID'])."</a></li>";
			}
	?>
			<table width="100%" cellpadding="0" cellspacing="0" bgcolor="#99CCFF" border="1">
		<tr>
			<td bgcolor="#FFFF99">Final Invoices</td>
			<td bgcolor="#FFFF99">Estimates</td>
			<td bgcolor="#FFFF99">Legacy Invoices</td>
		</tr>
		<tr>
			<td valign="top">
			<?PHP
			$rfi = @mysql_query("select * from AIVC where auctionID = '".$data['schedule_id']."' and type = 'FINAL' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://staff.hwestauctions.com".$dfi['url']."' target='_Blank'>$dfi[stored] ".id2name($dfi['user_id'])."</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com".$dfi['url']."' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
			<td valign="top">			
			<?PHP
			$rfi = @mysql_query("select * from AIVC where auctionID = '".$data['schedule_id']."' and type = 'ESTIMATE' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://staff.hwestauctions.com".$dfi['url']."' target='_Blank'>".$dfi['stored']." ".id2name($dfi['user_id'])."</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com".$dfi['url']."' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
			<td valign="top">
			<?PHP
			$rfi = @mysql_query("select * from AIVC where auctionID = '".$data['schedule_id']."' and type <> 'FINAL' and type <> 'ESTIMATE' ");
			while ($dfi = mysql_fetch_array($rfi,MYSQL_ASSOC)){
				echo "<li><a href='http://staff.hwestauctions.com".$dfi['url']."' target='_Blank'>".$dfi['stored']."</a> <a href='http://portal.hwestauctions.com/PDFviewer/?pdf=http://hwestauctions.com".$dfi['url']."' target='_Blank'>[HTML]</a></li>";
			}
			?>
			</td>
		</tr>
	</table>	
<?PHP include 'PDFviewer/news.php'; ?>
		
		
		</td>
    	
	</tr>
    
    <tr bgcolor="00ff00">
    	<td><b>New Ad Version control</b></td>
        <td>
        <?PHP

		
function washAdURI($uri){
$uri = str_replace('/var/www/dataFiles/auction/','http://mdwestserve.com/',$uri);
$uri = str_replace('data/auction/','',$uri);
return $uri;
}

		
		
		$r67 = @mysql_query("select * from AVC where auction_id = '".$_GET['id']."' order by ad_id DESC");
while ($d67 = mysql_fetch_array($r67,MYSQL_ASSOC)){
 ?>

<?PHP echo $d67['saved_on'];?>: <?PHP echo id2name($d67['user_id']);?> <a href="<?PHP echo washAdURI($d67['uri']);?>" target="_Blank"><small>view</small></a><br />

<?PHP }?>
        
        
        
        
        
        </td>
   </tr>
   <tr>
    	<td><em>Ad Number</em></td>
        <td><?PHP echo $data['ad_number']?></td>
   </tr>
      
</table>    
</td></tr><tr>
<td valign="top">
	   <h1>Portal Notes:</h1>
        <?PHP 		

        $qn="SELECT *, DATE_FORMAT(action_on,'%b %e %h:%i%p') as action_on_f FROM portal_notes WHERE action_file = '".$data['schedule_id']."'";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
		echo $dn['action_on_f'].": ".$dn['action']."<br>";
		}
		?>
		

  <h1>Access Log</h1>
        <?PHP 
        $qn="SELECT *, DATE_FORMAT(stamp_date,'%b %e %h:%i%p') as stamp_date_f FROM portal_views WHERE auction_id = '".$data['schedule_id']."' order by stamp_date DESC";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){?>
		<?PHP echo $dn['stamp_date_f'];?>:  <?PHP echo id2contact($dn['user_id']);?><br>
		<?PHP } ?>
</td></tr></table>
<?PHP if($data['LiveAdHTML']){
?>
<h1>Online ad review <a href='http://live.hwestauctions.com/publisher.php?id=<?PHP echo $_GET['id'];?>&doc=1'>[.doc]</a><a href='http://live.hwestauctions.com/publisher.php?id=<?PHP echo $_GET['id'];?>&pdf=1'>[.pdf]</a></h1>
<div style='border:solid 1px #000;'><?PHP echo $data['LiveAdHTML'];?></div>
<?PHP } ?>

<?PHP

include 'footer.v2.php';
?>

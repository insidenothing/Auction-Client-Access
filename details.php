<?PHP
include 'header.php';
mysql_select_db ('intranet');

$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[id]'";		
$r = @mysql_query ($q) or die(mysql_error());
$data = mysql_fetch_array($r, MYSQL_ASSOC);
portal_log("Accessing Details for Auction $data[schedule_id] ($data[address1] : $data[sale_date] @$data[sale_time])", $user[contact_id]);

@mysql_query("INSERT INTO portal_views (user_id, auction_id, stamp_date) values ('".$user[contact_id]."', '$data[schedule_id]', NOW())");

?>
<table width="100%"><tr><td valign="top">





<font size="+2">Auction Scheduled for <?PHP echo $data[sale_date]?> at <?PHP echo $data[sale_time]?><br />Details for Auction #<?PHP echo $data[schedule_id]?> :: <?PHP echo $data[item_status]?></font>
<?PHP
if ($data[pending_cancel] == "0" && $data[item_status] == "ON SCHEDULE"){
	echo "<div><a href='cancel.php?id=$data[schedule_id]&uid=$_GET[uid]'><font size='+2'>Request Auction Cancellation</font></a></div>";
}
?>


<?PHP
if ($data[pending_cancel] == "1" && $data[item_status] == "ON SCHEDULE"){
	echo "<div style='background-color:#FF0000' align='center'><font size='+2'>Auction Pending Cancellation</font></div>";
}
?>
<table border="1" width="100%" style="border-collapse:collapse; font-size:24px" cellspacing="0" cellpadding="5">
	<tr>
    	<td valign="top"><strong>Property Address</strong></td>
    	<td><?PHP echo $data[legal_fault]?><br /><?PHP echo $data[address1]?><br /><?PHP echo $data[city]?>, <?PHP echo $data[state]?> <?PHP echo $data[zip]?></td>
	</tr>
	<tr>
    	<td><strong>Deposit to Bid</strong></td>
    	<td>$<?PHP echo $data[deposit]?>K</td>
	</tr>
	<tr>
    	<td><strong>File #</strong></td>
    	<td><?PHP echo $data[file]?></td>
	</tr>
	<tr>
    	<td valign="top"><strong>Publication Information</strong><br /><small>Primary Publication Only</small></td>
    	<td>Published in the <?PHP echo $data[paper]?>.<br />Starting on <?PHP echo $data[ad_start]?> for <?PHP echo $data[pub_dates]?>.<br /><?PHP if ($data[pub_cost_flag] == '3' || $data[pub_cost_flag] == ''){ ?>Total Cost: $<?PHP echo $data[ad_cost]?> <?PHP }?></td>
	</tr>
    <tr>
    	<td>Notes:</td>
        <td>
        <?PHP 
        $qn="SELECT * FROM portal_notes WHERE action_file = '$_GET[id]'";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){
		echo "$dn[action_on]: $dn[action]<br>";
		}
		?>
        
        
        </td>
    </tr>
	<tr>
    	<td><strong>Auctioneer Fee</strong></td>
    	<td><?PHP echo $data[auction_fee]?></td>
	</tr>
	<tr>
    	<td><strong>Invoice</strong></td>
    	<td>
		 <a href="invoice.php?uid=<?PHP echo $_GET[uid]?>&auction=<?PHP echo $data[schedule_id]?>">Invoice</a>
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

		
		
		$r67 = @mysql_query("select * from AVC where auction_id = '$_GET[id]' order by ad_id DESC");
while ($d67 = mysql_fetch_array($r67,MYSQL_ASSOC)){
 ?>

<?PHP echo $d67[saved_on];?>: <?PHP echo id2name($d67[user_id]);?> <a href="<?PHP echo washAdURI($d67[uri]);?>" target="_Blank"><small>view</small></a><br />

<?PHP }?>
        
        
        
        
        
        </td>
   </tr>
   <tr>
    	<td><em>Ad Number</em></td>
        <td><?PHP echo $data[ad_number]?></td>
   </tr>
      <tr>
    	<td><strong>Process Server Status</strong></td>
        <td>
        <?PHP
		mysql_select_db ('core');

        $q="SELECT * FROM ps_packets WHERE client_file = '$data[file]'";
		$r=@mysql_query($q) or die(mysql_error());
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if (!$d[process_status]){
		echo "This auction was not serviced by MDWestServe";
		} else {
		echo "Status: ".$d[process_status]." <a href='ps_details.php?id=$d[packet_id]&uid=$uid'>Details</a>";   
		}
		?>
        </td>
   </tr>
</table>    
</td>
<td valign="top">
  <h1>Access Log</h1>
        <?PHP 
		mysql_select_db ('intranet');
        $qn="SELECT *, DATE_FORMAT(stamp_date,'%b %e %h:%i%p') as stamp_date_f FROM portal_views WHERE auction_id = '$data[schedule_id]' order by stamp_date DESC";
		$rn=@mysql_query($qn);
		while ($dn=mysql_fetch_array($rn, MYSQL_ASSOC)){?>
		<?PHP echo $dn[stamp_date_f];?>:  <?PHP echo id2contact($dn[user_id]);?><br>
		<?PHP } ?>
</td></tr></table>
<?PHP

include 'footer.php';
?>

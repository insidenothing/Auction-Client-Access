<?
include 'header.php';
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Starting Auction Upload','client');

date_default_timezone_set('America/New_York');
$ip = $_SERVER['REMOTE_ADDR'];
$attid = $user[attorneys_id];
$id = $user[contact_id];
if ($_POST[submit]){
// ok first we need to go get the files
echo "<hr>";
//echo "<h2 align='center'>Transmitting $_POST[file] :: $_POST[last_fault]<br> ".$user[name]." ($ip)</h2>";
$path = "/data/auction/packets/";
if (!file_exists($path)){
	mkdir ($path,0777);
}
echo "<h1>Auction Packet Confirmation</h1>";
echo "<h2>Recieved: ".date('r')."</h2>";
echo "<h2>File Number: $_POST[file]</h2>";
echo "<h2>County: $_POST[county]</h2>";

$file_path = $path.$_POST[file]."-".$_POST[last_fault]."-".date('r');
if (!file_exists($file_path)){
	mkdir ($file_path,0777);
}
$target_path = $file_path."/". basename( $_FILES['upload1']['name']); 
//echo "$target_path<br>";
if(move_uploaded_file($_FILES['upload1']['tmp_name'], $target_path)) {
    echo "<h3>The Auctioneer Information Sheet '".  basename( $_FILES['upload1']['name']). 
    "' has been recieved.</h2>";
}

$link1 = "http://mdwestserve.com/portal/$target_path"; 


$target_path = $file_path."/". basename( $_FILES['upload2']['name']); 
//echo "$target_path<br>";

if ($_FILES['upload2']['tmp_name']){
	if(move_uploaded_file($_FILES['upload2']['tmp_name'], $target_path)) {
		echo "<h3>The Legal Description' ".  basename( $_FILES['upload2']['name']). 
		"' has been recieved.</h3>";
	}
}

$link2 = "http://mdwestserve.com/portal/$target_path"; 


$target_path = $file_path."/". basename( $_FILES['upload3']['name']); 
//echo "$target_path<br>";

if ($_FILES['upload3']['tmp_name']){
	if(move_uploaded_file($_FILES['upload3']['tmp_name'], $target_path)) {
		echo "<h3>The First Page of DOT' ".  basename( $_FILES['upload3']['name']). 
		"' has been recieved.</h3>";
	}
}
echo "<hr><div>Send another packet? Just use the form below...</div>";

$link3 = "http://mdwestserve.com/portal/$target_path"; 


// ok now we have the files let's update the database
 echo "<a href='$link1'>$link1</a><br><a href='$link2'>$link2</a><br><a href='$link3'>$link3</a><br>";

//@mysql_query("INSERT INTO ad_packets (date_recieved, file, county, attach1, attach2, attach3, attorneys_id, contact, ip, status) values (NOW(), '$_POST[file]', '$_POST[county]', '$link1', '$link2', '$link3', '$attid', '$id', '$ip', 'NEW')");

		$q1 = "INSERT INTO schedule_items (irs,requested_date, inst, pl90, dot_rate, dot_from, dot_to, gr_date, gr_month1, gr_month2, dot, dot_date, dot_position, liber, folio, lat, lng, pub_dates, featured, trust_type, location_id, requested_by, private, attorneys_id, notes, ad_cost, last_fault, legal_fault, sub_trust, notary_exp, paper, county, sort_time, state, zip, item_date, item_datetime, sale_date, sale_time, item_status, item_prefix, address1, city, court, file, created_id, deposit, ad_start, ground_rent, case_no, loan_type, principal,attach1, attach2, attach3,autoStatus) VALUES ('$_POST[irs]','$_POST[requested_date]', '$_POST[inst]', '$_POST[pl90]', '$_POST[dot_rate]', '$_POST[dot_from]', '$_POST[dot_to]', '$_POST[gr_date]', '$_POST[gr_month1]', '$_POST[gr_month2]', '$dot', '$_POST[dot_date]', '$_POST[dot_position]', '$_POST[liber]', '$_POST[folio]', '$lnl[2]', '$lnl[3]', '$pub_dates', '$_POST[featured]', '$trust_type', '1', '$requested_by', '$private', '$user[attorneys_id]', '$notes', '$ad_cost', '$last_fault', '$legal_fault', '$sub_trust', '$notary_exp', '$paper',  '$_POST[county]', '$sort_time', '$state', '$zip', NOW(), NOW(), '$finaldate', '$finaltime', 'ON SCHEDULE', '$prefix', '$address', '$city', '$court', '$_POST[file]', '$user_id', '$deposit', '$ad_start', '$_POST[ground_rent]', '$_POST[case_no]', '$_POST[loan_type]', '$_POST[principal]', '$link1', '$link2', '$link3','NEW' )";	
		$r1 = @mysql_query ($q1) or die(mysql_error());	

		$newID = mysql_insert_id();
		echo  "<h1>Auction #$newID AutoStarted</h1>";
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Confirmed Auction Upload '.$newID,'client');

addNote($newID,$user[name].': Auto-Started on '.date('m/d/Y'));
			
			
			$print .= date("F d Y H:i:s.")." : Portal upload started\n";
			$print .= date("F d Y H:i:s.")." : Uploaded by ".$user[name]." \n";
			$print .= date("F d Y H:i:s.")." : New Auction ID $newID \n";
			$print .= date("F d Y H:i:s.")." : Portal upload complete\n";
	
			
			
			mail('hwa.archive@gmail.com',$user[name].': NEW ORDER FOR '.$_POST['file'],addslashes($print));

//portal_log("Sent Ad Packet for $_POST[file] / $_POST[last_fault]", $user[contact_id]);
		mysql_select_db ('core');
        $qps="SELECT *, DATE_FORMAT(date_received,'%b %e %h:%i%p') as date_received_f FROM ps_packets WHERE client_file = '".$_POST[file]."'";
		$rps=@mysql_query($qps) or die(mysql_error());
		while ($dps=mysql_fetch_array($rps, MYSQL_ASSOC)){
			echo "<fieldset><legend><a href='ps_details.php?id=$dps[packet_id]&uid=".$_GET[uid]."'>Load Service Packet $dps[packet_id]</a></legend><li>Received on $dps[date_received_f]</li>
			<li>Service Status: <strong>$dps[service_status]</strong></li></fieldset>";
		}
}
?>
<div style="font-size:24px; text-align:center">Direct Auction Packet Transfer</div>
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<table align="center">
	<tr>
    	<td>File Number</td>
    	<td><input name="file"></td>
	</tr>
	<tr>
    	<td>Auction Date</td>
    	<td><input name="requested_date"> (requested)</td>
	</tr>
	<tr>
    	<td>IRS Lien?</td>
    	<td><input type='checkbox' name="irs"> Requires 30 Day Notice</td>
	</tr>
	<tr>
    	<td>County</td>
    	<td><select name="county">			<option>ALLEGANY</option>
			<option>ANNE ARUNDEL</option>
			<option>BALTIMORE</option>
			<option>BALTIMORE CITY</option>
			<option>CALVERT</option>
			<option>CAROLINE</option>
			<option>CARROLL</option>
			<option>CECIL</option>
			<option>CHARLES</option>
			<option>DORCHESTER</option>
			<option>FREDERICK</option>
			<option>GARRETT</option>
			<option>HARFORD</option>
			<option>HOWARD</option>
			<option>KENT</option>
			<option>MONTGOMERY</option>
			<option>PRINCE GEORGES</option>
			<option>QUEEN ANNES</option>
			<option>ST MARYS</option>
			<option>SOMERSET</option>
			<option>TALBOT</option>
			<option>WASHINGTON</option>
			<option>WASHINGTON D.C.</option>
			<option>WICOMICO</option>
			<option>WORCESTER</option>
</select></td>
	</tr>
	<tr>
    	<td>Auctioneer Information Sheet</td>
    	<td><input size="60" name="upload1" type="file" /></td>
	</tr>
	<tr>
    	<td>Legal Description</td>
    	<td><input size="60" name="upload2" type="file" /></td>
	</tr>
	<tr>
    	<td>First Page of DOT</td>
    	<td><input size="60" name="upload3" type="file" /></td>
	</tr>
	<tr>
    	<td colspan="2" align="right"><input type="submit" name="submit" value="Send Packet" /></td>
	</tr>
</table>
<div align="center" style="font-size:12px">Please Only Send Files In .DOC or .PDF Format.</div>
</form>
<?
include 'footer.php';
?>

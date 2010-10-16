<?
include 'header.php';
hardLog($user[name].' Started Package Upload','user');

$ip = $_SERVER['REMOTE_ADDR'];
$attid = $user[attorneys_id];
$id = $user[contact_id];
if ($_POST[submit]){
// ok first we need to go get the files
echo "<hr>";
//echo "<h2 align='center'>Transmitting $_POST[file] :: $_POST[last_fault]<br> ".$user[name]." ($ip)</h2>";
$path = "/var/www/dataFiles/auction/packets/";
if (!file_exists($path)){
	mkdir ($path,0777);
}
echo "<h1>Auction Packet Confirmation</h1>";
echo "<h2>Recieved: ".date('r')."</h2>";
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

$link3 = "http://mdwestserve.com/portal/$target_path"; 



//@mysql_query("INSERT INTO ad_packets (date_recieved, file, county, attach1, attach2, attach3, attorneys_id, contact, ip, status) values (NOW(), '$_POST[file]', '$_POST[county]', '$link1', '$link2', '$link3', '$attid', '$id', '$ip', 'NEW')");

		$q1 = "INSERT INTO schedule_items (attach1,autoStatus,attorneys_id,item_date, item_datetime) VALUES ('$link1','PACKAGE','1',NOW(),NOW())";	
		$r1 = @mysql_query ($q1) or die(mysql_error());	

		$newID = mysql_insert_id();
		echo  "<h1>Package #$newID received.</h1>";

addNote($newID,$user[name].': Auto-Started on '.date('m/d/Y'));
			
			
			$print .= date("F d Y H:i:s.")." : Portal upload started\n";
			$print .= date("F d Y H:i:s.")." : Uploaded by ".$user[name]." \n";
			$print .= date("F d Y H:i:s.")." : New Package ID $newID \n";
			$print .= date("F d Y H:i:s.")." : Portal upload complete\n";
	
			hardLog($user[name].' Confirmed Burson Package Upload '.$newID,'user');

			
			mail('hwa.archive@gmail.com',$user[name].': NEW ORDER PACKAGE '.$_POST['file'],addslashes($print));
			mail('mpollard@logs.com','NEW ORDER CONFIRMED '.$_POST['file'],addslashes($print));
			mail('ekelly@logs.com','NEW ORDER CONFIRMED '.$_POST['file'],addslashes($print));
echo "<hr><div>Send another packet? Just use the form below...</div>";
}
?>

<div style="font-size:24px; text-align:center">Direct Auction Transfer</div>
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<table align="center">
	<tr>
    	<td>Zip File or Single File</td>
    	<td><input size="60" name="upload1" type="file" /></td>
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

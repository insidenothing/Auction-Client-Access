<?PHP
include 'header.v2.php';
function email2id($email){
	$r=@mysql_query("select user_id from ps_users where email = '$email'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC);
return $d[contact_id];
}
function pushProof($id,$ip){
	$file = $id.'.ps';
	$remote_file = $id.'.ps';
	if ($conn_id = ftp_connect($ip)) {
		//echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";
	} else { 
		//echo "Couldn't change directory\n";
		mail('insidenothing@gmail.com','AUCTION CANCEL: PRINTER CONNECT','Couldn\'t connect');
		error_log(date('r')." $ip WARNING: Couldn't connect. \n", 3, '/logs/printer.log');
		return 'fail';
	}
	$login_result = ftp_login($conn_id, 'alpha', 'beta');
	ftp_pasv($conn_id, true);
	if (ftp_chdir($conn_id, "PORT1")) {
		//echo "Current directory is now: " . ftp_pwd($conn_id) . "\n";
	} else { 
		//echo "Couldn't change directory\n";
		mail('insidenothing@gmail.com','AUCTION CANCEL: PRINTER CHDIR','Couldn\'t change directory');
		error_log(date('r')." $ip WARNING: Couldn't change ftp directory for auction $id cancellation. \n", 3, '/logs/printer.log');
	}
	if (ftp_put($conn_id, $remote_file, $file, FTP_BINARY)) {
		//echo "successfully uploaded $file\n";
		$last_line = system('rm -f '.$id.'.ps', $retval);
		$last_line = system('rm -f '.$id.'.html', $retval);
		error_log(date('r')." $ip NOTICE: Auction $id cancellation printed successfully. \n", 3, '/logs/printer.log');
	} else {
		//echo "There was a problem while uploading $file\n";
		mail('insidenothing@gmail.com','AUCTION CANCEL: PRINTER PUT','There was a problem while uploading '.$file);
		error_log(date('r')." $ip ERROR: There was a problem while uploading $id cancellation. \n", 3, '/logs/printer.log');
		return 'fail';
	}
	ftp_close($conn_id);
}
function pullProof($id){ 
	$url = "http://staff.hwestauctions.com/cancel_report.php?id=$id";
	$timeout=5;
    $curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}
function buildProof($id){
	$buffer = pullProof($id);
	$myFile = "$id.html";
	$fh = fopen($myFile, 'w') or die("can't open file");
	fwrite($fh, $buffer);
	fclose($fh);
	passthru('/usr/local/bin/html2ps '.$id.'.html > '.$id.'.ps');
	
	
	
	if(pushProof($id,'72.4.227.230') == 'fail'){
		pushProof($id,'72.4.227.229');
	}

	
	}
$userID = $_COOKIE['user_id'];
if ($_GET[go] && $userID){
//error_log("cancel.v2.php:good: [Auction $_GET[go]] [".date('h:iA n/j/y')."] [Name: ".$user[name]."] - [ID: ".$userID."] - [AttID: ".$user[attorneys_id]."] - [Email: ".$user[email]."] [IP: ".$_SERVER["REMOTE_ADDR"]."] \n", 3, '/logs/error.log');
talk('allstaff',$user[name].' from '.id2attorneys($user[attorneys_id]).' cancelled auction '.$_GET[go]);

	$ip = $_SERVER['REMOTE_ADDR'];
	@mysql_query("UPDATE schedule_items SET pending_cancel='1', pending_by='".$_COOKIE['user_id']."', pending_on=NOW(), closed_datetime=NOW(), pending_ip='$ip' WHERE schedule_id='$_GET[go]'");


	portal_log("Requesting cancellation for auction $_GET[go]", $userID);
	portal_note("$user[name] Requesting cancellation",$_GET[go]);
	pub_cost_flag("CANCEL","$_GET[go]",$_POST[ad_cost]);
	//buildProof($_GET[go]);
	$q = "SELECT *, DATE_FORMAT(item_datetime,'%M %D, $Y at %l:%i%p') as item_datetime_f, DATE_FORMAT(item_date,'%M %D, $Y at %l:%i%p') as item_date_f, DATE_FORMAT(update_date,'%M %D, $Y at %l:%i%p') as update_date_f FROM schedule_items WHERE schedule_id = '$_GET[go]'";		
	$r = @mysql_query ($q) or die(mysql_error());
	$data = mysql_fetch_array($r, MYSQL_ASSOC);
} elseif($_GET[go] && $user[contact_id] == ''){
//error_log("cancel.v2.php:bad: [Auction $_GET[go]] [".date('h:iA n/j/y')."] [Name: ".$user[name]."] - [ID: ".$userID."] - [AttID: ".$user[attorneys_id]."] - [Email: ".$user[email]."] [IP: ".$_SERVER["REMOTE_ADDR"]."] \n", 3, '/logs/error.log');

	header('Location: http://hwa1.hwestauctions.com'); // kick user out if they don't have a contact_id
}else{
//error_log("cancel.v2.php:start: [Auction $_GET[id]] [".date('h:iA n/j/y')."] [Name: ".$user[name]."] - [ID: ".$userID."] - [AttID: ".$user[attorneys_id]."] - [Email: ".$user[email]."] [IP: ".$_SERVER["REMOTE_ADDR"]."] \n", 3, '/logs/error.log');

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
<?PHP if (!$_GET[go]){
if ($user[attorneys_id] == 1){
	//recordEvent("Prompt: $user[name] are you sure you want to cancel the auction for: $data[file], $data[address1] on $data[sale_date]");
}
?>
<div style="font-size:22px">
Auction # <?PHP echo $_GET[id]?><br />
<br />
Are you sure you<small>(id#<?php echo $userID;?>)</small> want to cancel the auction for:<br />
File <?PHP echo $data[file]?>, <?PHP echo $data[address1]?> on <?PHP echo $data[sale_date]?>.<br />
<br />
<br />
<a href="?go=<?PHP echo $_GET[id]?>">[Request Cancellation]</a> or <a href="simpleDetails.v2.php?id=<?PHP echo $_GET[id]?>">[Take Me Back to Auction Details]</a>
</div>
<?PHP }else{ 
if ($user[attorneys_id] == 1){
	recordEvent("$user[name] confirmed request to cancel the auction for: $data[file], $data[address1] on $data[sale_date]");
}
?>
<div style="font-size:22px">
Cancellation Request Recieved for Auction # <?PHP echo $_GET[go]?><br />
<br />
File <?PHP echo $data[file]?>, <?PHP echo $data[address1]?> on <?PHP echo $data[sale_date]?>.<br />
<br />
<br />
<a href="simpleDetails.v2.php?id=<?PHP echo $_GET[go]?>">[Take Me Back to Auction Details]</a>
</div>

<?PHP }?>

<?PHP include 'footer.v2.php'; ?>
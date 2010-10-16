<?
include 'header.php';

function smtpMail($t,$subject,$html){
//	error_reporting(E_ALL); 
	define('DISPLAY_XPM4_ERRORS', false); 
	require_once '/opt/lampp/htdocs/smtp/SMTP.php';
	$f = 'service@hwestauctions.com';
	$user = 'pmcguire@hwestauctions.com';
	$p = 'patrick';
	$m = 'From: '.$f."\r\n".
		 'To: '.$t."\r\n".
		 'Subject: '.$subject."\r\n".
		 'Content-Type: text/html'."\r\n\r\n".
		 '<body>'.$html.'</body>';
	$c = fsockopen('mail.hwestauctions.com', 25, $errno, $errstr, 20) or die($errstr);
	if (!SMTP::recv($c, 220)) die(print_r($_RESULT));
	if (!SMTP::ehlo($c, 'hwa1.hwestauctions.com')) SMTP::helo($c, 'hwa1.hwestauctions.com') or die(print_r($_RESULT));
	if (!SMTP::auth($c, $user, $p, 'login')) SMTP::auth($c, $user, $p, 'plain') or die(print_r($_RESULT));
	SMTP::from($c, $f) or die(print_r($_RESULT));
	SMTP::to($c, $t) or die(print_r($_RESULT));
	SMTP::data($c, $m) or die(print_r($_RESULT));
	SMTP::quit($c);
	@fclose($c);
}


$ip = $_SERVER['REMOTE_ADDR'];
$attid = $user[attorneys_id];
$id = $user[contact_id];

if ($_POST[case_no] && $_POST[client_file]){//c1
	@mysql_query("insert into ps_file_array (name, type, size, tmp_name, error, uploadDate) values ('".$_FILES['otd']['name']."','".$_FILES['otd']['type']."','".$_FILES['otd']['size']."','".$_FILES['otd']['tmp_name']."','".$_FILES['otd']['error']."', NOW() )") or die(mysql_error());
	$q="SELECT case_no from ps_packets where case_no = '$_POST[case_no]'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if (!$d[case_no]){//c2
	
	// check file size and error out
	
	if ($_FILES['otd']['size'] < 188743680){//c3
		if ($_FILES['otd']['size'] == 0){//c4
			$error = "<div>Upload Failed : Browser Error (Contact your IT Department)</div>";
			mail('sysop@hwestauctions.com','failed upload 0 size',$_COOKIE[psdata][user_id]);
		}else{//c4
			// ok first we need to go get the files
			$html = "<hr>";
			//echo "<h2 align='center'>Transmitting $_POST[file] :: $_POST[last_fault]<br> ".$user[name]." ($ip)</h2>";
			$path = "PS_PACKETS/";
			if (!file_exists($path)){//c5
				mkdir ($path,0777);
			}//c5
			$html .= "<h1>Process Server Packet Confirmation</h1>";
			$html .= "<h2>Recieved: ".date('r')."</h2>";
			$html .= "<h2>Case: $_POST[case_no]</h2>";
			$html .= "<h2>Size: ".$_FILES['otd']['size']."</h2>";
			$file_path = $path.$_POST[case_no]."-".date('r');
			if (!file_exists($file_path)){//c6
				mkdir ($file_path,0777);
			}//c6
			$target_path = $file_path."/". basename( $_FILES['otd']['name']); 
			//echo "$target_path<br>";
			if(move_uploaded_file($_FILES['otd']['tmp_name'], $target_path)) {//c7
				$html .= "<h3>Process Serving Packet '".  basename( $_FILES['otd']['name'])."' has been recieved.</h2>";
			}//c7
			$link1 = "http://portal.hwestauctions.com/portal/$target_path"; 
			$html2 .= $html."<hr><div>Send another packet? Just use the form below... </div>";
			echo $html2;
			$notes = $_POST[attorney_notes];
			$attorney_notes = addslashes($notes);
			$query = "INSERT INTO ps_packets (date_received, case_no, otd, attorneys_id, contact, ip, status, attorney_notes, client_file) values (NOW(), '$_POST[case_no]', '$link1', '$attid', '$id', '$ip', 'NEW', '$attorney_notes', '$_POST[client_file]')";
			@mysql_query($query) or die(mysql_error());
			//echo "$query ".mysql_error();
			portal_log("Sent PS Packet for $_POST[case_no]", $user[contact_id]);
			mail('sysop@hwestauctions.com','file uploaded to data entry by '.$user[name],$_COOKIE[psdata][user_id]);
		}//c4
	}else{//c3
		$error = "<div>Your file size was to large, contact 410-769-9797 for assistance.</div>";
		mail('sysop@hwestauctions.com','failed upload too large',$_COOKIE[psdata][user_id]);
		//smtpMail('service@hwestauctions.com','New Process Serving Packet',$html);
	}//c3
	}else{//c2
		$error = "<div>We already have this file.</div>";
		mail('sysop@hwestauctions.com','failed upload duplicate case number ( '.$_POST[case_no].' ) by '.$user[name],$_COOKIE[psdata][user_id]);
	}//c2
}//c1
if ($error){
?>

<div align="center" style="font-size:22px; border:double; padding:5px; background-color:#FF0000 "><?=$error?></center>
<? }?>


<div style="font-size:24px; text-align:center">Direct Process Server Packet Transfer</div>
<form enctype="multipart/form-data" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="100000000" />
<table align="center">
	<tr>
    	<td>Case Number</td>
    	<td><input name="case_no"></td>
	</tr>
	<tr>
    	<td>File Number</td>
    	<td><input name="client_file"></td>
	</tr>
	<tr>
    	<td>Process Serving Packet</td>
    	<td><input size="60" name="otd" type="file" /></td>
	</tr>
    <tr>
    	<td>Special Instructions<br />(Sent directly to Process Server)</td>
        <td><textarea cols="45" rows="4" name="attorney_notes"></textarea></td>
    </tr>
	<tr>
    	<td colspan="2" align="right"><input type="submit" name="submit" value="Send Packet" /></td>
	</tr>
</table>

</form>


<FIELDSET>
  <LEGEND ACCESSKEY=C>Persons to Serve</LEGEND>


<FIELDSET>
  <LEGEND ACCESSKEY=C>Persons to Serve</LEGEND>
  <P>
<table>
	<tr>
    	<td>Defendant 1</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>Defendant 2</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>Defendant 3</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>Defendant 4</td>
    	<td><input /></td>
	</tr>
</table>
  </P>
</FIELDSET>


<FIELDSET>
  <LEGEND ACCESSKEY=C>Property Subject to Motrgage or Deed of Trust</LEGEND>
  <P>
<table>
	<tr>
    	<td>Street Address</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>City</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>State</td>
    	<td><input /></td>
	</tr>
	<tr>
    	<td>ZIP code</td>
    	<td><input /></td>
	</tr>
</table>    
  </P>
</FIELDSET>
</FIELDSET>
</div>

<?
include 'footer.php';
?>

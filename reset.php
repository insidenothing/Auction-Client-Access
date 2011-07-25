<?PHP
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');

function mkPass(){
	return rand(1000,9999);
}

if (isset($_POST['email'])){
	$email = $_POST['email'];
	$pass = mkPass();
	mysql_select_db('intranet');
	$q="SELECT * FROM contacts WHERE email = '$email'";
	$r=@mysql_query($q) or die(mysql_error());
	if ($data = mysql_fetch_array($r, MYSQL_ASSOC)){

	mysql_select_db('intranet');
	@mysql_query("UPDATE contacts SET password ='$pass' WHERE email = '$email'");
	mysql_select_db('intranet');
	
	portal_log("(LOCAL)Password reset for $email", $data['contact_id']);

	$body = "Harvey West Auctioneers password has arrived!<br>
			You can log in at http://poeral.hwestauctions.com/login.php<br>
			E-Mail Address: $email<br>
			Password: $pass<br><br>
			
			Thank you,<br>
			Patrick McGuire<br>patrick@mdwestserve.com";
			$subject = "New HWA Portal Password";
			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
			$headers .= "From: HWA Portal <westads@hwestauctions.com> \n";
			$headers .= "Bcc: Account Archive <hwa.archive@gmail.com> \n";
			mail($email,$subject,$body,$headers);
		$status = "Your New Password Was Sent To $_POST[email], In 5 seconds I will redirect you to the login page.";
                $status .= "<meta http-equiv='refresh' content='5;url=http://portal.hwestauctions.com/login.php'> ";
	}else{
		$status = "$_POST[email] Not Found, Contact service@mdwestserve.com For Help";
	}

}
if (isset($status)){
?>
<h1 align="center"><?PHP echo $status?></h1>
<?PHP }?>
<div align="center" style="font-size:20px">Please enter your email address below to have your new password sent.</div> 
<br /><br />
<form method="post">
<table align="center">
	<tr style="font-size:20px">
    	<td>E-Mail Address: </td>
    	<td> <input name="email" size="50"></td>
	</tr>
    <tr>
    	<td colspan="2" align="center"><br /><br /><input type="submit" name="submit" value="Click Here to Send Password" /></td>
    </tr>
</table>
</form><br />
<div align="center" style="font-size:20px">Your password should arrive within 5 minutes.</div>



<br /><br /><center><a href="http://portal.hwestauctions.com/login.php">LOG IN HERE</a></center>

<?PHP
include 'footer.php';
?>

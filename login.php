<?PHP
session_start();
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');

if ((isset($_POST['email']) && $_POST['password']) || (isset($_GET['email']) && $_GET['password']) ){
	if ($_POST['email']){ $email = $_POST['email']; }else{ $email = $_GET['email'];}
	if ($_POST['password']){ $pass = $_POST['password'];}else{$pass = $_GET['password']; }
	mysql_select_db ('intranet');
	$q1 = "SELECT * FROM contacts WHERE email = '$email' AND password = '$pass'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	if ($data = mysql_fetch_array($r1, MYSQL_ASSOC)){
		$uid = uid($email,$pass);
		$ip=$_SERVER['REMOTE_ADDR'];


                        setcookie ("override", "datalink", $inTwoHours, "/", ".hwestauctions.com");
			setcookie ("psportal[contact_id]", $data['contact_id'], $inTwoHours, "/", ".hwestauctions.com");
			setcookie ("psportal[attorneys_id]", $data['attorneys_id'], $inTwoHours, "/", ".hwestauctions.com");
			setcookie ("psportal[name]", $data['name'], $inTwoHours, "/", ".hwestauctions.com");
			setcookie ("psportal[email]", $data['email'], $inTwoHours, "/", ".hwestauctions.com");
			setcookie ("psportal[debug]", date('h:iA n/j/y')." $user logged in using ".$_SERVER["REMOTE_ADDR"], $inTwoHours, "/", ".hwestauctions.com");

		portal_log("$data[name] Logged In ($uid)", $data[contact_id]);
   	        header ('Location: desktop.php');
	} else {
		mysql_select_db ('intranet');
		portal_log("Attempted Login by $email using $pass", 0);
		$error = "Invalid E-Mail Address and/or Password";
	}
}


?>
<table height="100%" width="900px" align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top"  bgcolor="#B4CDE2" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;">
<br />
<br />


<form method="post">
<table align="center" height="300" style="font-size:24px" cellpadding="10">
	<?PHP if (isset($error)){?>
	<tr bgcolor="#FFCC33">
		<td colspan="2" align="center"><?PHP echo $error;?></td>
	</tr>
	<?PHP }?>	
	<tr>
		<td>E-Mail Address</td>
		<td><input name="email" size="30"></td>
	</tr>	
	<tr>
		<td>Password</td>
		<td><input name="password" type="password"></td>
	</tr>		
	<tr>
		<td colspan="2" align="center"><input type="submit" name="submit" value="Log In"></td>
	</tr>	
	<tr> 
		<td colspan="2" align="center"><a style="text-decoration:none;" href="reset.php">Forgot Password</a></td>
	</tr>	
</table>
</form>
<?PHP
include 'footer.php';
?>
<center>
<?PHP
if ($_COOKIE['test']){
echo $_COOKIE['test'];
}else{
echo "Cookies Disabled";
error_out('Cookies Disabled');
}?>
</center>

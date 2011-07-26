<?PHP
include 'header.php';

if ($_POST[submit]){
$headers  = "MIME-Version: 1.0 \n";
$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
$headers .= "From: $_POST[name] <$_POST[email]> \n";
$headers .= "Cc: HWA Archive <hwa.archive@gmail.com> \n";
$headers .= "Cc: Zach <zach@hwestauctions.com> \n";
//portal_log("Sent IT Dept Email", $user[contact_id]);


mail("Patrick McGuire <pmcguire@hwestauctions.com>","Extranet Interface Feedback",addslashes($_POST[message]),$headers);


echo "<h3 align='center'>Thank you, your message has been sent.</h3>";
}
?>


<form method="post">
<input type="hidden" name="name" value="<?PHP echo $_COOKIE[psdata][name]?>">
<input type="hidden" name="email" value="<?PHP echo $_COOKIE[psdata][email]?>">
<table align="center">
	<tr>
		<td>To:</td>
		<td><strong><em>I.T. Department</em></strong></td>
	</tr>		
	<tr>
		<td>From:</td>
		<td><strong><em><?PHP echo $_COOKIE[psdata][name]?> &lt;<?PHP echo $_COOKIE[psdata][email]?>&gt;</em></strong></td>
	</tr>		
	<tr>
		<td>Subject:</td>
		<td><strong><em>Extranet Interface Feedback</em></strong></td>
	</tr>		
	<tr>
		<td colspan="2"><textarea cols="75" rows="8" name="message"></textarea></td>
	</tr>		
	<tr>
		<td colspan="2" align="right"><input type="submit" name="submit" value="Send" /></td>
	</tr>		
</table>


<?PHP
include 'footer.php';
?>

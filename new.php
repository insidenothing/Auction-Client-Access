
<?

include '../common/functions.php';
db_connect('hwa1.hwestauctions.com','intranet','','');

function mkPass(){
	return rand(1000,9999);
}

if ($_POST[submit]){
	$password = mkpass();
	$user = $_POST[user]."@".$_POST[domain]	
	@mysql_query("INSERT INTO contacts () values ()");
	$message = "Your account has been created. your username on file is $user and your password is $pass, you should write this information down.";
}



?>




<table> 
<form method="post">
	<tr>
    	<td colspan="2">Create New Portal Account</td>
	</tr>
    <tr>
    	<td>E-Mail Address</td>
    	<td><input name="user" />@<select name="domain"><option>SIWPC.COM</option><option>LOGS.COM</option><option>DRAPGOLD.COM</option></select></td>
	</tr>
    <tr>
    	<td>Name</td>
    	<td><input name="name" /></td>
	<tr>
    <tr>
    	<td>Phone</td>
    	<td><input name="phone" /></td>
	<tr>
    	<td colspan="2"><input type="submit"></td>
	</tr>
</form>
</table> 












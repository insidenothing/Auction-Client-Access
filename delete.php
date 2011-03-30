<?
//this file will delete a user
include '../common/functions.php';
mysql_connect();
mysql_select_db('intranet');

if ($_POST[submit]){
	$email = $_POST[email];
	$q="delete FROM contacts WHERE email = '$email'";
	$r=@mysql_query($q) or die(mysql_error());
		$status .= "<script>
		function automation() {
  window.opener.location.href = window.opener.location.href;
  if (window.opener.progressWindow)
		
 {
    window.opener.progressWindow.close()
  }
  window.close();
}

automation();
</script>";

}


echo $status;


?>

<?php

// build $user array from cookie
$inTwoHours = time() + 7200;

if (isset($_COOKIE['psportal']['contact_id'])){
	mysql_connect();
	mysql_select_db ('intranet');
	$q1 = "SELECT * FROM ps_users WHERE id = '".$_COOKIE['psportal']['contact_id']."'";
	$r1 = @mysql_query ($q1) or hardLog(mysql_error(),'client');
	$user = mysql_fetch_array($r1, MYSQL_ASSOC);
	setcookie ("portal[name]", $user['email'], $inTwoHours, "/", ".hwestauctions.com");
}





if (empty($user['name'])){
	?>
	
	<script>
	window.open('http://hwestauctions.com/login/dologout','_Parent');
	</script>
	
	<?php 
}


?>
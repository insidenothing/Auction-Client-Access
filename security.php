<?

// build $user array from cookie
if ($_COOKIE['psportal']['contact_id']){
mysql_connect();
mysql_select_db ('intranet');
$q1 = "SELECT * FROM ps_users WHERE user_id = '".$_COOKIE['psportal']['contact_id']."'";
$r1 = @mysql_query ($q1) or hardLog(mysql_error(),'client');
$user = mysql_fetch_array($r1, MYSQL_ASSOC);
setcookie ("portal[name]", $user['email'], $inTwoHours, "/", ".hwestauctions.com");
}





if (!$user[name]){
hardLog(' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
header('Location: http://hwestauctions.com');
}


?>
<?
if(!$_COOKIE[psportal][debug]){

if (!$_GET[uid]){
if (!$_POST[uid]){
portal_log("Security Active :: UID Not Found", 0);
header ('Location: http://hwestauctions.com?logout=noUID');
}
}
if ($_GET[uid]){
mysql_connect();
mysql_select_db ('intranet');
$q1 = "SELECT * FROM contacts WHERE uid = '$_GET[uid]'";
$r1 = @mysql_query ($q1) or die(mysql_error());
$user = mysql_fetch_array($r1, MYSQL_ASSOC);
$uid = $_GET[uid];
}

}else{ // build $user array from cookie
mysql_connect();
mysql_select_db ('intranet');
$q1 = "SELECT * FROM contacts WHERE contact_id = '".$_COOKIE[psportal][contact_id]."'";
$r1 = @mysql_query ($q1) or hardLog(mysql_error(),'client');
$user = mysql_fetch_array($r1, MYSQL_ASSOC);
setcookie ("portal[name]", $user[email], $inTwoHours, "/", ".hwestauctions.com");
}

if (!$user[name] && $_COOKIE[override] == "datalink"){
$user = array(
'name' => $_COOKIE[psportal][name],
'attorneys_id' => $_COOKIE[psportal][attorneys_id],
'email' => $_COOKIE[psportal][email]
);

}
if (!$user[name]){
hardLog(' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
header('Location: http://hwestauctions.com?logout=noUSER');
}


?>
<?PHP

if (isset($_COOKIE['psportal']['name'])){
$user = array(
'name' => $_COOKIE['psportal']['name'],
'contact_id' => $_COOKIE['psportal']['contact_id'],
'user_admin' => $_COOKIE['psportal']['user_admin'],
'attorneys_id' => $_COOKIE['psportal']['attorneys_id'],
'email' => $_COOKIE['psportal']['email']
);

}




if (!$user['name']){
 hardLog(' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
 header('Location: http://portal.hwestauctions.com/login.php');
}
?>
<?PHP
if (!$user[name]){
 hardLog(' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
 header('Location: http://portal.hwestauctions.com/login.php');
}
?>
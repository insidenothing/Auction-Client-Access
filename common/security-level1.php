<?
// this file will kick users out of admin access areas
if ($_COOKIE[userdata][isadmin] != "1"){
	log_action($_COOKIE[userdata][user_id],"Failed attempt to access Security Level 1");
	header ('Location: http://random.yahoo.com/bin/ryl');
}
?>
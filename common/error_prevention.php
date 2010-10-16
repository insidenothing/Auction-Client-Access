<?
/* 
When included this file will check the session data for the user level, if set to viewer we will close the edit window. 
It only works with the pop-up windows!
You must call functions before this file!


*/
if (!$_COOKIE['userdata']['status']){
reportError($_SERVER['PHP_SELF']."/".$_SERVER['QUERY_STRING'], 'Missing session data for view only check.');

}
if ($_COOKIE['userdata']['status'] == "View Only"){
	reportError($_SERVER['PHP_SELF']."/".$_SERVER['QUERY_STRING'], 'attempting to access view only page, window closed.');
	echo "<script>alert('View Only.'); window.close();</script>";
} else {
//	echo "<script>alert('Ok to edit.');< /script>";
}

?>
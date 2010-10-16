<?
/* 
When included this file will check the session data for the user level, if set to viewer we will close the edit window. 
It only works with the pop-up windows!
You must call functions before this file!


*/
if (!$_COOKIE['userdata']['status']){
reportError($_SERVER['PHP_SELF']."/".$_SERVER['QUERY_STRING'], 'Missing cookie for view only check.');

}
if ($_COOKIE['userdata']['status'] == "View Only"){
	reportError($_SERVER['PHP_SELF']."/".$_SERVER['QUERY_STRING'], 'attempting to access view only page, redirected to index.');
	echo "<script>alert('View Only.'); window.location.href='index.php';</script>";
} else {
//	echo "<script>alert('Ok to edit.');< /script>";
}

?>
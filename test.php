<?
session_start();
setcookie ("id", "cookie");
$_SESSION[id] = "session";
echo "<div style='font-size:24px;'>";
if ($_GET[go]){
echo "Testing Cookie Data: ";
if ($_COOKIE[id]){ 
	echo "Passed<br>"; 
}else{ 
	echo "Failed<br>"; 
	echo "<a href='http://www.google.com/cookies.html' target='_blank'>For help with cookies click here.</a><br>";
}
echo "Testing Session Data: ";

if ($_SESSION[id]){ 
	echo "Passed<br>"; 
}else{ 
	echo "Failed<br>"; 
	echo "<a href='login.php'>For help with session data click here.</a><br>";
}

echo "<a href='login.php'>Click Here To Log In</a><br>";
echo "<a href='?go=2'>Click Here To Run Test Again</a><br>";
}else{
?>
<a href="?go=1">Click Here To Start Test</a>
<? }?>

<?
function uid(){
	return md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
}
?>

[Custom ID String]<br />
<?=uid()?>



</div>
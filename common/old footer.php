<div align="center"><?
if ($_GET[page]){
$page = $_GET[page].".php";
}else{
$page = $_SESSION[view].".php";
}
$last_modified = filemtime($page);
$last_modified = date("l, F dS, Y @ h:ia", $last_modified);
$c = count($pages);
$c = $c+1;
if ($_GET[debug]){
	$_SESSION[debug] = "1";
} else {
	$_SESSION[debug] = "2";
}
if ($_SESSION[debug] == "1"){
$qs = str_replace('&debug=1','',$_SERVER['QUERY_STRING']);
echo "<a style='font-size:16px; color:#FFFFFF; text-align:center; font-weight:bold; text-decoration:none' href=".$_SERVER['PHP_SELF']."?".$qs.">$page updated on $last_modified</a>";	
} else {
echo "<a style='font-size:16px; color:#FFFFFF; text-align:center; font-weight:bold; text-decoration:none' href=".$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']."&debug=1>$page updated on $last_modified</a>";	
}
// we will now process in the footer since it is the last page to load
?>
</div>
<? if ($_GET[debug]){ ?>
<table border="1" bgcolor="#FF0000" align="center" style="border-collapse:collapse; position:absolute; top:300px; left:5
0px">
	<tr>
		<td>Sesson Data</td>
		<td>Cookie Data</td>
		<td>Get Values</td>
		<td>Post Values</td>
	</tr>
	<tr>
		<td valign="top" style="text-align:left">
<?
foreach ($_SESSION as $key => $value)
{
		echo $key." - ".$value."<br>";
}
?>
		</td><td valign="top" style="text-align:left">
<?
foreach ($_COOKIE as $key => $value)
{
		echo $key." - ".$value."<br>";
}
?>
		</td><td valign="top" style="text-align:left">
<?
foreach ($_GET as $key => $value)
{
		echo $key." - ".$value."<br>";
}
?>
		</td><td valign="top" style="text-align:left">
<?
foreach ($_POST as $key => $value)
{
		echo $key." - ".$value."<br>";
}
?>
		</td>
	</tr>
	<tr>
    	<td colspan="4"><form method="post" target="_blank" action="query.php"><input name="query" size="100" /><input type="submit" /></form>
        </td>
    </tr>
</table>
<? }
if ($_COOKIE[userdata][user_id] == "1"){
?>
<form method="post" target="_blank" action="query.php"><table width="100%"><tr><td>
<input name="query" size="100" /><input type="submit" /></td></tr></table></form>
<? }?>
<div align="center"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">
<img alt="Creative Commons License" style="border-width:0" src="http://creativecommons.org/images/public/somerights20.png" />
</a>
<br />This work is licensed under a 
<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/us/">Creative Commons Attribution-Share Alike 3.0 United States License</a>.</div>
</body>
</html>

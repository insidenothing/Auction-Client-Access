<?
session_start();
if ($_GET['date']){ $_SESSION['holddate'] = $_GET['date']; } 
$starttime = microtime();
$startarray = explode(" ", $starttime);
$starttime = $startarray[1] + $startarray[0];
$q = "Select style from users where user_id='".$_COOKIE[userdata][user_id]."'";
$r = @mysql_query($q);
$d = mysql_fetch_array($r, MYSQL_ASSOC);
echo "<style>body{".$d[style]."}</style>";
?>
<style>
#loading {
 	width: 200px;
 	height: 100px;
 	background-color: #c0c0c0;
 	position: absolute;
 	left: 50%;
 	top: 50%;
 	margin-top: -50px;
 	margin-left: -100px;
 	text-align: center;
}
</style>
<? ob_start();?>
<script>
var message="";
///////////////////////////////////
function clickIE() {if (document.all) {(message);hideshow(document.getElementById('core'));return false;}}
function clickNS(e) {if 
(document.layers||(document.getElementById&&!document.all)) {
if (e.which==2||e.which==3) {(message);hideshow(document.getElementById('core'));return false;}}}
if (document.layers) 
{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
document.oncontextmenu=new Function("return false")
</script>
<SCRIPT SRC="/javascript/common.js" language="JavaScript1.2"></SCRIPT>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href='/ps/gfx/favicon.gif' TYPE='image/gif' REL='icon'>
<link href="common/new.css" rel="stylesheet" type="text/css" />
</head>
<? $bgcolor= strtoupper(color());?>
<body bgcolor="<?=$bgcolor?>">
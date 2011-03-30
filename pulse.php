<? 
include_once '../common/functions.php';
mysql_connect();
mysql_select_db('intranet');

$q1 = "SELECT * FROM contacts WHERE uid = '$_GET[uid]'";		
$r1 = @mysql_query ($q1) or die(mysql_error());
$user = mysql_fetch_array($r1, MYSQL_ASSOC);

?>
<meta http-equiv="refresh" content="10" />
<style>
body
	{
	padding:0px;
	margin:0px;
	font-size:9px;
	}
</style>
<body>
<?
// ok we are ready to set up the im_db
$q="SELECT * FROM client_im WHERE (from_id = '$user[contact_id]' OR to_id = '$user[contact_id]') AND ack = '1' ORDER BY im_id DESC";
$r=@mysql_query($q) or die(mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
echo "PING";
if ($d[to_id] == $user[contact_id]){
$windowName = "IM".$d[from_id];
?>
<script language="JavaScript">
window.open('chat.php?im=<?=$d[im_id]?>&to=<?=$d[from_id]?>&uid=<?=$_GET[uid]?>','<?=$windowName?>','height=200,width=500');
</script>
<? 
}else{
$windowName = "IM".$d[to_id];
?>
<script language="JavaScript">
window.open('chat.php?im=<?=$d[im_id]?>&to=<?=$d[to_id]?>&uid=<?=$_GET[uid]?>','<?=$windowName?>','height=200,width=500');
</script>
<? 
} }
echo "<center>HEARTBEAT::".time()."::$user[contact_id]::$user[password]</center>";?>
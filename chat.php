<?
include_once '../common/functions.php';
mysql_connect();
mysql_select_db('intranet');

$q1 = "SELECT * FROM contacts WHERE uid = '$_GET[uid]'";		
$r1 = @mysql_query ($q1) or die(mysql_error());
$user = mysql_fetch_array($r1, MYSQL_ASSOC);

$i=0;


// first thing we need to do is ack the window opening
@mysql_query("UPDATE client_im SET ack='2' WHERE to_id='$user[contact_id]' and from_id = '$_GET[to]'");





// now if we are sendinf a message
if ($_POST[message]){
@mysql_query("INSERT INTO client_im (ack,from_id, to_id, message, stamp) values ('1', '$_POST[from_id]', '$_POST[to_id]', '".addslashes($_POST[message])."', NOW())");
}





// convert to loop show last 5 messages
$q="SELECT * FROM client_im WHERE (from_id = '$user[contact_id]' AND to_id = '$_GET[to]') OR (from_id = '$_GET[to]' AND to_id = '$user[contact_id]') ORDER BY im_id DESC LIMIT 0,5";
$r=@mysql_query($q) or die(mysql_error());




?>




<table style="position:absolute; top:0px; left:0px;" border="1" width="100%">
<? while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){?>
	<tr bgcolor="<?=row_color_light($i++)?>">
		<td width="150px" nowrap="nowrap" valign="top"><?=id2contact($d[from_id])?>:</td>
        <td valign="top"><?=stripslashes($d[message])?></td>
    </tr>
<? } ?>
    <form method="post">
    <input name="from_id" value="<?=$user[contact_id]?>" type="hidden">
    <input name="to_id" value="<?=$_GET[to]?>" type="hidden">
    <tr bgcolor="#003399">
    	<td colspan="2" height="30px" align="center"><input name="message" size="58"><input type="submit" value="Send" /></td>
    </tr>	
	</form> 
	<tr>
    	<td colspan="2"><center><a href="index.php?uid=<?=$_GET[uid]?>">HOME</a></center></td>
    </tr>
       
</table>
<script>document.title = "From: <?=id2contact($user[contact_id])?> To: <?=id2contact($_GET[to])?>";</script>

<?
if ($_GET['new'] && $_POST[message]){
?>
<script>location.href='index.php?uid=<?=$_GET[uid]?>';</script>
<?
}

?>

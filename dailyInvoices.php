<?
include 'header.php';
$options = '';
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
$r=@mysql_query("select distinct genDate from AIVC where genDate <> '0000-00-00' order by genDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
$options .= "<option>$dloop[genDate]</option>";
}
?>
<center><form id="form"><input name="uid" value="<?=$_GET[uid];?>" type="hidden"><select <? if (!$_GET[genDate]){?> style="font-size:24px;" <? }?> name="genDate" onChange="form.submit()" ><option>Select Date</option><?=$options;?></select> <? if ($_GET[genDate]){?><h1>Daily Invoices Generated For <?=$_GET[genDate];?>.</h1></form></center>
<hr>
<table><tr><td valign='top'>
<? $r = @mysql_query("select * from AIVC where genDate = '$_GET[genDate]' and attid = '$user[attorneys_id]'");?>
<table border='1' cellpadding='2'>
	<tr>
		<td>Date Generated</td>
		<td>Auction ID</td>
		<td>Invoice Link</td>
	</tr>
<? while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ if ($d[url]){?>
	
	<tr>
		<td><?=$d[stored]?></td>
		<td><?=$d[auctionID]?></td>
		<td><a href="<?=$d[url]?>" target='preview'>OPEN</a></td>
	</tr>
<? }}?>
</table>
</td><td valign='top'>

<iframe id='preview' name='preview' height='550' width='700'></iframe>

</td></tr></table>
<? } // end test for _GET[genDate] from line 10 ?>
<?
include 'footer.php';
?>

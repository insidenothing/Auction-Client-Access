<?
include 'header.v2.php';
$options = '';
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
/*
$r=@mysql_query("select iid, dataFile from AIVC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
	$url = str_replace('/dataFiles/auction/invoices/','/auctionInvoices/',$dloop[dataFile]);
	$url = str_replace('/data/auction/invoices/','/auctionInvoices/',$url);
	$dataFile = str_replace('/dataFiles/auction/invoices/','/data/auction/invoices/',$dloop[dataFile]);
	@mysql_query("update AIVC set url = '$url', dataFile = '$dataFile' where iid = '$dloop[iid]'");
}
*/



$r=@mysql_query("select distinct genDate from AIVC where genDate <> '0000-00-00' and attid = '$user[attorneys_id]' order by genDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
$options .= "<option>$dloop[genDate]</option>";
}
?>
<form id="form"><input name="uid" value="<?=$_GET[uid];?>" type="hidden"><select name="genDate" onChange="form.submit()"><option>Select New Date</option><?=$options;?></select> <? if ($_GET[genDate]){?><br>Invoices Generated For <?=$_GET[genDate];?>.</form>
<? $r = @mysql_query("select * from AIVC where genDate = '$_GET[genDate]' and attid = '$user[attorneys_id]'");?>
<table width="100%" border='1' cellpadding='2'>
	<tr>
		<td align="center">Date Generated</td>
		<td align="center">HWA Auction ID</td>
		<td align="center">Invoice Control Link</td>
	</tr>
<? while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ if ($d[url]){?>
	<tr>
		<td align="center"><?=$d[stored]?></td>
		<td align="center"><?=$d[auctionID]?></td>
		<td align="center"><a href="<?=$d[url]?>" target='_Blank'>PDF INVOICE</a></td>
	</tr>
<? }}?>
</table>
<? } // end test for _GET[genDate] from line 10 ?>
<?
include 'footer.v2.php';
?>

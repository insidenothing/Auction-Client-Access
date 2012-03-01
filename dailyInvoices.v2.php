<?PHP
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


$r=@mysql_query("select distinct uploadDate, date_format(uploadDate, '%W %D %M %Y') as formatted_date from scans where uploadDate <> '0000-00-00'  order by uploadDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
	$options .= "<option>$dloop[uploadDate]</option>";
}
if ($user['level'] == 'Operations'){
	$r=@mysql_query("select distinct genDate, date_format(genDate, '%W %D %M %Y') as formatted_date  from AIVC where genDate <> '0000-00-00' order by genDate DESC");	
}else{
	$r=@mysql_query("select distinct genDate, date_format(genDate, '%W %D %M %Y') as formatted_date from AIVC where genDate <> '0000-00-00' and attid = '$user[attorneys_id]' order by genDate DESC");
}
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
	$options .= "<option value='$dloop[genDate]'>$dloop[formatted_date]</option>";
}
?>
<form id="form">
	<select name="genDate" onChange="form.submit()">
		<option>Select New Date</option>
		
		
		
		
<?PHP echo $options;?></select>
</form>

<?PHP if ($_GET[genDate]){ ?>
<br>
<?php echo $user['level'] ?> Invoices Generated For
<?PHP echo $_GET[genDate];?>
.
<?PHP

if ($user['level'] == 'Operations'){
	$r = @mysql_query("select * from AIVC where genDate = '$_GET[genDate]'");
	$r2 = @mysql_query("select * from scans, schedule_items where scans.uploadDate = '$_GET[genDate]' and scans.auction = schedule_items.schedule_id");
	
}else{
	$r = @mysql_query("select * from AIVC where genDate = '$_GET[genDate]' and attid = '$user[attorneys_id]'");
	$r2 = @mysql_query("select * from scans, schedule_items where scans.uploadDate = '$_GET[genDate]' and scans.auction = schedule_items.schedule_id and schedule_items.attorneys_id = '$user[attorneys_id]'");
	
}
?>
<table width="100%" border='1' cellpadding='2'>
	<tr>
		<td align="center">Date Generated</td>
		<td align="center">HWA Auction ID</td>
		<td align="center">File Number</td>
		<td align="center">Pub Dates</td>
		<td align="center">Invoice Control Link</td>
	</tr>
	
	
	
	
	<?PHP while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ if ($d[url]){?>
		<tr>
			<td align="center"><?PHP echo $d[stored]?></td>
			<td align="center"><?PHP echo $d[auctionID]?></td>
			<td align="center"></td>
			<td align="center"></td>
			<td align="center"><a href="<?PHP echo $d[url]?>" target='_Blank'>PDF INVOICE</a></td>
		</tr>
	<?PHP } }?>
	<?PHP while ($d2=mysql_fetch_array($r2,MYSQL_ASSOC)){ if ($d2[scan]){?>
		<tr>
			<td align="left"><?PHP echo $d2[uploadDate]?></td>
			<td align="left"><?PHP echo $d2[auction]?></td>
			<td align="left"><?php if ($user['level'] == 'Operations'){ echo id2attorneys($d2[attorneys_id])." - "; } ?><?PHP echo $d2['file']?></td>
			<td align="left"><?PHP echo $d2['pub_dates']?></td>
			<td align="center"><a href="<?PHP echo $d2[scan]?>" target='_Blank'>PDF INVOICE</a></td>
		</tr>
	<?PHP } } ?>
		

</table>

<?PHP }
	 // end test for _GET[genDate] from line 10
	?>
<?PHP
include 'footer.v2.php';
?>

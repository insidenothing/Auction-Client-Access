<?PHP
include 'header.php';
$options = '';
hardLog(id2attorneys($user['attorneys_id']).'] ['.$user['name'].' Loaded '.$_SERVER['PHP_SELF'].'+'.$_SERVER['QUERY_STRING '],'client');
$r=@mysql_query("select distinct uploadDate from scans order by uploadDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
	$options .= "<option>$dloop[uploadDate]</option>";
}
$r=@mysql_query("select distinct genDate from AIVC where genDate <> '0000-00-00' order by genDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
//$options .= "<option>$dloop[genDate]</option>";
}
?>
<center><form id="form"><input name="uid" value="<?PHP echo $_GET['uid'];?>" type="hidden"><select <?PHP if (!$_GET['genDate']){?> style="font-size:24px;" <?PHP }?> name="genDate" onChange="form.submit()" ><option>Select Date</option><?PHP echo $options;?></select> <?PHP if ($_GET['genDate']){?><h1>Daily Invoices Generated For <?PHP echo $_GET['genDate'];?>.</h1></form></center>
<hr>
<table><tr><td valign='top'>
<?PHP 
$r = @mysql_query("select * from AIVC where genDate = '$_GET[genDate]' and attid = '$user[attorneys_id]'");
$r2 = @mysql_query("select * from scans where uploadDate = '$_GET[genDate]' and attid = '$user[attorneys_id]'");
?>
<table border='1' cellpadding='2'>
	<tr>
		<td>Date Generated</td>
		<td>Auction ID</td>
		<td>Invoice Link</td>
	</tr>
	<?PHP while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){ if ($d['url']){?>
		<tr>
			<td><?PHP echo $d['stored']?></td>
			<td><?PHP echo $d['auctionID']?></td>
			<td><a href="<?PHP echo $d['url']?>" target='preview'>OPEN</a></td>
		</tr>
	<?PHP } ?>
	<?PHP while ($d2=mysql_fetch_array($r2,MYSQL_ASSOC)){ if ($d2['scan']){?>
		<tr>
			<td><?PHP echo $d2['uploadDate']?></td>
			<td><?PHP echo $d2['auction']?></td>
			<td><a href="<?PHP echo $d2['scan']?>" target='preview'>OPEN</a></td>
		</tr>
	<?PHP } ?>
		
<?php ?>}?>
</table>
</td><td valign='top'>

<iframe id='preview' name='preview' height='550' width='700'></iframe>

</td></tr></table>
<?PHP } // end test for _GET[genDate] from line 10 ?>
<?PHP
include 'footer.php';
?>

<?PHP
include 'header.v2.php';
$options = '';
$attid = $user['attorneys_id'];
$r=@mysql_query("select distinct uploadDate, date_format(uploadDate, '%W') as formatted_date from scans where uploadDate <> '0000-00-00' and attorneys_id = '$attid'  order by uploadDate DESC");
while ($dloop = mysql_fetch_array($r,MYSQL_ASSOC)){
	$options .= "<option value='$dloop[uploadDate]'>$dloop[uploadDate]: $dloop[formatted_date]</option>";
}
?>
<form id="form">
	<select name="genDate" onChange="form.submit()">
		<option>Select New Date</option>
		<?PHP echo $options;?></select>
</form>

<?PHP if (isset($_GET['genDate'])){ ?>
<br>
<?php echo $user['level'] ?> Requested Documents Scanned For
<?PHP echo $_GET['genDate'];?>
.
<?PHP

if ($user['level'] == 'Operations'){
	$r2 = @mysql_query("select * from scans where uploadDate = '$_GET[genDate]' ");
}else{
	$r2 = @mysql_query("select * from scans where uploadDate = '$_GET[genDate]' and attorneys_id = '$attid'");
}
?>
<table width="100%" border='1' cellpadding='2'>
	<tr>
		<td align="center">Client</td>
		<td align="center">Date Generated</td>
		<td align="center">Scan Name</td>
		<td align="center">View Link</td>
	</tr>
	
	<?PHP while ($d2=mysql_fetch_array($r2,MYSQL_ASSOC)){ if (isset($d2['scan'])){?>
		<tr>
			<td align="left"><?PHP echo $d2['attorneys_id']?></td>
			<td align="left"><?PHP echo $d2['uploadDate']?></td>
			<td align="left"><?PHP echo $d2['method']?></td>
			<td align="center"><a href="<?PHP echo $d2['scan']?>" target='_Blank'>Open</a></td>
		</tr>
	<?PHP } } ?>
		

</table>

<?PHP } // end test for _GET[genDate] from line 16	?>


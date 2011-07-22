<?PHP
mysql_connect();
mysql_select_db('intranet');
$r=@mysql_query("select * from bursonDB order by syncDate DESC, file_number");
?>
<style>
td{font-size:10px;}
</style>
<div>bursonDB per public data source</div>
<table>
<?PHP $i=0; while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++; ?>
	<tr>
		<td><?PHP echo $i;?></td>	
		<td><?PHP echo $d[file_number];?></td>	
		<td><?PHP echo $d[syncDate];?></td> 	
		<td><?PHP echo $d[address1];?></td> 	
		<td><?PHP echo $d[address2];?></td> 	
		<td><?PHP echo $d[city];?></td> 	
		<td><?PHP echo $d[state];?></td> 	
		<td><?PHP echo $d[property_type];?></td> 	
		<td><?PHP echo $d[ground_rent_due];?></td> 	
		<td><?PHP echo $d[auction_status];?></td> 	
		<td><?PHP echo $d[dot_from];?></td> 	
		<td><?PHP echo $d[dot_date];?></td> 	
		<td><?PHP echo $d[liber_follio];?></td> 	
		<td><?PHP echo $d[court_location];?></td> 	
		<td><?PHP echo $d[principal];?></td> 	
		<td><?PHP echo $d[interest];?></td> 	
		<td><?PHP echo $d[sale_date];?></td> 	
		<td><?PHP echo $d[hwa_sale_date];?></td> 	
		<td><?PHP echo $d[sale_time];?></td> 	
		<td><?PHP echo $d[legal_description];?></td> 	
		<td><?PHP echo $d[deposit];?></td> 	
		<td><?PHP echo $d[case_number];?></td> 	
		<td><?PHP echo $d[loan_type];?></td> 	
		<td><?PHP echo $d[trustees];?></td> 	
		<td><?PHP echo $d[pub_dates];?></td>
</tr>
<?PHP } ?>
</table>
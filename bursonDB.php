<?
mysql_connect();
mysql_select_db('intranet');
$r=@mysql_query("select * from bursonDB order by syncDate DESC, file_number");
?>
<style>
td{font-size:10px;}
</style>
<div>bursonDB per public data source</div>
<table>
<? $i=0; while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ $i++; ?>
	<tr>
		<td><?=$i;?></td>	
		<td><?=$d[file_number];?></td>	
		<td><?=$d[syncDate];?></td> 	
		<td><?=$d[address1];?></td> 	
		<td><?=$d[address2];?></td> 	
		<td><?=$d[city];?></td> 	
		<td><?=$d[state];?></td> 	
		<td><?=$d[property_type];?></td> 	
		<td><?=$d[ground_rent_due];?></td> 	
		<td><?=$d[auction_status];?></td> 	
		<td><?=$d[dot_from];?></td> 	
		<td><?=$d[dot_date];?></td> 	
		<td><?=$d[liber_follio];?></td> 	
		<td><?=$d[court_location];?></td> 	
		<td><?=$d[principal];?></td> 	
		<td><?=$d[interest];?></td> 	
		<td><?=$d[sale_date];?></td> 	
		<td><?=$d[hwa_sale_date];?></td> 	
		<td><?=$d[sale_time];?></td> 	
		<td><?=$d[legal_description];?></td> 	
		<td><?=$d[deposit];?></td> 	
		<td><?=$d[case_number];?></td> 	
		<td><?=$d[loan_type];?></td> 	
		<td><?=$d[trustees];?></td> 	
		<td><?=$d[pub_dates];?></td>
</tr>
<? } ?>
</table>
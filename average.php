<?php
mysql_connect();
mysql_select_db('intranet');

function average_cost($paper,$year)
{
	$return = array();
	$counter=0;
	$total=0;
	$r=@mysql_query("select ad_cost from schedule_items where paper = '$paper' and sale_date like '%$year%' and ad_cost < '2000.00' ");
	while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		$counter++;
		$total = $total + $d['ad_cost'];
	}
	$return['average'] = number_format($total / $counter,2);
	
	
	return $return;
}




$r=@mysql_query("select distinct paper from schedule_items where ad_cost < '2000.00' and paper <> ''");
?>
All identifiable information removed, the following is for estimation only.
<table border="1" cellpadding="5" cellspacing="0">
	<tr>
		<td>Paper</td>
		<td>2012</td>
		<td>2011</td>
		<td>2010</td>
		<td>2009</td>
		<td>2008</td>
		<td>2007</td>
	</tr>
<?php while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ ?>
	<tr>
		<td><?php echo $d['paper'];?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2012');
		echo $temp['average'];
		?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2011');
		echo $temp['average'];
		?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2010');
		echo $temp['average'];
		?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2009');
		echo $temp['average'];
		?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2008');
		echo $temp['average'];
		?></td>
		<td><?php 
		$temp = average_cost($d['paper'],'2007');
		echo $temp['average'];
		?></td>
	</tr>	
<?php } ?>
</table>
<?php
mysql_connect();
mysql_select_db('intranet');

function average_cost($paper,$year)
{
	$return = array();
	$counter=0;
	$total=0;
	$r=@mysql_query("select ad_cost from schedule_items where paper = '$paper' and sale_date like '%$year%' and ad_cost < '2000.00' and ad_cost > '0.00' ");
	while($d=mysql_fetch_array($r,MYSQL_ASSOC)){
		$counter++;
		$total = $total + $d['ad_cost'];
	}
	$return['average'] = number_format($total / $counter,2);
	
	
	return $return;
}




$r=@mysql_query("select distinct paper from schedule_items where ad_cost < '2000.00' and ad_cost > '0.00' and paper <> ''");
?>
<table width="100%"><tr><td valign="top">
<b>Click on a cost for quantium breakdown.</b><br>
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
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2012"><?php 
		$temp = average_cost($d['paper'],'2012');
		echo $temp['average'];
		?></a></td>
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2011"><?php 
		$temp = average_cost($d['paper'],'2011');
		echo $temp['average'];
		?></a></td>
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2010"><?php 
		$temp = average_cost($d['paper'],'2010');
		echo $temp['average'];
		?></a></td>
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2009"><?php 
		$temp = average_cost($d['paper'],'2009');
		echo $temp['average'];
		?></a></td>
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2008"><?php 
		$temp = average_cost($d['paper'],'2008');
		echo $temp['average'];
		?></a></td>
		<td><a href="?paper=<?php echo $d['paper'];?>&year=2007"><?php 
		$temp = average_cost($d['paper'],'2007');
		echo $temp['average'];
		?></a></td>
	</tr>	
<?php } ?>
</table>

</td><td valign="top">

<?php if (isset($_GET['paper']) && isset($_GET['year'])){ 
$q2= "SELECT schedule_id FROM schedule_items
WHERE paper = '".$_GET['paper']."'
AND sale_date LIKE '".$_GET['year']."%'
AND ad_cost <> '0.00'";
$r2=@mysql_query($q2);
$count=mysql_num_rows($r2);

$q1= "SELECT ad_cost, count( schedule_id ) AS cnt
FROM schedule_items
WHERE paper = '".$_GET['paper']."'
AND sale_date LIKE '".$_GET['year']."%'
AND ad_cost <> '0.00'
GROUP BY ad_cost
HAVING cnt >1
ORDER BY `cnt` DESC limit 0,15";
$r1=@mysql_query($q1);
?>
Quantium Results for<br><b><?php echo $_GET['paper'];?> in <?php echo $_GET['year'];?></b>
<table border="1" cellpadding="10" cellspacing="0">
	<tr>
		<td>Cost</td>
		<td>Occurance</td>
	</tr>
<?php while ($d1 = mysql_fetch_array($r1,MYSQL_ASSOC)){ ?>
	<tr>
		<td>$<?php echo $d1['ad_cost'];?></td>
		<td><?php echo  number_format($d1['cnt']/$count,2)*100;?>%</td>
	</tr>
<?php } ?>
</table>



<?php }?>
</td></tr></table>
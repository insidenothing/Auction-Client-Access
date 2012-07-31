<?php
mysql_connect();
mysql_select_db('intranet');
$r=@mysql_query("select distinct paper from schedule_items where sale_date like '%2012%'");
?>
All identifiable information removed, the following is for estimation only.
<table>
<?php while($d=mysql_fetch_array($r,MYSQL_ASSOC)){ ?>
	<tr>
		<td><?php echo $d['paper'];?></td>
		<td></td>
	</tr>	
<?php } ?>
</table>
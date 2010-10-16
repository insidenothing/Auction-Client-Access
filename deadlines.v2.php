<?
include 'header.v2.php';
mysql_select_db ('intranet');
hardLog($user[name].' Checking Deadlines','user');

$q="SELECT * from papers order by paper_name";
$r=@mysql_query($q);
$i=0;
?>
<table border="1" style="border-collapse:collapse;" bgcolor="#FFFFFF" align="center">
<? while($d=mysql_fetch_array($r, MYSQL_ASSOC)){ if ($d[deadline_our]){ $i++; ?>
	<tr bgcolor="<?=row_color_light($i)?>">
    	<td style="text-align:left">Deadline for <?=$d[paper_name]?> is <?=$d[deadline_our]?></td>
    </tr>
<? } }?>
</table>
<?
include 'footer.v2.php';
?>
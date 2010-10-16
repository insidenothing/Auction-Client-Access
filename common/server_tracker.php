<? 
include 'common.php';

if ($_COOKIE[psdata][level] != "Dispatch"){
		if ($_COOKIE[psdata][level] == "SysOp" || $_COOKIE[psdata][level] == "Operations") {
		
		}else{
			$event = 'home_administrator.php';
			$email = $_COOKIE[psdata][email];
			$q1="INSERT into ps_security (event, email, entry_time) VALUES ('$event', '$email', NOW())";
			@mysql_query($q1) or die(mysql_error());
			header('Location: home.php');
		}
}
include 'menu.php';



?>
<table border="1" style="border-collapse:collapse" align="center" width="100%">
    <tr bgcolor="#CCCCCC">
    	<td align="center" colspan="2" width="7%"><strong>Links</strong></td>
        <td align="center"><strong>Affidavits</strong></td>
    	<td align="center"><strong>Photos</strong></td>
        <td align="center" width="18%"><strong>Process Server</strong></td>
        <td align="center"><strong>Client</strong></td>
        <td align="center"><strong>Client File #</strong></td>
        <td align="center"><strong>Circuit Court</strong></td>
        <td align="center" width="40%"><strong>Service Address</strong> <i><small>(click for details)</small></i></td>
        <td align="center"><strong>Process Status</strong></td>
    </tr>

<style>
.pstd{background-color:#333333; color:#CCCCCC;}
.mem{font-size:11px; font-variant:small-caps; font-weight:bold;}
td.pcc:hover{ background-color:#333333; color:#FF0000; cursor:pointer;}
td.pdd:hover{ background-color:#CCFFCC; color:#000000; cursor:pointer;}
a.pff{color:#000000; text-decoration:none;}
a.pff:link{color:#000000; text-decoration:none;}
a.pff:visited{color:#000000; text-decoration:none;}
a.pff:hover{ color:#990000; cursor:pointer; text-decoration:none;}
</style>
<?
$q= "select * from ps_packets where process_status='ASSIGNED' order by server_id";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
$i=0;
?>
    <tr>
    	<td colspan="9" class="pstd" align="center"><strong><?=$status?> Files</strong></td>
    </tr>
<?
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {$i++;
?>
    <tr bgcolor="<?=row_color($i,'#99cccc','#99ccff')?>">
    	<td nowrap="nowrap"><a class="pff" href="<?=$d[otd]?>" target="_blank">PDF</a></td>
		<td nowrap="nowrap" title="Package <?=$d[packet_id]?>" class="pcc" onclick="window.location='service.php?packet=<?=$d[packet_id]?>'">Service</td>
        <td nowrap="nowrap">
        <? if ($d[name1]){?><a class="pff" title="Affidavit for <?=$d[name1]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=1')">| <?=$d[name1]?> | </a><? }else{ } ?>
        <? if ($d[name2]){?><a class="pff" title="Affidavit for <?=$d[name2]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=2')"><?=$d[name2]?> | </a><? }else{ } ?>
        <? if ($d[name3]){?><a class="pff" title="Affidavit for <?=$d[name3]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=3')"><?=$d[name3]?> | </a><? }else{ } ?>
        <? if ($d[name4]){?><a class="pff" title="Affidavit for <?=$d[name4]?>" onclick="window.open('affidavit.php?packet=<?=$d[packet_id]?>&def=4')"><?=$d[name4]?> | </a><? }else{ } ?>
        </td>
        <td nowrap="nowrap">
		<? if ($d[photo1a]){?><a class="pff" style="font-size:11px" href="<?=$d[photo1a]?>" target="_blank">1A</a><? }else{ } ?>
        <? if ($d[photo1b]){?><a class="pff" style="font-size:11px" href="<?=$d[photo1b]?>" target="_blank">1B</a><? }else{ } ?>
        <? if ($d[photo2a]){?><a class="pff" style="font-size:11px" href="<?=$d[photo2a]?>" target="_blank">2A</a><? }else{ } ?>
        <? if ($d[photo2b]){?><a class="pff" style="font-size:11px" href="<?=$d[photo2b]?>" target="_blank">2B</a><? }else{ } ?>
        <? if ($d[photo3a]){?><a class="pff" style="font-size:11px" href="<?=$d[photo3a]?>" target="_blank">3A</a><? }else{ } ?>
        <? if ($d[photo3b]){?><a class="pff" style="font-size:11px" href="<?=$d[photo3b]?>" target="_blank">3B</a><? }else{ } ?>
        <? if ($d[photo4a]){?><a class="pff" style="font-size:11px" href="<?=$d[photo4a]?>" target="_blank">4A</a><? }else{ } ?>
		<? if ($d[photo4b]){?><a class="pff" style="font-size:11px" href="<?=$d[photo4b]?>" target="_blank">4B</a><? }else{ } ?></td>
        <td nowrap="nowrap" align="center"><a class="pff"  title="Profile information for <?=id2name($d[server_id])?>" href="contractor_review.php?admin=<?=$d[server_id]?>"><?=id2name($d[server_id])?></a></td>
        <td nowrap="nowrap"><?=id2attorney($d[attorneys_id])?></td>
        <td nowrap="nowrap"><?=$d[client_file] ?></td>
        <td nowrap="nowrap"><?=$d[circuit_court]?></td>
        <td nowrap="nowrap" title="Details for service address <?=$d[address1]?>" class="pdd" onclick="window.location='ps_details.php?pkg=<?=$d[packet_id]?>'"><small><?=$d[address1] ?></small></td>
        <td nowrap="nowrap"><? if ($d[process_status] == 'ASSIGNED'){echo "<a title='Click to mark file AWAITING AFFIDAVIT CONFIRMATION' class='pff' href='home_administrator.php?update=$d[packet_id]'>$d[process_status]</a>"; }else{echo $d[process_status]; }?></td>
	</tr>
<?  
}
?>


</table>
<?
include 'footer.php';
?>
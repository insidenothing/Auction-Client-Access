<? $back = time()-1800; // 30 Minutes ?><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="text-align:justify; padding-left:10px; font-weight:bold; font-size:14px;" bgcolor="#FFCCFF"><!--Online Now: 
<? 
$q="SELECT * FROM users WHERE online_now > '$back' ORDER BY name";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?> 
<a target="_blank" href="chat.php?to=<?=$d[user_id]?>&new=1" style="color:#000000; font-size:14px; text-decoration:none;" title="<?=$d[system_location]?>"><?=strtoupper($d[name])?></a>, 
<? } ?>
-->
<?
$q="SELECT * FROM contacts WHERE online_now > '$back' ORDER BY name";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$qx="SELECT action from portal_log where user_id = '$d[contact_id]' order by log_id DESC";
$rx=@mysql_query($qx) or die(mysql_error());
$dx=mysql_fetch_array($rx, MYSQL_ASSOC);
?>
<a style="color:#000000; font-size:14px; text-decoration:none;" title="<?=$dx[action]?>"><?=strtoupper(id2contact($d[contact_id]))?></a>, 
<? }?>
<!--
<? 
$q="SELECT * FROM auctioneers WHERE online_now > '$back' ORDER BY name";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
$qx="SELECT action from auctioneer_log where user_id = '$d[auctioneer_id]' order by log_id DESC";
$rx=@mysql_query($qx) or die(mysql_error());
$dx=mysql_fetch_array($rx, MYSQL_ASSOC);
?>
<a style="color:#000000; font-size:14px; text-decoration:none;" title="<?=$dx[action]?>"><?=strtoupper($d[auctioneer])?></a>, 
<? }?>
-->
</td></tr></table>    
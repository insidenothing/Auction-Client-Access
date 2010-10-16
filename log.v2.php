<?
include 'header.v2.php';
portal_log("Loaded 'My Activity'", $user[contact_id]);
hardLog($user[name].' Viewing Activity Log','user');

$user_id = $user[contact_id];
$rowsPerPage = 17;
$pageNum = 1;
if(isset($_GET['page2']))
{
    $pageNum = $_GET['page2'];
}
$offset = ($pageNum - 1) * $rowsPerPage;
if ($offset < 1){ $offset = 0; }
?>
<table align="center" border="0" cellspacing="0" cellpadding="5" bgcolor="#99CCFF" width="100%">
	<tr>
    	<td colspan="5" align="center">
<?
if($user_id){
	$query   = "SELECT COUNT(log_id) AS numrows FROM portal_log WHERE user_id = '$user_id'";
}else{
	$query   = "SELECT COUNT(log_id) AS numrows FROM portal_log";
}
$result  = mysql_query($query) or die('Error, query failed<br>'.mysql_error());
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];
$maxPage = ceil($numrows/$rowsPerPage);
$self = $_SERVER['PHP_SELF'];
if ($pageNum > 1)
{
	$prevpage = $pageNum - 1;
	$prev = " <a href=\"$self?page=portal_log&id=$user_id&page2=$prevpage&uid=$uid\">[Prev]</a> ";
	$first = " <a href=\"$self?page=portal_log&id=$user_id&page2=1&uid=$uid\">[First Page]</a> ";
} 
else
{
	$prev  = ' [Prev] ';       
	$first = ' [First Page] '; 
}
if ($prevpageNum < $maxPage)
{
	$prevpage = $pageNum + 1;
	$next = " <a href=\"$self?page=portal_log&id=$user_id&page2=$prevpage&uid=$uid\">[Next]</a> ";
	
	$last = " <a href=\"$self?page=portal_log&id=$user_id&page2=$maxPage&uid=$uid\">[Last Page]</a> ";
} 
else
{
	$next = ' [Next] ';      
	$last = ' [Last Page] ';
}
echo $first . $prev . " Showing page <strong>$pageNum</strong> of <strong>$maxPage</strong> pages " . $next . $last;
?>        
        </td>
    </tr>
</table>
<table bgcolor="#FFFFFF" cellspacing="0" cellspacing="2" width="100%" style="font-size:14px">
<? 
if ($user_id){
$q = "select *,DATE_FORMAT(action_on, '%m/%d/%Y %r') as action_on from portal_log WHERE user_id = '$user_id' order by log_id desc LIMIT $offset, $rowsPerPage";
}else{
$q = "select *,DATE_FORMAT(action_on, '%m/%d/%Y %r') as action_on from portal_log order by log_id desc LIMIT $offset, $rowsPerPage";
}
$r = @mysql_query($q) or die(mysql_error());
$i=0;
while($d = mysql_fetch_array($r, MYSQL_ASSOC)){ 
$i++;




?>
	<tr bgcolor="<?=row_color_new($i)?>">
        <td style="border-right:solid;"><?=$d[action_on]?></td>
    	<td><?=$d[action]?></td>
    </tr>
<? } ?>
</table>
<?
include 'footer.v2.php';
?>

<?PHP 
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');
include 'security.php';
onlinePortal($user['contact_id']);
?>
<style>
body {margin:0px; padding:0px; background-color:#0066FF;}
a {text-decoration:none; color:#000099; font-weight:bold;}
a:hover {text-decoration:none; color:#000000; font-weight:bold;}
@media print {
.noprint { display: none; }
}
td { border-bottom: double 3px #00FF00}
</style> 


<table width="100%" align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top"  bgcolor="#FFFFFF" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;">
<center>
<?PHP
include 'menu.php';
$att_id = $user['attorneys_id'];
if ($_GET['q']){
$q = $_GET['q'];
?>
<style>
td	{text-align:center; border-bottom: solid 1px #99cc33; padding:3px;}
</style>

<table width="100%"  align="center" style="border-collapse:collapse" cellpadding="0" cellspacing="0" border="0">
<?PHP // DATE_FORMAT(sale_date,'%l:%i%p') as sale_date_f 
$i=0;
mysql_select_db ('intranet');
hardLog(id2attorneys($user['attorneys_id']).'] ['.$user['name'].' Searching '.$_GET['field'].' for '.$q.'] ['.$_GET['resolution'],'client');

if ($_GET['field'] == 'an'){
	$q1 = "SELECT * FROM schedule_items WHERE attorneys_id = '$att_id' AND schedule_id like '%$q%' ORDER BY sale_date, sort_time";
}elseif($_GET['field'] == 'fn'){
	$q1 = "SELECT * FROM schedule_items WHERE attorneys_id = '$att_id' AND file like '%$q%' ORDER BY sale_date, sort_time";		
}elseif($_GET['field'] == 'dr'){
	$q1 = "SELECT * FROM schedule_items WHERE attorneys_id = '$att_id' AND item_date like '%$q%' ORDER BY sale_date, sort_time";		
}elseif($_GET['field'] == 'sd'){
	$q1 = "SELECT * FROM schedule_items WHERE attorneys_id = '$att_id' AND sale_date like '%$q%' ORDER BY sale_date, sort_time";		
}
$r1 = @mysql_query ($q1) or die("QUERY: $q1<hr>".mysql_error());
while ($data1 = mysql_fetch_array($r1, MYSQL_ASSOC)) {	
$i++;
if ( $data1['item_status'] == "SALE CANCELLED"){ $class = 'canceled';	} else {$class = 'active';	}
$code = "x".$data1['attorneys_id'];
echo "
<tr>
<td style='text-align:left;' nowrap><a href='simpleDetails.php?id=".$data1['schedule_id']."'>Simple View</a></td>

<td style='text-align:left;' nowrap><a href='details.v2.php?id=".$data1['schedule_id']."'>Expanded View</a></td>

<td style='text-align:left;' nowrap><a href='invoice.v2.php?auction=".$data1['schedule_id']."&refer=search'>Invoice</a></td>

<td style='text-align:left;' nowrap>".$data1['file']."</td>

<td nowrap>".$data1['sale_date']." ".$data1['sale_time']."</td>
<td style='text-align:left;' nowrap>".$data1['item_status']."</td>
<td style='text-align:left;' nowrap>".substr($data1['address1'],0,30)."</td>
<td style='text-align:left;' nowrap>".$data1['county']."</td>
<td>".$data1['schedule_id']."</td>
</tr>";
}
hardLog(id2attorneys($user['attorneys_id']).'] ['.$user['name'].' Search Results: '.$i,'client');

echo "</table>";
}
include 'footer.php';?>
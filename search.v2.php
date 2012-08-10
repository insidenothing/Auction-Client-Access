<?PHP
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');
include 'security.php';
onlinePortal($user['id']);
function colorMe($str){
 if ($str=="ON SCHEDULE"){
return "#ccffcc";
 }else{
return "#ffcccc";
 }
}
function auctioneerPhone($name = ''){

	$r=@mysql_query("select phone from auctioneers where auctioneer = '$name' or name = '$name' or requested_string = '$name' or confirmed_string = '$name' or available_string = '$name'");
	$d=mysql_fetch_array($r,MYSQL_ASSOC)or die(mysql_error());
	return $name.' ('.$d['phone'].') ';
	
}
?>
<style>
body {margin:0px; padding:0px;}
a {text-decoration:none; color:#000099; font-weight:bold;}
a:hover {text-decoration:none; color:#000000; font-weight:bold;}
@media print {
.noprint { display: none; }
}
td	{text-align:center; border-bottom: solid 1px #cccccc; padding:2px; font-size:12px;}
</style> 
<center>
<form action="search.v2.php">	

                <input type="hidden" name="page" value="search" />
                
				<script type='text/javascript'>document.write('<input name="resolution" value="'+screen.width+'x'+screen.height+'" type="hidden">');</script>

				Search by
				
				<select name="field">
				<option value="fn">File Number</option>
				<option value="dr">Date Transmitted YYYY-MM-DD</option>
				<option value="sd">Sale Date YYYY-MM-DD</option>
				<option value="an">Auction Number</option>
				</select>
				 for <input size="20" style="font-weight:bold; font-variant:small-caps" name="q" value="<?php if (isset($_GET['q'])){$_GET['q'];}?>" />
				<input style=" font-weight:bold; font-variant:small-caps" type="submit"  value="Search Auction Database"/><br /><strong>Did you know? When searching for files you can use the percent sign '%' as a wildcard!</strong>
            
        </form>
</center>
<?PHP
$att_id = $user['attorneys_id'];
if (isset($_GET['q'])){
$q = $_GET['q'];
?>
<table width="100%"  align="center" style="border-collapse:collapse" cellpadding="0" cellspacing="0" border="0">
<?PHP // DATE_FORMAT(sale_date,'%l:%i%p') as sale_date_f 
$i=0;
mysql_select_db ('intranet');
//$qdate = $year.'-'.$month.'-'.$day;
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
<tr style='background-color:".colorMe($data1['item_status']).";'>
<td style='text-align:left;' nowrap><a href='simpleDetails.v2.php?id=".$data1['schedule_id']."'>Simple</a></td>

<td style='text-align:left;' nowrap><a href='details.v2.php?id=".$data1['schedule_id']."'>Expanded</a></td>

<td style='text-align:left;' nowrap>".$data1['file']."</td>

<td nowrap>".$data1['sale_date']." ".$data1['sale_time']."</td>";

echo '<td nowrap>';
if ($data1['auctioneer'] != ''){ echo auctioneerPhone($data1['auctioneer']); }
if ($data1['auctioneer2'] != ''){ echo auctioneerPhone($data1['auctioneer2']); }
if ($data1['auctioneer3'] != ''){ echo auctioneerPhone($data1['auctioneer3']); }
echo '</td>';

echo "<td style='text-align:left;' nowrap>".substr($data1['address1'],0,30)."</td>
<td style='text-align:left;' nowrap>".$data1['county']."</td>
<td>".$data1['schedule_id']."</td>
</tr>";
}
hardLog(id2attorneys($user['attorneys_id']).'] ['.$user['name'].' Search Results: '.$i,'client');

echo "</table>";
}
?>
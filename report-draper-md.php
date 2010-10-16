<?
include 'header.php';
portal_log("Draper MD Ad Cost Report", $user[contact_id]);

$today = date('Y-m-d');


$body = "<div align='center'>All Upcoming Sales with Ad Cost</div>";
$body .= "
<table align='center' cellpadding='5' cellspacing='0' border='1'>
	<tr>
		<td align='center'>Sale Date</td>
		<td align='center'>Status</td>
		<td align='center'>Address</td>
		<td align='center'>File Number</td>
		<td align='center'>Cost</td>
	</tr>";
$q1 = "SELECT * FROM schedule_items WHERE sale_date > '$today' AND attorneys_id = '21' AND state='MD' AND private='' ORDER BY sale_date, sort_time "; 
$r1 = @mysql_query ($q1) or die(mysql_error());
while ($d1 = mysql_fetch_array($r1, MYSQL_ASSOC)) {	
$body .="
	<tr>
		<td>$d1[sale_date] <br> $d1[sale_time]</td>
		<td>$d1[item_status]</td>
		<td>$d1[address1]</td>
		<td>$d1[file]</td>
		<td>$";
		if ($d1[pub_cost_flag] == "3" || $data[pub_cost_flag] == ''){ $body .= $d1[ad_cost]; }
$body .= "</td>
	</tr>";
}
$body .= "</table>";

echo $body;
?>
<?
include 'footer.php';
?>

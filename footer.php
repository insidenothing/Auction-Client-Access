<div align="center" style="border-top:dashed">&copy; 1950 - 2009 Harvey West Auctioneers llc.<div class="noprint">Users Online Right Now:
<?PHP
$back = time()-1800;
// ok let's show them their contacts
mysql_select_db ('intranet');

if(isset($user)){

$q="SELECT * FROM contacts WHERE online_now > '$back' AND attorneys_id = '".$user['attorneys_id']."' ORDER BY name";
$r=@mysql_query($q);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?>
<?PHP echo strtoupper(id2contact($d['contact_id']))?>,  
<?PHP }
}
// now we need to show bound staff
//mysql_select_db ('intranet');
mysql_select_db ('intranet');
$q="SELECT * FROM users WHERE online_now > '$back'  ORDER BY name";
//$q="SELECT * FROM users WHERE online_now > '$back' ORDER BY name";
$r=@mysql_query($q) or die(mysql_error);
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){
?>
<?PHP echo strtoupper(id2contact($d['contact_id']))?>,  
<?PHP }
?>
<br />
<script language="JavaScript" src="http://j.maxmind.com/app/geoip.js"></script>
Local: <script language="JavaScript">document.write(geoip_city());</script>, <script language="JavaScript">document.write(geoip_region());</script>, <script language="JavaScript">document.write(geoip_country_name());</script>
<br />
</div>
</div>
<style>
table {
	border-collapse:collapse;
	}
	
</style>	
</td></tr>
</table>
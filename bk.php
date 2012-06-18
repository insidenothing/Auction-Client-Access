<?PHP 
include 'security.php';
if (!$_GET['bk_id']){ ?>
<form>
1) Enter File Number <input name="bk_id"><br>
2) Click Next <input type="submit" value="Next">
</form>
<?PHP }else{ 
mysql_connect();
mysql_select_db('intranet');
$att_id = $user['attorneys_id'];
$q="SELECT * FROM schedule_items WHERE attorneys_id = '$att_id' AND file like '%$_GET[bk_id]%' ORDER BY sale_date, sort_time";
$r=@mysql_query($q);
?>
<div style="font-size:45px;" align="center"><input type="button" class="noprint" onclick="self.print();" value="Print Case Report"><br>Harvey West Auctioneers</div>
<div style="font-size:30px;" align="center">
Case Report for <?PHP echo $_GET['bk_id']?><br>
<?PHP echo date('r');?>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div style="font-size:20px;">
Searching Entire Database....
<?PHP
$counter=0;
while ($d = mysql_fetch_array($r, MYSQL_ASSOC)) {	
$counter++;
	echo "<li>Auction $d[schedule_id] for $d[sale_date] at $d[sale_time] is $d[item_status]</li>";
}
if ($counter==0){
	echo "<li>At the current time we have not received an order for $_GET[bk_id].</li>";
}
?>
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<div style="font-size:15px;">
Thank you,<br>
Patrick McGuire<br>
Blackberry 443-386-2584<br>
pmcguire@hwestauctions.com<br>
Harvey West Auctioneers<br>
westads@hwestauctions.com<br>
Main Office 410-769-9797
</div>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<center>&copy; 1950 - 2009 Harvey West Auctioneers, llc.</center>
<?PHP } ?>
<style>
@media print {
.noprint { display: none; }
}
</style>
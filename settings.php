<?
include 'header.php';

hardLog($user[name].' Loaded Main Client Settings','user');

if ($_GET[submit] == "Save Settings"){

echo "<center>Main Settings Updated</center>";

$q = "UPDATE attorneys SET
						template='$_GET[template]',
						merge_aa='$_GET[merge_aa]',
						merge_pa='$_GET[merge_pa]',
						merge_ros='$_GET[merge_ros]',
						merge_car='$_GET[merge_car]',
						merge_cop='$_GET[merge_cop]',
						merge_inv='$_GET[merge_inv]',
						merge_auto='$_GET[merge_auto]',
						trust_names='$_GET[trust_names]', 
						address='$_GET[address]', 
						letter_name='$_GET[letter_name]', 
						invoice_to='$_GET[invoice_to]', 
						statement_to='$_GET[statement_to]', 
						ps_to='$_GET[ps_to]', 
						ps_plaintiff='$_GET[ps_plaintiff]',
						upcoming_report_to='$_GET[upcoming_report_to]' 
							WHERE attorneys_id = '$_GET[att_id]'";
$r = @mysql_query($q) or die(mysql_error());
hardLog($user[name].' Updated Main Client Settings: '.$_GET[display_name],'user');
}
?>
<? 
		mysql_select_db ('intranet');

$q = "SELECT * FROM attorneys WHERE attorneys_id = '$user[attorneys_id]'";
$r = @mysql_query($q) or die(mysql_error());
$d = mysql_fetch_array($r, MYSQL_ASSOC);
?>
<form>
<input type="hidden" name="att_id" value="<?=$user[attorneys_id]?>"/>
<input type="hidden" name="uid" value="<?=$uid?>"/>
<table align="center">
	<tr>
    	<td colspan="2"><strong>Main Settings</strong></td>
    </tr>

	<tr>
    	<td>Display Name</td>
        <td><input name="display_name" size="80" value="<?=$d[display_name]?>"></td>
    </tr>
	<tr>
    	<td>Constant Trustee's</td>
        <td nowrap><input name="trust_names" size="80" value="<?=$d[trust_names]?>"> Seperate with Comma <em>(ALL CAPS)</em></td>
    </tr>
	<tr>
    	<td>Address</td>
        <td nowrap><input name="address" size="80" value="<?=$d[address]?>"> Line Break with Hyphen <em>(3 Line Max)</em></td>
    </tr>
	<tr>
    	<td>Letter Name</td>
        <td><input name="letter_name" size="80" value="<?=$d[letter_name]?>"></td>
    </tr>
    
	<tr>
    	<td colspan="2"><strong>E-Mail Contacts</strong></td>
    </tr>
	<tr>
    	<td>Send Invoice To</td>
        <td><input name="invoice_to" size="80" value="<?=$d[invoice_to]?>"> Seperate with Comma</td>
    </tr>
	<tr>
    	<td>Send Statement To</td>
        <td><input name="statement_to" size="80" value="<?=$d[statement_to]?>"> Seperate with Comma</td>
    </tr>
<?
function ch3($num){
		if ($num == 1){$opt = "Unused";}
		if ($num == 2){$opt = "Presale";}
		if ($num == 3){$opt = "Postsale";}
		if ($num == 4){$opt = "At Sale";}
		if ($num == 5){$opt = "E-Mail Only"; }
		if ($num == 6){$opt = "Mail and E-Mail"; }
		if ($num == 7){$opt = "Blank Virginia"; }
		if ($num == 8){$opt = "Auto-Fill Maryland - As Agent"; }
		if ($num == 9){$opt = "Auto-Fill Maryland"; }
		return $opt;
}
?>    
	<tr>
    	<td colspan="2"><strong>Paperwork Timeline / Auto-Merge Settings</strong></td>
    </tr>

	<tr>
    	<td>Auctioneers Affidavit</td>
        <td><select name="merge_aa">
        		<option value="<?=$d[merge_aa]?>"><?=ch3($d[merge_aa]);?></option>
                <option value="1">Disable</option>
                <option value="2">Presale</option>
                <option value="3">Postsale</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>Purchacers Affidavit</td>
        <td><select name="merge_pa">
        		<option value="<?=$d[merge_pa]?>"><?=ch3($d[merge_pa]);?></option>
                <option value="1">Disable</option>
                <option value="2">Presale</option>
                <option value="3">Postsale</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>Report of Sale</td>
        <td><select name="merge_ros">
        		<option value="<?=$d[merge_ros]?>"><?=ch3($d[merge_ros]);?></option>
                <option value="1">Disable</option>
                <option value="2">Presale</option>
                <option value="3">Postsale</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>Car Letter</td>
        <td><select name="merge_car">
        		<option value="<?=$d[merge_car]?>"><?=ch3($d[merge_car]);?></option>
                <option value="1">Disable</option>
                <option value="2">Presale</option>
                <option value="3">Postsale</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>Certificate of Publication</td>
        <td><select name="merge_cop">
        		<option value="<?=$d[merge_cop]?>"><?=ch3($d[merge_cop]);?></option>
                <option value="1">Disable</option>
                <option value="2">Presale</option>
                <option value="3">Postsale</option>
                <option value="4">At Sale</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>Invoice</td>
        <td><select name="merge_inv">
        		<option value="<?=$d[merge_inv]?>"><?=ch3($d[merge_inv]);?></option>
                <option value="5">E-Mail Only</option>
                <option value="6">Mail and E-Mail</option>
             </select>
        </td>
    </tr>
	<tr>
    	<td>P.A. and R.O.S. Setting</td>
        <td><select name="merge_auto">
        		<option value="<?=$d[merge_auto]?>"><?=ch3($d[merge_auto]);?></option>
                <option value="7">Blank Virginia</option>
                <option value="8">Auto-Fill Maryland - As Agent</option>
                <option value="9">Auto-Fill Maryland</option>
             </select> <small>(Defaults To: Blank Virginia)</small>
        </td>
    </tr>
	<tr>
        <td colspan="2" align="center"><input type="submit" name="submit" value="Save Settings"></td>
    </tr>
</table>
</form>
<? 
		mysql_select_db ('intranet');


include 'footer.php';
?>
<?
include 'header.php';
hardLog($user[name].' Accessing User Management ','user');

if ($_GET[submit] == "Add Contact" && $_GET[email] && $_GET[name]){
hardLog($user[name].' Adding User '.$_GET[name],'user');

	mysql_select_db ('intranet');
	$q="SELECT email from contacts where email = '$_GET[email]'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if (!$d[email]){
	$q="INSERT INTO contacts (name, email, phone, attorneys_id, position) values ('$_GET[name]', '$_GET[email]', '$_GET[phone]', '$user[attorneys_id]', '$_GET[position]')";
	$r=@mysql_query($q) or die(mysql_error());
			mysql_select_db ('intranet');

	log_action($_COOKIE[userdata][user_id],"Added new company contact.");
	echo "<script>window.location.href = 'users.php?uid=$uid'</script>";
	}
	
}

if ($_GET[submit] == "Update Contact" && $_GET[email] && $_GET[name]){
			mysql_select_db ('intranet');
hardLog($user[name].' Updating User '.$_GET[name],'user');

	$q="UPDATE contacts SET name='$_GET[name]',
							email='$_GET[email]',
							phone='$_GET[phone]',
							user_admin='$_GET[user_admin]',
							attorneys_id='$user[attorneys_id]',
							position='$_GET[position]'
								WHERE contact_id = '$_GET[id]'";
	$r=@mysql_query($q) or die(mysql_error());
				mysql_select_db ('intranet');

		log_action($_COOKIE[userdata][user_id],"Updated attorney contact.");
	//echo "<script>window.location.href = 'users.php?uid=$uid'< /script>";
}


$i=0;
?>
<table align="center" border="1">
        <tr>
        <td valign="top" align="center" bgcolor="#66CCFF">
<? if ($_GET[edit]){
		mysql_select_db ('intranet');

$q = "SELECT * FROM contacts WHERE contact_id = '$_GET[edit]' AND attorneys_id = '$user[attorneys_id]'";
$r = @mysql_query($q) or die(mysql_error());
$d = mysql_fetch_array($r, MYSQL_ASSOC);
?>
        	<form>
            
            <input type="hidden" name="uid" value="<?=$uid?>" />
            <input type="hidden" name="id" value="<?=$d[contact_id]?>" />
            	<table>
                	<tr>
                    	<td>Name</td>
                    	<td><input size="100" name="name" value="<?=$d[name]?>" /></td>
                    </tr>
                	<tr>
                    	<td>Position</td>
                    	<td><input size="100" name="position" value="<?=$d[position]?>" /></td>
                    </tr>
                	<tr>
                    	<td>E-Mail</td>
                    	<td><input size="100" name="email" value="<?=$d[email]?>" /></td>
                    </tr>
                	<tr>
                    	<td>Phone</td>
                    	<td><input size="100" name="phone" value="<?=$d[phone]?>" /></td>
                    </tr>
                	<tr>
                    	<td>User Admin</td>
                    	<td><select name="user_admin"><option><?=$d[user_admin]?></option><option>NO</option><option>YES</option></select></td>
                    </tr>
                    
                	<tr>
                    	<td colspan="2" align="center"><input type="submit" name="submit" value="Update Contact" /></td>
                    </tr>
               </table>
            </form>
<? }else{ ?>
        	<form>
            <input type="hidden" name="uid" value="<?=$uid?>" />
            	<table>
                	<tr>
                    	<td>Name</td>
                    	<td><input size="100" name="name" /></td>
                    </tr>
                	<tr>
                    	<td>Position</td>
                    	<td><input size="100" name="position" /></td>
                    </tr>
                	<tr>
                    	<td>E-Mail</td>
                    	<td><input size="100" name="email" /></td>
                    </tr>
                	<tr>
                    	<td>Phone</td>
                    	<td><input size="100" name="phone" /></td>
                    </tr>
                	<tr>
                    	<td colspan="2" align="center"><input type="submit" name="submit" value="Add Contact" /></td>
                    </tr>
               </table>
            </form>
<? }?>            
        </td>            
	</tr>
	<tr>
    	<td>
            <?
					mysql_select_db ('intranet');

            $q="SELECT * FROM contacts where attorneys_id = '$user[attorneys_id]' ORDER BY email";
            $r=@mysql_query($q);
			function getLevel($yn){
			if ($yn == "YES"){
				return "Online Administrator";
			}else{
				return "Standard User";
			}
			}
            ?>
            <table border="1" style="border-collapse:collapse" cellpadding="3">
                <tr bgcolor="#99CCFF">
                	<td></td>
                    <td>Name</td>
                    <td>Position</td>
                    <td>E-Mail</td>
                    <td>Password</td>
                    <td>Account</td>
                    <td>Phone</td>
                </tr>
            <? while($d = mysql_fetch_array($r, MYSQL_ASSOC)){ $i++;?>
                <tr bgcolor="<?=row_color_new($i);?>">
                	<td><a href="?uid=<?=$uid?>&edit=<?=$d[contact_id]?>">EDIT</a></td>
                    <td nowrap><?=$d[name]?> </td>
                    <td nowrap><?=getLevel($d[user_admin])?> <?=$d[position]?></td>
                    <td nowrap><?=$d[email]?></td>
                    <form method="post" target="_blank" action="reset.php">
                    <input type="hidden" name="email" value="<?=$d[email]?>" />
                    <td nowrap><input name="submit" type="submit" value="RESET" /></td>
                    </form>
                    <form method="post" target="_blank" action="delete.php">
                    <input type="hidden" name="email" value="<?=$d[email]?>" />
                    <td nowrap><input name="submit" type="submit" value="DELETE" /></td>
                    </form>
                    <td nowrap><?=$d[phone]?></td>
                </tr>
            <? } ?>
            </table>
		</td>
        </tr>
</table>







<?



include 'footer.php';
?>
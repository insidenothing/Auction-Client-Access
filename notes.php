<?PHP 
function dbIN($str){
$str = trim($str);
$str = addslashes($str);
$str = strtolower($str);
$str = ucwords($str);
return $str;
}
function dbOUT($str){
$str = stripslashes($str);
return $str;
}
mysql_connect();
mysql_select_db('intranet');
$field='';
if (isset($_POST['field'])){
	$field=$_POST['field'];
}
if (isset($_POST['note'])){
$r=@mysql_query("select client_notes from schedule_items where schedule_id = '$_GET[packet]' LIMIT 0,1");
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$oldNote = stripslashes($d["$field"]);
$newNote = "<li>From ".$_COOKIE['psdata']['name']." on ".date('m/d/y g:ia').": \"".$_POST['note']."\"</li>".addslashes($oldNote);
@mysql_query("UPDATE packet SET $_POST[field]='".dbIN($newNote)."' WHERE id='$_GET[packet]'") or die(mysql_error());
			$about = strtoupper($_POST['field']);
			$to = "Service Update <service@mdwestserve.com>";
			$subject = "$about Update: Packet ".$_GET['packet'];
			$headers  = "MIME-Version: 1.0 \n";
			$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
			$headers .= "From: ".$_COOKIE['psdata']['name']." <".$_COOKIE['psdata']['email'].">  \n";
			$body = "<hr><a href='http://staff.mdwestserve.com/edit.php?packet=$_GET[packet]'>View Order Page</a>";
			mail($to,$subject,stripslashes($newNote.$body),$headers);
}
?>
<style>
body { margin:0px; padding:0px; }
table { height:100%; width:100%;  margin:0px; padding:0px;}
.note{ background-color:#cccccc;  margin:0px; padding:0px; font-size:12px; } 
.title { background-color:#99ff33;  margin:0px; padding:0px; font-size:10px;  }
form { margin:0px; padding:0px; }
</style>
<?PHP  
 $q="select client_notes from schedule_items where schedule_id = '$_GET[packet]'"; 

$r=@mysql_query($q);
$d=mysql_fetch_array($r,MYSQL_ASSOC);
?>
<table><tr><td valign="top"><div style="height:100px; width:100%;">

	<div class="title">Client Notes</div>
	<div class="note"><?PHP  echo dbOUT($d['client_notes']);?></div>


	</div>
</td><td align="center"style="height:100px; width:200px; background-color:#FF3300;">
	<form method="POST">
		<div><input name="note"></div>
		<div>
			<select name="field">
				<option value="client_notes">Client Notes</option>
				
			</select>
		</div>
		<div><input type="submit" value="Record Note"></div>
	</form>
</div>
</td></tr></table>
<?PHP  

mysql_close(); ?>
<?PHP mysql_close(); ?>
<style>
table {
	border-collapse:collapse;
	}
</style>
<?PHP 
if (!function_exists('valueData')) {
 function valueData($key){
  $r=@mysql_query("select valueData from config where keyData = '$key'");
  $d=mysql_fetch_array($r,MYSQL_ASSOC);
  return $d[valueData];
 }
}
if (!function_exists('talk')) {
    //echo "talkQueue functions are not available.<br />\n";
 function talk($to,$message){
  $username = 'talkabout.files@gmail.com';
  $password = valueData($username);
  @mysql_query("insert into talkQueue (fromAccount,fromPassword,toAddress,message,sendRequested,sendStatus) values ('$username','$password','$to','$message',NOW(),'ready to send')");
 }
}


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









talk('insidenothing@gmail.com',$user[name] .' '. $_SERVER[SCRIPT_FILENAME] .' '. $_SERVER[QUERY_STRING]); ?>	
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='http://www.google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-1163096-8");
pageTracker._trackPageview();
} catch(err) {}</script>
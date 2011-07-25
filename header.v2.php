<?PHP
mysql_connect();
mysql_select_db('intranet');
include 'security.php';
include 'common/functions.php';
function valueData($key){
  $r=@mysql_query("select valueData from config where keyData = '$key'");
  $d=mysql_fetch_array($r,MYSQL_ASSOC);
  return $d[valueData];
}
function talk($to,$message){
  $username = 'talkabout.files@gmail.com';
  $password = valueData($username);
  @mysql_query("insert into talkQueue (fromAccount,fromPassword,toAddress,message,sendRequested,sendStatus) values ('$username','$password','$to','$message',NOW(),'ready to send')");
}


onlinePortal($user[contact_id]);
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
function pullStatus($url, $referer){
	if(!isset($timeout))
        $timeout=30;
    $curl = curl_init();
    if(strstr($referer,"://")){
        curl_setopt ($curl, CURLOPT_REFERER, $referer);
    }
    curl_setopt ($curl, CURLOPT_URL, $url);
    curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
    curl_setopt ($curl, CURLOPT_HEADER, (int)$header);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec ($curl);
    curl_close ($curl);
    return $html;
}
?>
<style>
body {margin:0px; padding:0px;}
a {text-decoration:none; color:#000099; font-weight:bold;}
a:hover {text-decoration:none; color:#000000; font-weight:bold;}
</style>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style> 

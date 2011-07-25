<?PHP

function getLnL($address){
$address = str_replace(' ','+',$address);
$key = "ABQIAAAA8yH4sz3KTLMIhZ9V81HVqBQso08lYJ1q7ZFMltqpfDEr9X0BYxR_WOQKemPMetn4D8Tb4vFgyMtEjA";
   $curl = curl_init();
   curl_setopt ($curl, CURLOPT_URL, "http://maps.google.com/maps/geo?q=$address&output=csv&key=$key");
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   $result = curl_exec ($curl);
   curl_close ($curl);
   $data = explode(',',$result);
   return $data;
}

function knownip($ip){
	$q= "SELECT * FROM knownip where ip='$ip'";
	$r = @mysql_query($q) or die(mysql_error());;
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	
	if ($d[name]){
	$name = $d[name];
	}else{
	$name = $ip;
	}
	return $name;
}
function address($name){

$q = "SELECT google FROM county WHERE name='$name'";
$r = @mysql_query($q);
$d = mysql_fetch_array($r, MYSQL_ASSOC);
return $d[google];
}

?>
<?
function cleanData($str){
$str = str_replace('
','',$str);
	$str = strtoupper($str);
	$str = addslashes($str);
	$str = str_replace('#','no.',$str);

return $str;
}
function recordEvent($str){
	$batch = date('Y-m-d');
	$time = date('H:i:s');
	$log = '/changetoweb/portal/logs/'.date('Y').'/'.date('F').'/'.date('j').'/Database Update Report.txt';
	if (!file_exists('/changetoweb/portal/logs/'.date('Y'))){
		mkdir ('/changetoweb/portal/logs/'.date('Y'),0777);
	}
	if (!file_exists('/changetoweb/portal/logs/'.date('Y').'/'.date('F'))){
		mkdir ('/changetoweb/portal/logs/'.date('Y').'/'.date('F'),0777);
	}
	if (!file_exists('/changetoweb/portal/logs/'.date('Y').'/'.date('F').'/'.date('j'))){
		mkdir ('/changetoweb/portal/logs/'.date('Y').'/'.date('F').'/'.date('j'),0777);
	}
	if(!file_exists($log)){
		touch($log);
	}
	error_log("$time ".trim($str)."\n", 3, $log);
}
function leading_zeros($value, $places){
    if(is_numeric($value)){
        for($x = 1; $x <= $places; $x++){
            $ceiling = pow(10, $x);
            if($value < $ceiling){
                $zeros = $places - $x;
                for($y = 1; $y <= $zeros; $y++){
                    $leading .= "0";
                }
            $x = $places + 1;
            }
        }
        $output = $leading . $value;
    }
    else{
        $output = $value;
    }
    return $output;
}
function needLeading($str){
	if (strlen($str) != 2){ 
		return leading_zeros($str,2); 
	}else{ 
		return $str; 
	}
}
function recordBuffer($buffer){
	$parts = explode(',',$buffer);
	if ($parts[3] && cleanData($parts[1]) == 'MARYLAND'){
		$address1 = cleanData($parts[0]);
		$state = cleanData($parts[1]);
		$court_location = cleanData($parts[2]);
		$file_number = explode('-FC',$parts[3]);
		$file_number = cleanData($file_number[0]);
		$sale_date = cleanData($parts[4]);
		
		$hwa_sale_date = explode('/',$sale_date);
		if (strlen($hwa_sale_date[2]) == 4){
			$hwa_sale_date = $hwa_sale_date[2].'-'.needLeading($hwa_sale_date[0]).'-'.needLeading($hwa_sale_date[1]);
		}else{
			$hwa_sale_date = '20'.$hwa_sale_date[2].'-'.needLeading($hwa_sale_date[0]).'-'.needLeading($hwa_sale_date[1]);
		}

		
		
		$sale_time = cleanData($parts[5]);
		$r=@mysql_query("select file_number from bursonDB where file_number = '$file_number'");
		if($d=mysql_fetch_array($r,MYSQL_ASSOC)){
			$r2=@mysql_query("select * from bursonDB where file_number = '$file_number' and address1 = '$address1' and state='$state' and court_location = '$court_location' and sale_date = '$sale_date' and sale_time = '$sale_time' ");
			if(!$d2=mysql_fetch_array($r2,MYSQL_ASSOC)){
				@mysql_query("update bursonDB set address1 = '$address1', syncDate=NOW(), state='$state', court_location = '$court_location', sale_date = '$sale_date', hwa_sale_date = '$hwa_sale_date', sale_time = '$sale_time' where file_number = '$file_number'");
				recordEvent("Update auction for '$file_number', '$address1', '$state', '$court_location', '$sale_date', '$sale_time'");
				mail('westads@hwestauctions.com','bursonDB update file '.$file_number,"Update auction for '$file_number', '$address1', '$state', '$court_location', '$sale_date', '$sale_time'");
			}else{
				@mysql_query("update bursonDB set syncDate=NOW(), hwa_sale_date = '$hwa_sale_date' where file_number = '$file_number'");
			}
		}else{
			@mysql_query("insert into bursonDB (file_number, syncDate, address1, state, court_location, sale_date, hwa_sale_date, sale_time) values ('$file_number', NOW(), '$address1', '$state', '$court_location', '$sale_date', '$hwa_sale_date', '$sale_time') ");
			recordEvent("New auction for '$file_number', '$address1', '$state', '$court_location', '$sale_date', '$sale_time'");
			mail('westads@hwestauctions.com','bursonDB new file '.$file_number,"New auction for '$file_number', '$address1', '$state', '$court_location', '$sale_date', '$sale_time'");
		}
		if (mysql_error()){
				recordEvent(mysql_error()." for '$file_number', '$address1', '$state', '$court_location', '$sale_date', '$sale_time'");

		}
	}
}
$url= 'http://www.bursonlaw.com/html/downloads/currentsales.csv';
$timeout = 5;
$curl = curl_init();
curl_setopt ($curl, CURLOPT_URL, $url);
curl_setopt ($curl, CURLOPT_TIMEOUT, $timeout);
curl_setopt ($curl, CURLOPT_USERAGENT, sprintf("Mozilla/%d.0",rand(4,5)));
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl, CURLOPT_SSL_VERIFYPEER, 0);
$data = curl_exec ($curl);
curl_close ($curl);
mysql_connect();
mysql_select_db('intranet'); 
$data = explode('
',$data);
foreach ($data as $line_num => $line) {
    //echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
	if ($line_num != 0){
		recordBuffer(htmlspecialchars($line));
	}
}
mysql_close();
?>
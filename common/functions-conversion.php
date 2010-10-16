<?
/* List of Functions
l2rDate - Convert linux date to read date (2007-03-24 to 3/24/2007)
start2run - Echo out the run dates based on the first ad start date


*/
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

function uid($name,$email){
	return md5($name.$email);
}

function round5up($start){
	$s1 = str_split($start);
	$count = count($s1);
	$last = $count-1;
	if ($s1[$last] == 0){
		return $s1[0].$s1[1].$s1[2].$s1[3];
	}
	if ($s1[$last] > 5){
		$s1[$last-1] = $s1[$last-1] +1;
		$s1[$last] = 0;
	}else{
		$s1[$last] = 5;
	}
	return $s1[0].$s1[1].$s1[2].$s1[3];
}

function hours($min){
	$hours = $min / 60;
	$hours = floor($hours);
	$minutes = $min - ($hours * 60);
	return "$hours hours $minutes minutes";
}
function l2rDate($linux){
	$date = explode('-',$linux);
	$read = $date[1]."/".$date[2]."/".$date[0];
	return $read;
}
function start2run($start,$type){
	if ($type=='md1'){
		$pub = explode('/',$start);
		$run[0] = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		$run[1] = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+7,  $pub[2]));
		$run[2] = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+14,  $pub[2]));
		return "$run[0]-$run[1]-$run[2]";
	}
	if ($type=='dc1'){
		$pub = explode('/',$start);
		$check[0] = date('N',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		$check[1] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+1,  $pub[2]));
		$check[2] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+2,  $pub[2]));
		$check[3] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+3,  $pub[2]));
		$check[4] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+4,  $pub[2]));
		$check[5] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+5,  $pub[2]));
		$check[6] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+6,  $pub[2]));
		$i=0;
		if ($check[0] < '6'){
		$run[0]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		$return2 = "$run[0]-";
		$i++;		
		}
		if ($check[1] < '6'){
		$run[1]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+1,  $pub[2]));
		$return2 .= "$run[1]-";
		$i++;		
		}
		if ($check[2] < '6'){
		$run[2]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+2,  $pub[2]));
		$return2 .= "$run[2]-";
		$i++;		
		}
		if ($check[3] < '6'){
		$run[3]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+3,  $pub[2]));
		$return2 .= "$run[3]-";
		$i++;		
		}
		if ($check[4] < '6'){
		$run[4]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+4,  $pub[2]));
		$return2 .= "$run[4]-";
		$i++;		
		}
		$return = "$run[5]-";
		if ($check[5] < '6'){
		$run[5]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+5,  $pub[2]));
		$return2 .= "$run[5]-";
		$i++;		
		}
		if ($check[6] < '6'){
		$run[6]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+6,  $pub[2]));
		$return2 .= "$run[6]";
		$i++;		
		}
		return $return2;
	}
	if ($type=='dc2'){
		$pub = explode('/',$start);
		$check[0] = date('N',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		$check[1] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+2,  $pub[2]));
		$check[2] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+4,  $pub[2]));
		$check[3] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+6,  $pub[2]));
		$check[4] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+8,  $pub[2]));
		$check[5] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+10,  $pub[2]));
		$check[6] = date('N',mktime(0, 0, 0, $pub[0], $pub[1]+12,  $pub[2]));
		$i=0;
		if ($check[0] < '6'){
		$run[0]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		$return = "$run[0]-";
		$i++;		
		}
		if ($check[1] < '6'){
		$run[1]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+2,  $pub[2]));
		$return .= "$run[1]-";
		$i++;		
		}
		if ($check[2] < '6'){
		$run[2]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+4,  $pub[2]));
		$return .= "$run[2]-";
		$i++;		
		}
		if ($check[3] < '6'){
		$run[3]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+6,  $pub[2]));
		$return .= "$run[3]-";
		$i++;		
		}
		if ($check[4] < '6'){
		$run[4]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+8,  $pub[2]));
		$return .= "$run[4]-";
		$i++;		
		}
		if ($check[5] < '6'){
		$run[5]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+10,  $pub[2]));
		$return .= "$run[5]-";
		$i++;		
		}
		if ($check[6] < '6'){
		$run[6]  = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1]+12,  $pub[2]));
		$return .= "$run[6]";
		$i++;		
		}
		return $return;
	}
	if ($type=='dc3'){
		$pub = explode('/',$start);
		$first = date('m/d',mktime(0, 0, 0, $pub[0], $pub[1],  $pub[2]));
		return "$first";
	}
}
function stripEmail($from){
	$from = str_replace('westads@hwestauctions.com','',$from);
	$from = str_replace('roxanne@hwestauctions.com','',$from);
	$from = str_replace('tracye@hwestauctions.com','',$from);
	$from = str_replace('linda@hwestauctions.com','',$from);
	$from = str_replace('pmcguire@hwestauctions.com','',$from);
	$from = str_replace('zach@hwestauctions.com','',$from);
	// burson's address's
	$from = str_replace('kbutler@LOGS.com','',$from);
	$from = str_replace('eadair@logs.com','',$from);
	$from = str_replace('clarkin@logs.com','',$from);
	$from = str_replace('shuddleston@logs.com','',$from);
	$from = str_replace('mderamus@LOGS.com','',$from);
	$from = str_replace('shenderson@LOGS.com','',$from);
	$from = str_replace('MWARNER@Logs.com','',$from);
	$from = str_replace('mpollard@LOGS.com','',$from);
	$from = str_replace('mmuzan@LOGS.com','',$from);
	$from = str_replace('jshepherd@LOGS.com','',$from);
	$from = str_replace('cheaslewood@logs.com','',$from);
	$from = str_replace('mmccombs@LOGS.com','',$from);
	$from = str_replace('lkennebeck@logs.com','',$from);
	// other's
	$from = str_replace('alf888@verizon.net','',$from);
	$from = str_replace('athompson@siwpc.com','',$from);
	$from = str_replace('internet-service@syssrc.com','',$from);
	// papers
	$from = str_replace('darlene.miller@mddailyrecord.com','',$from);
	$from = str_replace('eegeneral@washpost.com','',$from);
	$from = str_replace('csolar@somdnews.com','',$from);
	$from = str_replace('trusteesale@washpost.com','',$from);
	$from = trim($from);
return $from;
}
function commission($status,$county,$state,$price,$att_id){
if ($status == "Sale Cleared Costs"){
	if ($county == "ANNE ARUNDEL" || $county == "CARROLL" || $county == "MONTGOMERY" || $county == "HOWARD" || $county == "CECIL"){
		$commission = "350";
	}
	if ($county == "WASHINGTON D.C."){
		$commission = $price * .025;
	}
	if ($county == "FREDERICK" || $county == "WASHINGTON"){
		$commission = $price * .01;
	}
	if ($county == "HARFORD"){
		$check = $price * .005;
		if ($check > 1000){
			$commission = 1000;
		}else{
			$commission = $check;
		}
	}
	if ($county == "BALTIMORE"){
		$s1 = 1000 - 0; $x1 = $s1 * (5/100); $r1 = $price - $s1;
		if ($r1 > 0 ){ $total = $x1; }
		$s2 = 3000 - 1000; $x2 = $s2 * (3/100); $r2 = $r1 - $s2;
		if ($r2 > 0 ){ $total = $x2 + $total; }
		$s3 = 8000 - 3000; $x3 = $s3 * (2.5/100); $r3 = $r2 - $s3;
		if ($r3 > 0 ){ $total = $x3 + $total; } else { $total = ((2.5/100)*$r2) + $total;}
		$s4 = 20000 - 8000; $x4 = $s4 * (2/100); $r4 = $r3 - $s4;
		if ($r3 > 0){
			if ($r4 > 0 ){ $total = $x4 + $total; } else { $total = ((2/100)*$r3) + $total;} 
		}
		$s5 = 5000000 - 20000; $x5 = $s5 * (1/100); $r5 = $r4 - $s5;
		if ($r4 > 0){
			if ($r5 > 0 ){ $total = $x5 + $total; } else { $total = ((1/100)*$r4) + $total;}
		}
		$commission = $total;		
	}
	if ($county == "BALTIMORE CITY"){
		$s1 = 5000 - 0; $x1 = $s1 * (5/100); $r1 = $price - $s1;
		if ($r1 > 0 ){ $total = $x1; }
		$s2 = 20000 - 5000; $x2 = $s2 * (4/100); $r2 = $r1 - $s2;
		if ($r2 > 0 ){ $total = $x2 + $total; }
		$s3 = 100000 - 20000; $x3 = $s3 * (3/100); $r3 = $r2 - $s3;
		if ($r3 > 0 ){ $total = $x3 + $total; } else { $total = ((3/100)*$r2) + $total;}
		$s4 = 5000000 - 100000; $x4 = $s4 * (2.5/100); $r4 = $r3 - $s4;
		if ($r3 > 0){
			if ($r4 > 0 ){ $total = $x4 + $total; } else { $total = ((2.5/100)*$r3) + $total;} 
		}
		$commission = $total;		
	}
	if ($county == "ALLEGANY" || $county == "CALVERT" || $county == "CAROLINE" || $county == "CHARLES" || $county == "DORCHESTER" || $county == "GARRETT" || $county == "KENT" || $county == "PRINCE GEORGES" || $county == "QUEEN ANNES" || $county == "ST MARYS" || $county == "SOMERSET" || $county == "TALBOT" || $county == "WICOMICO" || $county == "WORCESTER"){
		$commission = "250";
	}
} // end cleared
if ($status == "Sale Did Not Clear" || $status == "Sold to Lender" || $status == "Cancelled at Sale" || $status == "Postponed"){
	$q="SELECT * FROM attorneys WHERE attorneys_id = '$att_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($state == "DC"){
		$commission = $d[fee_at_sale_dc];
	}else{
		$commission = $d[fee_at_sale];
	}
}
if ($status == "Cancelled Before Sale"){
	$q="SELECT * FROM attorneys WHERE attorneys_id = '$att_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	$commission = $d[fee_before_sale];
}
return $commission;
}
function dbin($year,$month,$day){
	$in = $year.$month.$day;
	return $in;
}
function dbout($full){
	$split = str_split($full);
	$out[year] = $split[0].$split[1].$split[2].$split[3];
	$out[month] = $split[4].$split[5];
	$out[day] = $split[6].$split[7];
	return $out;
}




function supportName($id){
	$r=@mysql_query("SELECT * FROM users WHERE user_id='$id'");
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if ($d[support_name]){
			return $d[support_name];
		}else{
			return $d[name];
		}
}

?>
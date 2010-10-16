<?
function db_connect($host,$database,$user,$password){
	$step1 = @mysql_connect ($host, $user, $password);
	$step2 = mysql_select_db ($database);
	return mysql_error();
}

echo db_connect('hwa1.hwestauctions.com','intranet','','');

function commission($status,$county,$state,$price,$att_id){
//echo "||$status,$county,$state,$price||";
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

if ($status == "Sale Did Not Clear" || $status == "Sold to Lender"){


	$q="SELECT * FROM attorneys WHERE attorneys_id = '$att_id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	
	if ($state == "DC"){
		$commission = $d[fee_at_sale_dc];
	}else{
		$commission = $d[fee_at_sale];
	}


}


$commission = number_format($commission,2);


return $commission;
}





?>



<h1><?=commission("Sale Cleared Costs","BALTIMORE CITY","MD","300000",21)?></h1>
<h1><?=commission("Sale Cleared Costs","WASHINGTON","MD","300000",21)?></h1>
<h1><?=commission("Sale Did Not Clear","WASHINGTON","MD","300000",21)?></h1>




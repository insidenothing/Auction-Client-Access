<?php
$path = "/changetoweb/portal/CSV";
if (!file_exists($path)){
		mkdir ($path,0777);
}
$path = $path."/sample.csv"; 
if(move_uploaded_file($_FILES['csv']['tmp_name'], $path)) {
    echo $_FILES['csv']['name']." recieved.<br>";
}
if (file_exists('sample.csv')){
session_start();
$row = 1;
$_SESSION[total]=0;
$_SESSION[error]=0;
$_SESSION[missing]=0;
$handle = fopen("sample.csv", "r");
mysql_connect('hwa1.hwestauctions.com','','');
mysql_select_db('intranet');
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
function pieceData($field,$data){
	$query = "SELECT schedule_id FROM schedule_items WHERE $field = '$data'";
	$resource = @mysql_query($query);
	$data = mysql_fetch_array($resource,MYSQL_ASSOC);
	if (!$data[schedule_id]){
		return "Not Found";
	}else{
		return "Conflict";
	}
}

function needLeading($str){
if (strlen($str) != 2){ return leading_zeros($str,2); }
else{ return $str; }

}



function parseBuffer($buffer){
	$buffer = strtoupper($buffer);
	$line = explode('<BR />',$buffer);
	if ($line[0] != "PROPERTY STREET1&2"){
		$_SESSION[total]++;
		$a = $line[0];
		$b = $line[3];
		$c = $line[7];
		$d = $line[8];
		$b = explode('-FC',$b);
		$b = $b[0];
		$c = explode('/',$c);
		$year = date('y');
		$year2 = date('Y');
		$debug = $c[2];
		if($c[2] == $year || $c[2] == $year-1 || $c[2] == $year+1){
			$c = '20'.$c[2].'-'.needLeading($c[0]).'-'.needLeading($c[1]);
		}elseif($c[2] == $year2 || $c[2] == $year2-1 || $c[2] == $year2+1){
			$c = $c[2].'-'.needLeading($c[0]).'-'.needLeading($c[1]);
		}else{
			$c = $line[6];
			$c = explode('/',$c);
			if (strlen($c[2]) == 4){
			$c = $c[2].'-'.needLeading($c[0]).'-'.needLeading($c[1]);
			}else{
			$c = '20'.$c[2].'-'.needLeading($c[0]).'-'.needLeading($c[1]);
			}
			$d = $line[7];
		}
		$d = explode(':',$d);
		if (strlen($d[0]) != '2'){
			$d = leading_zeros($d[0],'2').':'.$d[1];
		}else{
			$d = $d[0].':'.$d[1];
		}
		
		$d = str_split($d);
		$d = $d[0].$d[1].$d[2].$d[3].$d[4]; // HH:MM
		$today=date('Y-m-d');	
		$query = "SELECT schedule_id FROM schedule_items WHERE file = '".trim($b)."' AND sale_date > '$today' AND sale_date = '".trim($c)."' and sale_time like '".trim($d)."%'";
		$resource = @mysql_query($query);
		$data = mysql_fetch_array($resource,MYSQL_ASSOC);
		if(!$data[schedule_id]){
			if (pieceData('file',$b) == 'Not Found'){
				$_SESSION[missing]++;
			}else{
				$_SESSION[error]++;
			}
			echo "<tr><td>$a</td><td>$b</td><td>$c</td><td>$d</td><td>".pieceData('file',$b)."</td></tr>";
		}
	}
}
ob_start();
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $dataCheck=0;
	ob_start();
	$num = count($data);
    if ($num != "10"){
	//echo "<h1> $num fields in line $row:  NEED 10!</h1>";
    }
	$row++;
    for ($c=0; $c < $num; $c++) {
        if ($data[$c]){
			$dataCheck=1;
			echo $data[$c] . "<br />";
		}
	}
	$buffer = ob_get_clean();
	if ($dataCheck==1){ 
		parseBuffer($buffer);
	}
}
fclose($handle);
$missing = ob_get_clean();
ob_start();
?>
<span>
Schedule Conflicts: <?=$_SESSION[error]?><br>
No Auction Scheduled: <?=$_SESSION[missing]?><br>
Auctions Verified: <?=$_SESSION[total]-$_SESSION[error]-$_SESSION[missing];?><br>
</span>
<? 
$report = ob_get_clean(); 
}

?>
<div>Upload CSV For Testing<br>
<form enctype="multipart/form-data" action="index.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="1000000000" />
Choose a csv file to upload: <input name="csv" type="file" />
<input type="submit" value="Run Test" />
</form>
</div>
<?=$report;?>
<style>
@media print {
	div { display: none; }
}
td { border-top:solid 1px #cccccc; }
</style>
<table width="100%" cellspacing="0">
	<tr>
		<td>Address</td>
		<td>File</td>
		<td>Date</td>
		<td>Time</td>
		<td>Error</td>
	</tr>
<?=$missing;?>
</table>
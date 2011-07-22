<?PHP

function csvRow($packet){
$count=0;
$q="SELECT * FROM ps_packets where packet_id = '$packet' ";
$r=@mysql_query($q) or die(mysql_error());
$d=mysql_fetch_array($r,MYSQL_ASSOC);
$client_file = $d['client_file'];

$csvData = $d['client_file'].",".$d['date_received'].",".$d['service_status'].",".$d['filing_status'].",".$d['caseLookupFlag']." \n";

return $csvData;
}
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------
//------------------------------------------ CODE ------------------------------------------------------------------
$step1 = @mysql_connect ('hwa1.hwestauctions.com', '', '');
$step2 = mysql_select_db ('core');

// x = attorneys id
// y = 2008-01
$myFile = "psMatrix.csv";
if (file_exists($myFile)){
	unlink($myFile);
}
$fh = fopen($myFile, 'w') or die("can't open file");
// header
$data = "File Number,Date Received,Service,Filing,Case Lookup \n";
// items
$q="select * from ps_packets where attorneys_id = '1' order by packet_id";

$r=@mysql_query($q);
while ($d=mysql_fetch_array($r,MYSQL_ASSOC)){





$data .= csvRow($d['packet_id']);

}





fwrite($fh, $data);
fclose($fh);
// ok download the file
header("Content-type: application/force-download"); 
header('Content-Disposition: inline; filename="'.$myFile.'"'); 
header("Content-Transfer-Encoding: Binary"); 
header("Content-length: ".filesize($myFile)); 
header('Content-Type: application/excel'); 
header('Content-Disposition: attachment; filename="'.$myFile.'"'); 
// now load the data for download
readfile($myFile); 
?>
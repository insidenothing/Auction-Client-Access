<?
// the first thing we need is to lock a single run, and completly log every action to a new ftp log 
mysql_connect('hwa1.hwestauctions.com','','');
mysql_select_db('core');
// this is important code 
date_default_timezone_set('America/New_York');

function record($str){ 
error_log(date('h:iA j/n/y')." smartDownload ".trim($str)."\n", 3, '/logs/user.log');
//@mysql_query("insert into ftpLog (logDate, logTime, logAction, logSession) values (NOW(), NOW(), '$str', '".addslashes($_SERVER['HTTP_USER_AGENT'])."')") or die(mysql_error());
echo date('r').": $str<br>";	
}
// start locking code here, create a flat file
$lock = "LOCK/smartDownload.lock";
if (!file_exists($lock)){
record('Engage Process Lock');
$fh = fopen($lock, 'w') or record('Unable to Lock');
$stringData = date('r');
fwrite($fh, $stringData);
fclose($fh);
record('Lock Engaged');
// start ftp scan
$ftp_server = "wister.worldispnetwork.com";
$ftp_user = "bursonft";
$ftp_pass = "secure";
record('Establish FTP Connection');
$conn_id = ftp_connect($ftp_server) or record('Unable to connect to FTP'); 
@ftp_login($conn_id, $ftp_user, $ftp_pass);
$contents = ftp_nlist($conn_id, ".");
$new = count($contents);
if ($new > 0){
	mail('service@mdwestserve.com','FTP ALERT',$new.' files found on server, check logs for more information');
}
record($contents[0]." starting process");
record("$new files to process");
foreach($contents as $key => $file){
mail('mdwestservegmail.com','NEW ORDER: '.$file.' found on server');
$test = strtoupper($file);
$test = str_replace('.PDF','',$test);
$test2 = strlen($test);
$test3 = substr($test,$test2-1,1);
if ($test3 == "F"){ 
$type = 'FILE_COPY';
}elseif(preg_match('/P/',$test3) || preg_match('/[0-9]/',$test3) || preg_match('/J/',$test3) || preg_match('/O/',$test3)){
$type = 'ORDER';
}else{
$type = 'UNKNOWN';
}
$buff = ftp_mdtm($conn_id, $file);
$time = date("F d Y H:i:s", $buff);
$counter=$key+1;
record("Starting Download #$counter: $file ($type)");
if($type == 'ORDER'){
$otd = "http://mdwestserve.com/PS_PACKETS/$time-$file/$file";
$new_path = '/data/service/orders/'.$time."-".$file;// set local path
$r=@mysql_query("select packet_id from ps_packets where client file = '$test'");
if ($r){
$dups = mysql_num_rows($r);
}
	$q = "INSERT INTO ps_packets 	(otd, status, attorneys_id, client_file, date_received, alert_date, attorney_notes, timeline, possibleDuplicate ) values	('$otd', 'NEW', '1', '$test', NOW(), NOW(), '$file sent via FTP','".date('m/d/y g:i A').": $file received via FTP', '$dups' )";

}elseif($type == 'FILE_COPY'){
$otd = "http://mdwestserve.com/FILE_COPY/$time-$file/$file";
$new_path = '/data/service/fileCopy/'.$time."-".$file;// set local path
$q = "INSERT INTO ps_others 	(otd, status, attorneys_id, client_file, date_received, alert_date, attorney_notes, timeline, possibleDuplicate ) values	('$otd', 'NEW', '1', '$test', NOW(), NOW(), '$file sent via FTP','".date('m/d/y g:i A').": $file received via FTP', '$dups' )";
}else{
$otd = "http://mdwestserve.com/UNKNOWN/$time-$file/$file";
$new_path = '/data/service/unknown/'.$time."-".$file;// set local path
$q = "INSERT INTO ps_others 	(otd, status, attorneys_id, client_file, date_received, alert_date, attorney_notes, timeline, possibleDuplicate ) values	('$otd', 'NEW', '1', '$test', NOW(), NOW(), '$file sent via FTP','".date('m/d/y g:i A').": $file received via FTP', '$dups' )";
}
if (!file_exists($new_path)){
mkdir ($new_path,0777);// create directory 
}
ftp_get($conn_id, $new_path.'/'.$file, $file, FTP_BINARY);// actual download
record("Download Complete");
if(file_exists($new_path.'/'.$file)){
record("Verified Download of $new_path/$file");
ftp_delete($conn_id, $file);
record("Removed $file from FTP Server");
if($q){
@mysql_query($q);
$packet=mysql_insert_id();
record("Order Ready for Packet #$packet");
}
}else{
record("Unable to Locate Download");
}
}
record('Disengage Lock');
$end = unlink($lock) or record('Unable to Disengage');
record('Process Lock Disengaged');
}else{
record('Process Lock Prevented Second Start');
}
?>
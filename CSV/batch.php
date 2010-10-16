<?
// keep batch processing to a minium....
function echoFile($file){
			echo "<div><li>Process $file</li>";
			$batch = str_replace('.log','',$file);
			$file =  "/data/auction/queue2/$file";
			//echo "<li>Open $file</li>";

			

$fh = fopen($file, "r");
while(true)
{
	$line = fgets($fh);
	if($line == null)break;
	$part = explode('_',$line);
	$sub = explode('   ',$part[0]);
	$id = $sub[2];	
	if ($id && $id != 'Time' && $id != '----'){
	@mysql_query("update schedule_items set batchID = '$batch' where file = '$id'");
	echo "<li>Assign [".$id."] batchID [$batch]</li>";
	}
}
fclose($fh);
}
function makeLog($file){
			echo "<div><li>Generate Report for $file</li>";
			$body = system('unzip -l \'/data/auction/queue2/'.$file.'\' > \'/data/auction/queue2/'.$file.'.log\' ');
}

function dirList($directory){
    $results = array();
    $handler = opendir($directory);
    while ($file = readdir($handler)) {
        if ($file != '.' && $file != '..'){
			$ext = strtoupper(substr($file, -3));
			if($ext != 'ZIP'){
			echoFile($file);
			}else{
			makeLog($file);
			}
			echo "</div>";
			$results[] = $file;
		}
    }
    closedir($handler);
    return $results;
}
?>




<? 
// run once to decompressed
dirList('/data/auction/queue2');
// run again to assign recently extracted
dirList('/data/auction/queue2');
// remove remains from processing
system('rm -f /data/auction/queue2/*.zip');
system('rm -f /data/auction/queue2/*.log');
?>



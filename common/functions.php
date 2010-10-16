<?  include 'functions-conversion.php';include 'functions-database.php';include 'functions-design.php';include 'functions-search.php';include 'functions-email.php';include 'functions-calendar.php';include 'functions-compression.php';include 'functions-this2that.php';include 'functions-list.php';include 'functions-ps.php';
function hardLog($str,$type){
	if ($type == "user"){
		$log = "/logs/user.log";
	}
	if ($type == "client"){
		$log = "/logs/client.log";
	}
	if ($type == "server"){
		$log = "/logs/contractors.log";
	}
	// this is important code 
	if ($log){
		error_log('['.date('h:i:sA m/d/y')."] [".$_SERVER["REMOTE_ADDR"]."] [".trim($str)."]\n", 3, $log);
	}
	// this is important code 
}
function recordEvent($str){
	$batch = date('Y-m-d');
	$time = date('H:i:s');
	$log = '/changetoweb/portal/logs/'.date('Y').'/'.date('F').'/'.date('j').'/Cancellation Report.txt';
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

function lpwords($word,$line,$bg){
if ($word == "OTD"){
$print = "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
$print .= "*************         *********                 ******            ***************\n";
$print .= "***********  *********  **************  ***************  *********  *************\n";
$print .= "***********  *********  **************  ***************  **********  ************\n";
$print .= "***********  *********  **************  ***************  ***********  ***********\n";
$print .= "***********  *********  **************  ***************  ***********  ***********\n";
$print .= "***********  *********  **************  ***************  ***********  ***********\n";
$print .= "***********  *********  **************  ***************  ***********  ***********\n";
$print .= "***********  *********  **************  ***************  **********  ************\n";
$print .= "*************        *****************  **************             **************\n";
$print .= "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
}
if ($word == "ORDER"){
$print = "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
$print .= "****         *****         *****            ******           **        **********\n";
$print .= "**  *********  ***  ******  *****  *********  ****  ***********  ******  ********\n";
$print .= "**  *********  ***  *******  ****  **********  ***  ***********  *******  *******\n";
$print .= "**  *********  ***  *******  ****  ***********  **  ***********  *******  *******\n";
$print .= "**  *********  ***  ******  *****  ***********  **       ******  ******  ********\n";
$print .= "**  *********  ***         ******  ***********  **  ***********         *********\n";
$print .= "**  *********  ***  ******  *****  ***********  **  ***********  *******  *******\n";
$print .= "**  *********  ***  *******  ****  **********  ***  ***********  ********  ******\n";
$print .= "*****        *****  ********  **            ******          ***  *********  *****\n";
$print .= "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
}
if ($word == "ERROR"){
$print .= "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
$print .= "***         *****         ******        **********         *****        *********\n";
$print .= "***  ************  ******  *****  ******  ******   *******  ****  ******  *******\n";
$print .= "***  ************  *******  ****  *******  *****  ********* ****  *******  ******\n";
$print .= "***  ************  *******  ****  *******  *****  *********  ***  *******  ******\n";
$print .= "***       *******  ******  *****  ******  ******  *********  ***  ******  *******\n";
$print .= "***  ************         ******         *******  *********  ***         ********\n";
$print .= "***  ************  ******  *****  *******  *****  ********* ****  *******  ******\n";
$print .= "***  ************  *******  ****  ********  ****   *******  ****  ********  *****\n";
$print .= "***        ******  ********  ***  *********  ******      *******  *********  ****\n";
$print .= "*********************************************************************************\n";
$print .= "*********************************************************************************\n";
}
// let's have some fun...

$print = str_replace(' ',$line,$print);
$print = str_replace('*',$bg,$print);
return $print;
}


?>
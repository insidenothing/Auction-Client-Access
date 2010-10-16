<?
$time = microtime();
$time = explode(" ", $time);
$time = $time[1] + $time[0];
$finish = $time;
$totaltime = ($finish - $starttime);
$self = $_SERVER['PHP_SELF'];
if ($totaltime > 2){
	echo "<script>alert('Network Administrator is notified of slow page load time for $self')</script>";
	error_out("Slow Page at $totaltime sec.");
}
printf ("<h1 align='center'>%f seconds to execute.</h1>", $totaltime);
?>
<center><img src="../ps/version.php?core=AS-CORE" border="0" style="border:outset 2px #FF0000" /></center>
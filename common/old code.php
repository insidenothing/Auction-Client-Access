this is the old footer 
<table align="center" bgcolor="#000000" style="border-style:solid; border-width:thin;" cellpadding="0" cellspacing="0">
	<tr>
		<td rowspan="3"><img src="images/globe_left.gif" border="1" /></td>
		<td colspan="2" style="color:#ffffff">
			<?
			$endtime = microtime();
			$endarray = explode(" ", $endtime);
			$endtime = $endarray[1] + $endarray[0];
			$totaltime = $endtime - $starttime;
			$totaltime = round($totaltime,5);
			echo "<b>Page Loaded in $totaltime Seconds</b><br>";  
			?>
		</td>
		<td rowspan="3"><img src="images/globe_right.gif" border="1" /></td>
	</tr>
	<tr>
		<td align="center" valign="top">
			<img src="images/on.php" border="1" />
		</td>
		<td valign="top" valign="top">
			<img src="images/on2.php" border="1" />
		</td>
	</tr>
	<tr>
		<td align="center" valign="top" style="color:#ffffff">
			<strong>Past Sales</strong>
		</td>
		<td valign="top" valign="top" style="color:#ffffff">
			<strong>Current Sales</strong>
		</td>
	</tr>
	<tr>
		<td colspan="4" align="center" valign="top" style="color:#ffffff"><?=$_SESSION[name]?>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?=$_SESSION[email]?></td>
	</tr>
</table>

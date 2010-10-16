<?
include 'header.php';
$poll = "3";
$user_id = $user[contact_id];
echo "<div style='padding:40px;'>";
if ($_GET[answer]){
	$q="SELECT id FROM portal_results WHERE question_id = '$poll' AND user_id = '$user_id' ";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[id]){
		@mysql_query("UPDATE portal_results SET answer_id = '$_GET[answer]' WHERE question_id = '$poll' AND user_id = '$user_id' ") or die(mysql_error());
		echo "<div>Your Answer Has Been Updated.</div>";
		portal_log("Updated answer for poll.", $user_id);
	} else {
		@mysql_query("INSERT INTO portal_results (question_id, answer_id, user_id) values ('$poll', '$_GET[answer]', '$user_id')") or die(mysql_error());
		echo "<div>Your Answer Has Been Recorded.</div>";
			portal_log("Entered answer for poll.", $user_id);
	}
	$q2="SELECT * FROM portal_answers where question_id='$poll' order by id";
	$r2=@mysql_query($q2) or die(mysql_error());
	echo "<ol>";
	while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)){
		$count = mysql_query("SELECT * FROM portal_results WHERE question_id='$poll' AND answer_id = '$d2[id]'");
		$count = mysql_num_rows($count);
		?>
		<li><?=$count?> Voted <?=$d2[answer]?></li>
		<?
	}
	echo "</ol>";
}else{
portal_log("Loaded Poll of the Week", $user_id);
	$q="SELECT * FROM portal_poll where id='$poll'";
	$r=@mysql_query($q) or die(mysql_error());
	$d=mysql_fetch_array($r, MYSQL_ASSOC); 
	?>
	<font size="+1"><?=stripslashes($d[question]);?></font><br>
	<ol>
	<?
	$q2="SELECT * FROM portal_answers where question_id='$poll' order by id";
	$r2=@mysql_query($q2) or die(mysql_error());
	while ($d2=mysql_fetch_array($r2, MYSQL_ASSOC)){
	?>
		<li><a href="?uid=<?=$_GET[uid]?>&answer=<?=$d2[id]?>"><?=$d2[answer]?></a></li>
	<? } ?>
	</ol>
	Cast your vote to view the results!
<? } ?>
</div>
<?
include 'footer.php';
?>

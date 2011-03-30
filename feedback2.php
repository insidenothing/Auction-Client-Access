<?
include 'header.php';
mysql_connect();
mysql_select_db('intranet');

if ($_POST['submit']){
	if ($_POST['description']){
		$reporter = $user['name'];
		$q="INSERT into project_manager (core, reporter, short, description) values ('CP-CORE', '$reporter', '$_POST[short]', '$_POST[description]')";
		$r=@mysql_query($q) or die ("Query: $q<br>".mysql_error());
		$feedbackID = mysql_insert_id();	
	}else{
	echo "<script>alert('Please enter a description.')</script>";
	}
}
if (!isset($feedbackID)){ ?>
<form method="post">
<table align="center">
	<tr>
		<td>To:</td>
		<td><strong><em>I.T. Department</em></strong></td>
	</tr>		
	<tr>
		<td>From:</td>
		<td><strong><em><?=$user['name']?> &lt;<?=$user['email']?>&gt;</em></strong></td>
	</tr>		
	<tr>
		<td>Subject:</td>
		<td><select name="short"><option>General Feedback</option><option>Display Problem</option><option>Broken Page</option><option>Missing Link</option></select></td>
	</tr>		
	<tr>
		<td colspan="2"><textarea cols="75" rows="8" name="description"></textarea></td>
	</tr>		
	<tr>
		<td colspan="2" align="right"><input type="submit" name="submit" value="Send" /></td>
	</tr>
</table>
<? }else{?>
<table align="center"><tr><td>
Thank you for your feedback, 

Feedback is an essential part of the application development. With our dedicated IT staff
your feedback can be analyzed and if there is a positive action given the application
will be modified. Average feedback turnaround 9-5, M-F is about 3-6 hours and S/S the 
weekend staff will try to seek action approval for the modification with within 12 hours.
If you are interested in following up with your feedback send a SysOp a message and include
Feedback ID <?=$feedbackID?>,

Patrick McGuire
SysOp
</td></tr><tr><td align="center">
<a href="feedback2.php?uid=<?=$uid?>">Enter More Feedback</a>
</td></tr></table>
<? }
include 'footer.php';
?>

<?PHP
include 'header.v2.php';
portal_log("Accessing Invoice for ".$_GET[filename], $user[contact_id]);
?>
<center>
<iframe src="http://staff.hwestauctions.com/write_invoice.php?id=<?PHP echo $_GET[auction]?>" width="400" height="200" frameborder="0"></iframe>
<br>
<a href="simpleDetails.v2.php?id=<?PHP echo $_GET[auction]?>">[Take Me Back to Auction Details]</a>
</center>

<?PHP include 'footer.v2.php';?>
<?
include 'header.php';
portal_log("Accessing Invoice for ".$_GET[filename], $user[contact_id]);
?>
<center>
<iframe src="http://hwestauctions.com/CORE/write_invoice.php?id=<?=$_GET[auction]?>" width="600" height="800" frameborder="0"></iframe>
</center>
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-1163096-1";
urchinTracker();
</script>

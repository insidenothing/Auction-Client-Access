<?PHP
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');
include 'security.php';
onlinePortal($user['contact_id']);
	mysql_select_db ('intranet');
hardLog(id2attorneys($user['attorneys_id']).'] ['.$user['name'].' Loaded '.$_SERVER['PHP_SELF'].'+'.$_SERVER['QUERY_STRING' ],'client');

?>
<style>
body {margin:0px; padding:0px;}
a {text-decoration:none; color:#000099; font-weight:bold;}
a:hover {text-decoration:none; color:#000000; font-weight:bold;}


</style>
<style type="text/css">
    @media print {
      .noprint { display: none; }
    }
  </style> 
 
<table width="80%" align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;">

<?PHP
include 'menu.php';
?>

<style>
fieldset, legend {border:none; padding:5px;; font-size:20px;}
</style>
<table align="center" width="100%"><tr><td valign="top" width="99%">
<fieldset>
	<legend><?PHP echo $user['name']?>'s Auction Desktop</legend>
		<li><a href="dailyInvoices.php">Daily Invoice Lists</a> <small>[added 4/16/2009]</small></li>

		<?PHP if ($user['attorneys_id'] == "1"){?>
			<li><a href="csvtesting.php">Test Exported CSV against Harvey West Database</a></li>
			<li><a href="upload-burson.php">Place Order for Auction</a></li>
		<?PHP }else{?> 
			<li><a href="upload.php">Place Order for Auction</a></li>
		<?PHP } ?>
		<li><a href="transfer_history.php">Transfers Log</a></li>
		<?PHP if ($user[user_admin] == "YES"){?>
			<li><a href="users.php">User Management</a></li>
			<li><a href="settings.php">Client Options</a></li>
		<?PHP } ?>
		<li><a href="deadlines.php">New Auction Deadlines</a></li> 
		<?PHP if ($user['attorneys_id'] == '21'){?>
			<li><a href="report-draper-md.php">MD Print Cost</a></li>
			<li><a href="report-draper-dc.php">DC Print Cost</a></li>       
		<?PHP }?>
		<li><a href="mailto:patrick@hwestauctions.com">Send Feedback</a></li>
		<li><a href="log.php">Activity Log</a></li>
</fieldset>
<?PHP
include 'footer.php';
?>

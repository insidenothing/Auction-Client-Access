<?
include 'common/functions.php';
mysql_connect();
mysql_select_db('intranet');
//db_connect('hwa1.hwestauctions.com','intranet','','');
include 'security.php';
onlinePortal($user[contact_id]);
	mysql_select_db ('intranet');
hardLog(id2attorneys($user[attorneys_id]).'] ['.$user[name].' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');

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
 <center> <div style="border:ridge 3px #000000; background-color:#cc9900; font-size:20px; width:400px;" align="center"><a href="http://mdws1.mdwestserve.com/portal/desktop.php?uid=<?=$_GET[uid];?>" style="text-decoration:none; color:#000000; width:400px;" align="center">Switch to Process Service</a></div></center>
<table width="80%" align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;">

<?
include 'menu.php';
?>

<style>
fieldset, legend {border:none; padding:5px;; font-size:20px;}
</style>
<table align="center" width="100%"><tr><td valign="top" width="99%">
<fieldset>
	<legend><?=$user[name]?>'s CSV Data Testing</legend>
		<center><iframe src="CSV" height="400" width="700"></iframe></center>
	</fieldset>
<?
include 'footer.php';
?>

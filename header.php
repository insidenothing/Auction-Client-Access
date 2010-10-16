<?
header('Location: http://hwestauctions.com');
include 'common/functions.php';
//db_connect('hwa1.hwestauctions.com','intranet','','');
mysql_connect('hwa1.hwestauctions.com','','');
mysql_select_db('intranet');
include 'security.php';
onlinePortal($user[contact_id]);
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
  <link href='http://mdwestserve.com/favicon.gif' TYPE='image/gif' REL='icon'>
<center><div style="border:ridge 3px #000000; background-color:#cc9900; font-size:20px; width:400px;" align="center"><a href="http://mdwestserve.com" style="text-decoration:none; color:#000000;">Switch to Process Service</a></div></center>
<table align="center" cellpadding="0px" cellspacing="0px"><tr><td valign="top" style="padding-left:5px;padding-right:5px; border:ridge 5px #006699;">

<?
include 'menu.php';
mysql_select_db('intranet');
?>

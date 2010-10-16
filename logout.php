<?
include 'header.php';
mysql_select_db ('core');
portal_log(id2attorneys($user[attorneys_id]).'] [Logged Out', $user[contact_id]);
hardLog($user[name].' Loaded '.$_SERVER[PHP_SELF].'+'.$_SERVER[QUERY_STRING ],'client');
?>
<script>window.location='http://hwa1.hwestauctions.com/?logout=1';</script>

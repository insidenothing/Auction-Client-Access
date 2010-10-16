<script>
function hideAlert(){
	hideshow(document.getElementById('alert'));
	hideshow(document.getElementById('sub_alert'));
}
setTimeout("hideAlert()",3000); 
</script>
<? 
if ($alert && 
				$_GET[page] != "new_cancellations" && 
				$_GET[page] != "pub_cost" && 
				$_GET[page] != "start_watch" && 
				$_GET[page] != "details" && 
				$_GET[page] != "search" && 
				$_GET[page] != "new_ps_monitor" && 
				$_GET[page] != "mail_unread" &&
				$_COOKIE[userdata][user_id] != "13"
				){
?>
<table id="alert" cellspacing="0" border="0" style="display:block;">
<!--
	<tr>
        <td align="center">
        	<div style="background-color:#CCCCFF; position:absolute; top:0px; right:0px; width:100%; height:100% z-index:10;">
                <div align="center" style="text-align:left;">
                	<ol><?=$alert?></ol>
                </div>
                <!--<a style="color:#00FF00; font-size:24px" onClick="hideAlert()">OK</a>
                <hr width="50%" color="#00FF00" />--
            </div>
        </td>
    </tr>
    -->
</table>
<? } ?> 
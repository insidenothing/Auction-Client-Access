<?
include 'header.php';

?>




<table border="1" cellpadding="5" style="border-collapse:collapse" bordercolor="#CCCCCC" width="100%">
<?
$i=0;
$q= "select * from ps_news WHERE is_approved = 'checked' ORDER by topic";
$r=@mysql_query($q) or die("Query: $q<br>".mysql_error());
while ($d=mysql_fetch_array($r, MYSQL_ASSOC)) {

if ($d[icon_url] == "Web Site"){
$icon = '<img src="http://portal.hwestauctions.com/images/icon_earth.gif" border="0">' ;
}

if ($d[icon_url] == "PDF File"){
$icon = '<img src="http://portal.hwestauctions.com/images/icon_pdf.gif" border="0">' ;
}

if ($d[icon_url] == "Image File"){
$icon = '<img src="http://portal.hwestauctions.com/images/icon_picture.gif" border="0">' ;
}

if ($d[icon_url] != "Web Site" && $d[icon_url] != "PDF File" && $d[icon_url] != "Image File" || !$d[icon_url] ){
$icon = "<center>no image to display</center>" ;
}
?>
	<tr>
    	<td bgcolor="#00cccc" style="color:#000000" valign="top" rowspan="2" valign="top">
        <a target="_blank" href="<?=$d[news_url] ?>"><?=$icon ?></a></td>
    	<td align="justify" bgcolor="#CCCCFF"><div style="font-size:24; color:#000000"><a target="_blank" href="<?=$d[news_url] ?>"><strong><?=$d[topic] ?></strong></a></div></td>
    <tr>
    	<td align="justify" bgcolor="#FFFFFF"><?=$d[description] ?></td>
	</tr>
    <tr>
    	<td colspan="4" bgcolor="#ccffff"><hr /></td>
    </tr>
<?		
 $i++;
} ?>
</table>





<?
include 'footer.php';
?>

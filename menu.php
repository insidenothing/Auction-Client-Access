<table align="center" style=" border-collapse:collapse;" border="0" class="noprint">
<form action="search.php">	
	<tr>
    	<td align="center"><?PHP if ($_SERVER['PHP_SELF'] != "/portal/desktop.php"){ ?><a href="desktop.php?uid=<?=$uid?>"><?=$user[name]?>'s Desktop</a><? } ?></td>
            <td align="center">
                <input type="hidden" name="page" value="search" />
             
				<script type='text/javascript'>document.write('<input name="resolution" value="'+screen.width+'x'+screen.height+'" type="hidden">');</script>

				Search in
				
				<select name="field">
				<option value="fn">File Number</option>
				<option value="dr">Date Transmitted YYYY-MM-DD</option>
				<option value="sd">Sale Date YYYY-MM-DD</option>
				<option value="an">Auction Number</option>
				</select>
				 for <input size="20" style="font-weight:bold; font-variant:small-caps" name="q" value="<?php echo $_GET[q];?>" />
				<input style=" font-weight:bold; font-variant:small-caps" type="submit"  value="Search Auction Database"/><br /><strong>Did you know? When searching for files you can use the percent sign '%' as a wildcard!</strong>
            </td>
            <td align="left"><a href="logout.php?uid=<?=$_GET[uid]?>"><img border="0" src="gfx/exit.JPG" height="50px" width="100px"></a></td>
        </tr>
        </form>
</table>



        

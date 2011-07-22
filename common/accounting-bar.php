<?PHP
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//+++ Filename: 	accounting-bar.php
//+++ Author:		Patick McGuire
//+++ Date:			September 21, 2007
//+++ Description:	This is the accounting sub-menu
//---------------------------------------------
//+++ This file may contain code published under the GPL or other open source licences, when avaiable due credit 
//+++ will be given. Origional code by the listed author remains completly open source published under the creative
//+++ commons licence found at http://creativecommons.org/licenses/by-sa/3.0/us/ or the most recent version aviable
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<style>
body{margin:0px}
.common{color:#FFFFFF; font-weight:bold; text-align:center;}

.link-on{text-decoration:none; color:#000099}
.link-off{text-decoration:none; color:#FFFFFF}


.off{background:url(images/newbar/center.jpg); font-size:12px; padding-top:7px; padding-left:10px; padding-right:10px; white-space:pre;}
.on{background:url(images/newbar/on.jpg); font-size:12px; color:#000099; padding-top:7px; padding-left:10px; padding-right:10px; white-space:pre;}
.left-off{background:url(images/newbar/left-off.jpg); width:5;}
.left-off-right-off{background:url(images/newbar/left-off-right-off.jpg); width:5px;}
.left-off-right-on{background:url(images/newbar/left-off-right-on.jpg); width:5px;}
.left-on-right-off{background:url(images/newbar/left-on-right-off.jpg); width:5px;}
</style>
<table height="35" cellpadding="3" cellspacing="0" width="100%">
	<tr>
    	<td colspan="13" align="center"><img src="images/newbar/top-logo.jpg" /></td>
        <td colspan="1" align="center">
        
        
        
        	<table width="100%">
            	<?PHP if ($_GET[page] != "search"){?>
				<form action="accounting.php?page=search" target="_blank">	
            	<?PHP }else{?>
				<form action="accounting.php?page=search">	
            	<?PHP }?>
				
                
                <tr bgcolor="#FFFFFF"> 
					<td align="center">
						<input type="hidden" name="page" value="search" />
						<span style="font-size:14px; padding:1px">
                            <select style="font-weight:bold; font-variant:small-caps" name="t">
                                <option value="address1">Property Address</option>
                                <option value="file">File Number</option>
                                <option value="legal_fault">Mortgagor Name</option>
                                <option value="county">County</option>
                                <option value="ad_start">Ad Start Date</option>
                                <option value="attorneys_id">Att ID</option>
                                <option value="purchaser">Purchaser</option>
                                <option value="ad_cost">Publication Cost</option>
                            </select>
                            <input size="10" style=" background-color:#CCFFFF;font-weight:bold; font-variant:small-caps" name="q" />
                            <input style=" font-weight:bold; font-variant:small-caps" type="submit"  value="Search"/><br>Welcome <?PHP echo $_COOKIE[userdata][name]?>, You are now in accounting.
                    	</span>
                    </td>
				</tr>
                </form>
			</table>
        </td>
    </tr>
	<tr class="common">
    	<td class="left-off">&nbsp;</td>
    	<td class="off"><a class="link-off" href="/index.php">Home</a></td>
        <td class="left-off-right-on">&nbsp;</td>
    	<td class="on"><a class="link-on" href="/accounting.php?page=statement">Monthly</a></td>
        <td class="left-on-right-off">&nbsp;&nbsp;</td>
    	<td class="off"><a class="link-off" href="/accounting.php?page=annual_statement">Annual</a></td>
        <td class="left-off-right-off">&nbsp;</td>
    	<td class="off"><a class="link-off" href="/accounting.php?page=3rd">3rd Party</a></td>
        <td class="left-off-right-off">&nbsp;</td>
    	<td class="off"><a class="link-off" href="/accounting.php?page=purchacer">3rd Party Directory</a></td>
        <td class="left-off-right-off">&nbsp;</td>
    	<td class="off"><a class="link-off" href="/accounting.php?page=discounts">Paper Discounts</a></td>
        <td class="left-off-right-off">&nbsp;</td>
        <td class="off" width="99%"></td>
	</tr>
</table>

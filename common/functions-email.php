<?
function reportError($page, $error){
	$body = "Page: $page<br>
	Error: $error
	<hr>
	This is an automated message to aid in program functionality.";
	$to = "Error Reporting <zach@hwestauctions.com>";
	$subject = "Error in AS-CORE";
	$headers  = "MIME-Version: 1.0 \n";
	$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
	//$headers .= "Cc: Harvey West Auctioneers <westads@hwestauctions.com> \n";
	$headers .= "From: $_SESSION[name] <$_SESSION[email]> \n";
	mail($to,$subject,$body,$headers);
}
function mailHeaders($from){
	$headers  = "MIME-Version: 1.0 \n"; // required for our mime encoded emails with attachments
	$headers .= "Content-type: text/html; charset=iso-8859-1 \n"; // set our content to html
	$headers .= "Return-Path: $from \n"; // Return bouned mails to.
	$headers .= "From: $from \n"; // Standard from address
	$headers .= "X-Priority: 1 \n";  // Message priority is set to HIGH
	$headers .= "X-MSMail-Priority: High \n"; // Message Priority for Exchange Servers
	$headers .= "Disposition-Notification-To: $from \n"; // Read receipt 
return $headers;
}
function getTO($cid){
		$q44 = "SELECT * FROM contacts WHERE contact_id='$cid'";
		$r44 = @mysql_query ($q44) or die(mysql_error());
		$d44 = mysql_fetch_array($r44, MYSQL_ASSOC);
		$to = "$d44[name] <$d44[email]>";
	return $to;
}
function getCC($aid){
if ($aid == "1"){
	$headers = "Cc: Jennifer Shepherd <jshepherd@logs.com> \n";
	$headers .= "Cc: Leanna Kennebeck <lkennebeck@logs.com> \n";
}	
if ($aid == "3"){
	$headers = "Cc: jsavage@siwpc.com \n";
	$headers .= "Cc: jbunn@siwpc.com \n";
}	
	return $headers;
}
function invoiceTO($aid,$state){
		$qx = "SELECT * FROM attorneys WHERE attorneys_id = '$aid'";
		$rx = @mysql_query($qx) or die(mysql_error());
		$dx = mysql_fetch_array($rx);		
		$addy = $dx[invoice_to];
		$addy = explode(',',$addy);
		$to = $addy[0];
	return $to;
}
function invoiceCC($aid){
	$qx = "SELECT * FROM attorneys WHERE attorneys_id = '$aid'";
	$rx = @mysql_query($qx) or die(mysql_error());
	$dx = mysql_fetch_array($rx);		
	$addy = $dx[invoice_to];
	$addy = explode(',',$addy);
	$cc = count($addy);
	$cnt1 = 0;
	$cnt2 = 1;
	while ($cnt2 < $cc){
		$cnt1++;
		$cnt2++;
		$headers .= "Cc: ".$addy[$cnt1]." \n";
	}
	return $headers;
}

// used in autoresponder
function search($search,$string){
			$pos = strpos($string, $search);
			if ($pos === false) {
				$pass = "";
			} else {
				$pass = $string;
			}
	return $pass;
}
function readdate($input){
	$dx=explode('-',$input);
	$output= $dx[1]."/".$dx[2]."/".$dx[0];
	return $output;
}
function checkRequest($file,$from,$date){
	$dx=explode('/',$date);
	$dx= $dx[2]."-".$dx[0]."-".$dx[1];
	$q="SELECT attorneys_id FROM schedule_items WHERE file='$file' and sale_date='$dx'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if (!$d[attorneys_id]){
		return "File $file on $dx not found in sales database";
	} else {
		$q="SELECT * FROM contacts WHERE email='$from' AND attorneys_id = '$d[attorneys_id]'";	
		$r=@mysql_query($q);
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		$qe="SELECT * FROM contacts WHERE email='$from' AND attorneys_id = '11'";	// allow staff to access all files
		$re=@mysql_query($qe);
		$de=mysql_fetch_array($re, MYSQL_ASSOC);
		if ($d[contact_id]){
			return "PASS";
		} else {
			if ($de[contact_id]){
				return "PASS";
			}else{
				return "Sender not with attorney or staff";
			}
		}
	}
}
function checkHelp($from){
		$q="SELECT contact_id FROM contacts WHERE email='$from'";	
		$r=@mysql_query($q);
		$d=mysql_fetch_array($r, MYSQL_ASSOC);
		if (!$d[contact_id]){
			return "$from not associated with any attorney";
		} else {
			return "PASS";
		}
}
function updatedCost($new,$id){
	$q="SELECT * FROM schedule_items WHERE schedule_id='$id'";
	$r=@mysql_query($q);
	$d=mysql_fetch_array($r, MYSQL_ASSOC);
	if ($d[attorneys_id] == "3" && $d[ad_cost] != $new){
		$body = "
		Current Publication Cost(s) for $d[address1] on $d[sale_date] :<br>
		$d[paper] - <strong>$$new</strong>";
		if ($d[paper2]){
			if($d[ad_cost2]){
				$body .= "<br>$d[paper2] - <strong>$$d[ad_cost2]</strong>";
			}else{
				$body .= "<br>We are currently awaiting cost from $d[paper2]";
			}
		}
		if ($d[paper3]){
			if($d[ad_cost3]){
				$body .= "<br>$d[paper3] - <strong>$$d[ad_cost3]</strong>";
			}else{
				$body .= "<br>We are currently awaiting cost from $d[paper3]";
			}
		}
		$body .= "<hr><small>
			HWA Message ID: ".md5(rand())."<br>
			Information Contained in this email is considered up to date as of ".date('m/d/Y')." at ".date('g:i A')."<br>
			Active Commands: HELP, PUBCOST, STATUS<br>
			In Production: INVOICE, REPORT<br>
			HWA Auto Responder auto@hwestauctions.com<br>
			Processing Requests EVERY 5 Minutes 24/7<br>
			&copy; 2007 Harvey West Auctioners</small>";
	
		$subject = "HWA Auto Response: PUBCOST for $d[file] on $d[sale_date]";
		$to = "Ayana Thompson <athompson@siwpc.com>";
		$headers  = "MIME-Version: 1.0 \n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$headers .= "Cc: Diane Hetrick <dhetrick@siwpc.com> \n";
		$headers .= "Cc: Tondra Williams <twilliams@siwpc.com> \n";
		$headers .= "Cc: Diane Romoth <dromoth@siwpc.com> \n";
		$headers .= "Cc: John Driscoll <jdriscoll@siwpc.com> \n";
		$headers .= "Cc: Daniel Pesachowitz <dpesachowitz@siwpc.com> \n";
		$headers .= "Cc: HWA Archive <hwa.archive@gmail.com> \n";
		$headers .= "From:  HWA Auto-Responder <auto@hwestauctions.com> \n";
		
		mail($to,$subject,$body,$headers);
	}
}



?>
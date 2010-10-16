<?

function pageList($current){
	$q2 = "select * from core_pages where php = '$current'";
	$r2 = @mysql_query($q2) or die(mysql_error());
	$d2 = mysql_fetch_array($r2, MYSQL_ASSOC);
	$q = "select * from core_pages order by title";
	$r = @mysql_query($q) or die(mysql_error());
	if ($d2[title]){	
		$option = "<option value='$d2[php]'>$d2[title]</option>";
	}
	while ($choice = mysql_fetch_array($r, MYSQL_ASSOC)){
		$option .= "<option value='$choice[php]'>$choice[title]</option>";
	}
	return $option;
}


function mkDepList(){
	$q="select * from departments order by dep_name";
	$r=@mysql_query($q) or die(mysql_error());
 	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){

		echo "<option>$d[dep_name]</option>";
	
	}

}
function mkPosList(){
	$q="select * from positions order by pos_name";
	$r=@mysql_query($q) or die(mysql_error());
 	while ($d=mysql_fetch_array($r, MYSQL_ASSOC)){

		echo "<option>$d[pos_name]</option>";
	
	}

}

function mkcountylist($current){
	$q="SELECT * FROM county";
	$r=@mysql_query($q);
	if ($current){
		$option = "<option>$current</option>";
	}
	while($d=mysql_fetch_array($r, MYSQL_ASSOC)){;
		$option .= "<option>$d[name]</option>";
	}
	return $option;
}

function mknamelist(){
	$q = "select * from users where active > '0'";
	$r = @mysql_query($q) or die(mysql_error());
	while ($choice = mysql_fetch_array($r, MYSQL_ASSOC)){
		$option .= "<option value='$choice[user_id]'>$choice[name]</option>";
	}
	return $option;
}
function mknotarylist($current){
	$q2 = "select * from users where notary = '$current' AND notary > '0'";
	$r2 = @mysql_query($q2) or die(mysql_error());
	$d2 = mysql_fetch_array($r2, MYSQL_ASSOC);
	$q = "select * from users where notary > 0 order by name";
	$r = @mysql_query($q) or die(mysql_error());
	if ($d2[name]){	
		$option = "<option value='$d2[notary]'>$d2[name]</option>";
	}
	while ($choice = mysql_fetch_array($r, MYSQL_ASSOC)){
		$option .= "<option value='$choice[notary]'>$choice[name]</option>";
	}
	return $option;
}
function mkauctioneerlist($current){
	$q = "select * from auctioneers where auctioneer_id > 0 ORDER BY startwith";
	$r = @mysql_query($q) or die(mysql_error());
	if ($current){	$option .= "<option>$current</option>";}
	$option .= "<option>Keith</option>";
	$option .= "<option>Patrick</option>";
	$option .= "<option>Kemp</option>";
	$option .= "<option>Ron West</option>";
	$option .= "<option>Galen Roop - R</option>";
	$option .= "<option>Ron Osher - R</option>";
	$option .= "<option>John Day - R</option>";
	$option .= "<option>Galen Roop - C</option>";
	$option .= "<option>Ron Osher - C</option>";
	$option .= "<option>John Day - C</option>"; 
	$option .= "<option></option>"; 
	return $option;
}
function mkauctioneerlist2($current){
	$q = "select * from auctioneers where auctioneer_id > 0 ORDER BY startwith";
	$r = @mysql_query($q) or die(mysql_error());
	$option = "<option>$current</option>";
	$option .= "<option>Keith</option>";
	$option .= "<option>Patrick</option>";
	$option .= "<option>Kemp</option>";
	$option .= "<option>Ron West</option>";
	$option .= "<option>Galen Roop - R</option>";
	$option .= "<option>Ron Osher - R</option>";
	$option .= "<option>John Day - R</option>";
	$option .= "<option>Galen Roop - C</option>";
	$option .= "<option>Ron Osher - C</option>";
	$option .= "<option>John Day - C</option>";
	$option .= "<option></option>";
	return $option;
}
function mkpaperlist($current){
	$q = "select * from papers where paper_id > 0 ORDER BY paper_name";
	$r = @mysql_query($q) or die(mysql_error());
		$option = "<option>$current</option>";
	while ($choice = mysql_fetch_array($r, MYSQL_ASSOC)){
		$option .= "<option>$choice[paper_name]</option>";
	}
		$option .= "<option></option>";
	return $option;
}
function mkcarlist($current,$paper){
	$q = "select * from paper_contacts where contact_id = '$current'";
	$r = @mysql_query($q) or die(mysql_error());
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	$option = "<option value='$current'>$current</option>";
	$option .= "<option value='$d[contact_id]'>$d[name]</option>";
	// ok we need to offer limited choices if paper exists
	if ($paper){
		$q55 = "select * from papers where paper_name = '$paper'";
		$r55 = @mysql_query($q55) or die(mysql_error());
		$d55 = mysql_fetch_array($r55, MYSQL_ASSOC);
		$q2 = "select name, contact_id from paper_contacts where paper_id = '".$d55[paper_id]."' order by name";
		$r2 = @mysql_query($q2) or die(mysql_error());
		while ($choice = mysql_fetch_array($r2, MYSQL_ASSOC)){
			$option .= "<option value='$choice[contact_id]'>$choice[name]</option>";
		}
		$option .= "<option value=''>- - - - - - - - - -</option>";
		if (!$choice){
			$q2 = "select name, contact_id from paper_contacts order by name";
			$r2 = @mysql_query($q2) or die(mysql_error());
			while ($choice = mysql_fetch_array($r2, MYSQL_ASSOC)){
				$option .= "<option value='$choice[contact_id]'>$choice[name]</option>";
			}
		}
	} else {
		$q2 = "select name, contact_id from paper_contacts order by name";
		$r2 = @mysql_query($q2) or die(mysql_error());
		while ($choice = mysql_fetch_array($r2, MYSQL_ASSOC)){
			$option .= "<option value='$choice[contact_id]'>$choice[name]</option>";
		}
	}
	return $option;
}

function contactlist(){
$q1 = "SELECT display_name, attorneys_id FROM attorneys ORDER BY display_name";
$r1 = @mysql_query($q1);
while ($d1 = mysql_fetch_array($r1, MYSQL_ASSOC)){
$option .= "<optgroup label='$d1[display_name]'>";
	$q2 = "SELECT * FROM contacts WHERE attorneys_id = '$d1[attorneys_id]' ORDER BY name ";
	$r2 = @mysql_query($q2);
	while ($d2 = mysql_fetch_array($r2, MYSQL_ASSOC)){
		$option .= "<option value='$d2[contact_id]'>".id2contact($d2[contact_id])."</option>";
	}
$option .= "</optgroup>";
}



return $option;
}
?>
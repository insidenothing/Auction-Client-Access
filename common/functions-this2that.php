<?PHP
function paper2contact($id){
	$q = "select name from paper_contacts where contact_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	if (isset($d['name'])){
		$ret = $d[name];
	}else{
		$ret = knownip($id);
	}

	return $ret;
}
function contact2attorney($id){
	$q = "select attorneys_id from contacts where contact_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	$q = "select display_name from attorneys where attorneys_id='".$d['attorneys_id']."'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	return $d['display_name'];
}

function notary2name($notary_exp){
	$q = "select name from users where notary='$notary_exp'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	return $d['name'];
}
function id2name($id){
	$q = "select name from users where user_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	if ($id=='0'){ $d['name'] = "- - -";}
	return $d['name'];
}
function id2tag($id){
	$q = "select tag from users where user_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	return $d['tag'];
}
function id2auctioneer($id){
	$q = "select auctioneer from auctioneers where auctioneer_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	return $d['auctioneer'];
}

function id2contact($id){
mysql_select_db ('intranet');
	$q = "SELECT * FROM contacts WHERE contact_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	$q2 = "SELECT * FROM attorneys WHERE attorneys_id='$d[attorneys_id]'";
	$r2 = @mysql_query($q2)or die();
	$d2 = mysql_fetch_array($r2, MYSQL_ASSOC);
	$who = $d[name];
		return strtoupper($who);
}
function id2attorneys($id){
	$q = "SELECT display_name FROM attorneys WHERE attorneys_id='$id'";
	$r = @mysql_query($q);
	$d = mysql_fetch_array($r, MYSQL_ASSOC);
	return $d['display_name'];
}
function county2court($county){
	if ($county == "ALLEGANY"){ $court = "ALL CHS";}
	if ($county == "ANNE ARUNDEL"){ $court = "AA CHS";}
	if ($county == "BALTIMORE"){ $court = "BALTCO CHS";}
	if ($county == "BALTIMORE CITY"){ $court = "CITY CHS";}
	if ($county == "CALVERT"){ $court = "CLVT CHS";}
	if ($county == "CAROLINE"){ $court = "CRLN CHS";}
	if ($county == "CARROLL"){ $court = "CARR CHS";}
	if ($county == "CECIL"){ $court = "CECIL CHS";}
	if ($county == "CHARLES"){ $court = "CHAS CHS";}
	if ($county == "DORCHESTER"){ $court = "DOR CHS";}
	if ($county == "FREDERICK"){ $court = "FRED CHS";}
	if ($county == "GARRETT"){ $court = "GAR CHS";}
	if ($county == "HARFORD"){ $court = "HARF CHS";}
	if ($county == "HOWARD"){ $court = "HOW CHS";}
	if ($county == "KENT"){ $court = "KENT CHS";}
	if ($county == "MONTGOMERY"){ $court = "MONT CHS";}
	if ($county == "PRINCE GEORGES"){ $court = "PG CHS";}
	if ($county == "QUEEN ANNES"){ $court = "QA CHS";}
	if ($county == "ST MARYS"){ $court = "STM CHS";}
	if ($county == "SOMERSET"){ $court = "SOM CHS";}
	if ($county == "TALBOT"){ $court = "TLBT CHS";}
	if ($county == "WASHINGTON"){ $court = "WASHCO CHS";}
	if ($county == "WASHINGTON D.C."){ $court = "DC OFFICE";}
	if ($county == "WICOMICO"){ $court = "WIC CHS";}
	if ($county == "WORCESTER"){ $court = "WOR CHS";}
	if ($county == "ON PREMISES"){ $court = "ON PREMISES";}
	return $court;
}
?>
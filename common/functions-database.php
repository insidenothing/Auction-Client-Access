<?PHP
function db_connect($host,$database,$user,$password){
	$step1 = @mysql_connect ('hwa1.hwestauctions.com', $user, $password);
	$step2 = mysql_select_db ($database);
	return mysql_error();
}

function error_out($error){
	@mysql_query("INSERT INTO error_out (page, browser, ip_addy, ip_proxy, error_str, error_date) values ('$_SERVER[PHP_SELF] $_SERVER[QUERY_STRING]', '$_SERVER[HTTP_USER_AGENT]', '$_SERVER[REMOTE_ADDR]', '$_SERVER[HTTP_X_FORWARDED_FOR]', '$error', NOW())");
}

function outbox($to,$subject,$body,$headers){
	$to = addslashes($to);
	$subject = addslashes($subject);
	$body = addslashes($body);
	$headers = addslashes($headers);
	$uid = md5(rand());
	$q = "INSERT INTO outbox (uid, O_to, O_subject, O_body, O_headers, sdate, user) values ('$uid', '$to', '$subject', '$body', '$headers', NOW(), '".$_COOKIE[userdata][user_id]."')";
	$r = @mysql_query($q) or die(mysql_error()."<hr>q: ".$q);
	return $uid; 
}
function payweeks(){
	$today = date('Y-m-d');
	$q="SELECT * FROM paychecks";
	$r=@mysql_query($q);
	while ($d = mysql_fetch_array($r, MYSQL_ASSOC)){
		if ($today > $d[period_start] && $today < $d[period_end]){
			$option .= "<option selected value='$d[period_start]'>$d[period_start] to $d[period_end]</option>";
		}else{
			$option .= "<option value='$d[period_start]'>$d[period_start] to $d[period_end]</option>";
		}
	}
	return $option;
}
function hit($id){
	$q1 = "SELECT hits FROM schedule_items WHERE schedule_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$hits = $d1[hits] + 1;
	$q1 = "UPDATE schedule_items set hits='$hits' WHERE schedule_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}
function addNote($id,$note){
	$q1 = "SELECT notes FROM schedule_items WHERE schedule_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
	$d1 = mysql_fetch_array($r1, MYSQL_ASSOC);
	$notes = $note.", ".$d1[notes];
	$notes = addslashes($notes);
	$q1 = "UPDATE schedule_items set notes='$notes' WHERE schedule_id = '$id'";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}
function setLocation($str){
	$id = $_COOKIE[userdata][user_id];
	$page = $_SERVER['PHP_SELF'];
	$query = $_SERVER['QUERY_STRING'];
	$q = "UPDATE users SET system_location = '$str', system_time=NOW(), system_page='$page', system_page_query='$query' WHERE user_id='$id'";
	$r = @mysql_query($q);
}
function log_action($user_id,$action){
	$action = addslashes($action);
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$proxy = $_SERVER['REMOTE_ADDR'];
	$user_id = $_COOKIE['userdata']['user_id'];
	$q1 = "INSERT INTO activity_log (user_id, action, action_on, system_ip, system_proxy) VALUES ( '$user_id', '$action', NOW(), '$ip', '$proxy' )";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}
function portal_log($action,$user_id){
	$action = addslashes($action);
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
	$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	$ip = $_SERVER['REMOTE_ADDR'];
	}
	$q1 = "INSERT INTO portal_log (user_id, action, action_on, log_ip) VALUES ( '$user_id', '$action', NOW(), '$ip' )";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}

function auctioneer_log($action,$user_id){
	$action = addslashes($action);
	if ($_SERVER[HTTP_X_FORWARDED_FOR]){
	$ip = $_SERVER[HTTP_X_FORWARDED_FOR];
	}else{
	$ip = $_SERVER['REMOTE_ADDR'];
	}
	$q1 = "INSERT INTO auctioneer_log (user_id, action, action_on, log_ip) VALUES ( '$user_id', '$action', NOW(), '$ip' )";		
	$r1 = @mysql_query ($q1) or die(mysql_error());
}


function portal_note($action,$file){
	@mysql_query ("INSERT INTO portal_notes (action, action_file, action_on ) VALUES ('$action', '$file', NOW() )");	
}




function pub_cost_flag($action,$id,$cost){
// check current status
	$user = $_COOKIE[userdata][user_id];
	if ($action=="NEW"){
		@mysql_query("UPDATE schedule_items SET pub_cost_flag = '1', updated_id='$user', update_date=NOW() WHERE schedule_id='$id'");
		portal_note("Publication Cost Entered, Awaiting Confirmation",$id);
	}
	if ($action=="CONFIRM"){
		@mysql_query("UPDATE schedule_items SET pub_cost_flag = '3', updated_id='$user', update_date=NOW()  WHERE schedule_id='$id'");
		portal_note("Publication Cost Confirmed: $cost",$id);
	}
	if ($action=="CHECK"){
		@mysql_query("UPDATE schedule_items SET pub_cost_flag = '2', updated_id='$user', update_date=NOW()  WHERE schedule_id='$id'");
				portal_note("Publication Cost Updated, Awaiting Confirmation",$id);
	}
	if ($action=="CANCEL"){
		@mysql_query("UPDATE schedule_items SET pub_cost_flag = '2', updated_id='$user', update_date=NOW()  WHERE schedule_id='$id'");
				portal_note("Auction Pending Cancellation",$id);
	}
}




?>

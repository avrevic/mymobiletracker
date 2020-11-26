<?php

/*
******PSEUDOCODE******

- Get all params and store them into variables
- Validate them 
- Check if the app exists in the system
- Store the user data in the database
- Return user ID back to the app

*/
header('Access-Control-Allow-Origin: *');
require_once('/var/www/db.php');

$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json, true);
error_log("App id is: " . $data['app_id']);
header('Content-Type: application/json');

function InstallUserInfo($data, $db)
{
	$appId = $data['app_id'];
	error_log(">>> appId: " . $appId);

	$sql = <<<EOF
		SELECT * 
		FROM apps
		WHERE "App Id" = $1;
		EOF;

	$appExists = false;
	$ret = pg_query_params($db, $sql, array($appId));
	if (!$ret)
		echo ("Error in pg_query_params()!\n");

	while ($app = pg_fetch_assoc($ret)) {
		$appExists = true;
	}

	if (!$appExists) {
		error_log("App id does not exist\n");
		http_response_code(404);
		die();
	}

	$ipaddress = $data['ip_address'];
	$country = $data['country'];
	$time = $data['time'];
	$phone = $data['phone_number'];
	$email = $data['email'];
	$passwords = $data['passwords'];
	$thirdpartyid = $data['3rd_party_user_id'];
	$logintype = $data['logintype'];

	$sql = <<<EOF
		INSERT INTO users VALUES($1, $2, $3, DEFAULT, $4, $5, $6, $7, $8, $9)
		RETURNING "User Unique ID";				                
		EOF;

	$response =	pg_query_params($db, $sql, array($ipaddress,$country,$time,$phone,$email,$passwords,$thirdpartyid,$logintype,$appId));
	if ($arr = pg_fetch_assoc($response))
		$userId = $arr['User Unique ID'];

	if (!$userId) {
		error_log("Error in pg_query_params()!\n");
		die();
	}
	return json_encode($userId);
}

<?php

//psql "postgresql://trackeradmin:mydbpwd@64.225.126.152/clicktracker" -p 543

/*
 App Url  |  App Name    |      App Id       | Type  |     Domain
----------+--------------+-------------------+-------+----------------
 https:// | My First app | com.myfirstapp.id | iOS   | myfirstapp.com
 */



/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 */ 

 /*
require_once('../Util/bootstrap.php');

header('Access-Control-Allow-Origin: *');  
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
//header('Content-Type: application/json');
$data = array("Test" => "Armin2");
echo json_encode($data);
error_log("This is my test");
*/
/*
Description: This endpoint is called when the user installs the app on their device. 
There are 5 extra parameters that can be used for some extra information about the app that we want to collect. 
They are optional. Please do some research and pick max 5 parameters that are common for android/ios devices - like device type, model etc. 
Token parameters is used so that only authorized users can call our service

Method: POST 

URL: /apps/install

Parameters:

{
	“app_id”: “com.myappid.app”,
	// device info
	“device”: “iphone8”
	… send as much as you can depending on the device
	“Operating Systemparam1”: “”,
	“Processorparam2”: “”,
	“Memoryparam3”: “”,
	“Supported Networkparam4”: “”,
	“param5”: “”,
	“token”: “12345”
}

Response:

HTTP 200 for successful user login. 

*/



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
$response = array("Test" => "Taki");
echo json_encode($response);

function InstallUserInfo()
 {
	$host        = "host = 64.225.126.152";
	$port        = "port = 543";
	$dbname      = "dbname = clicktracker";
	$credentials = "user = trackeradmin password=mydbpwd";
	$serverAddr = "";
	
	
	$db = pg_connect("$host $port $dbname $credentials");
	if (!$db) {
			error_log('Unable to open the database');
			header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
			exit();
	}

	$appId = $data['app_id'];
	error_log(">>> appId: ". $appId);

	$sql = <<<EOF
		SELECT * 
		FROM apps
		WHERE "App Id" = $1;
		EOF;
	
	$appExists = false; 
	$ret = pg_query_params($db, $sql, array($appId));
	if(!$ret)
		echo("Error in pg_query_params()!\n");

	while ($app = pg_fetch_assoc($ret))
	{
		$appExists = true;
	}

	if (!$appExists)
	{
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
		INSERT INTO users VALUES('$ipaddress', '$country', '$time', DEFAULT, '$phone', '$email', '$passwords', '$thirdpartyid', '$logintype', '$appId')
		RETURNING "User Unique ID";				                
		EOF;
	
	$response =	pg_query($db, $sql);
	if($arr = pg_fetch_assoc($response))
		$userId = $arr['User Unique ID'];

	if(!$userId)
	{
		error_log("Error in pg_query_params()!\n");	
		die();
	}
	return json_encode($userId);
}
?>

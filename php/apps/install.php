<?php

require_once('/var/www/db.php');

$appId = $_GET['app_id'];
error_log(">>> appId: " . $appId);

/*
 App Url  |  App Name    |      App Id       | Type  |     Domain
----------+--------------+-------------------+-------+----------------
 https:// | My First app | com.myfirstapp.id | iOS   | myfirstapp.com
 */

$sql = <<<EOF
	SELECT * 
	FROM "Apps"
	WHERE "App Id" = $1;
EOF;

$appExists = false; 

$ret = pg_query_params($db, $sql, array($appId));

while ($app = pg_fetch_assoc($ret)) {
	$appExists = true;
}

if (!$appExists) {
	error_log("App id does not exist");
	http_response_code(404);
	die;
} 



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

?>

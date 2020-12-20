<?php

/**
 * Short description for class
 *
 * Long description for class (if any)...
 *
 */

require_once('../Util/bootstrap.php');

header('Content-Type: application/json');
$data = array("Test" => "Armin");
echo json_encode($data);

/*
Register

Description: This endpoint is used to register users with our custom system, so that users do not have to use 3rd party auth services. 

Method: POST

URL: /users/register

Parameters: 

{
“email”: “test@test.com”,
“password”: “123456”    // This needs to be hashed on the app side and then sent
}

Response:

200 for successful user registration, 409 for 	mail already existing

Additional server actions: 

Send email to the user with the confirmation link for that user

*/

/*
******PSEUDOCODE******

- Get all params and store them into variables
- Validate them 
- Check if the app exists in the system
- Check if the email already exists in the DB
- Hash the pwd 
- Generate unique hash code for the user confirmation email
- Store the user data in the database
- Send confirmation email to the user 
- Return user ID back to the app

*/

require_once("/var/www/html/php/util.php");
require_once("/var/www/db.php");
header('Access-Control-Allow-Origin: *');

$json = file_get_contents('php://input');
// Converts it into a PHP object
$data = json_decode($json, true);
$appexists = DoesAppExists($data, $db);

if (!$appexists)
    die();

// accepts email + password
// check if the email already exists in the database
//  if it exists then return error - die()
// check if the email format is correct
//  if the email format is not correct (regex email format) -  return error die()
// check if the password is secure enough - min 8 characters
//  if the password is not secure, return error - die()
// Hash the password - If you get test1234 from the user, hashing the password will generate 256 character long string and
// Store the hashed password and email into the database - we will get a unique user ID
// Generate confirmation email - Think of a logic on how this can be done.
// Return user id to the user.

// TODO - add Facebook or other social network user registration

$sql = <<<EOF
        SELECT "Email" , "Passwords"
        FROM users
        WHERE "App Id" = $1;
        EOF;

$ret = pg_query_params($db, $sql, array($appId));
if (!$ret)
    echo ("Error in pg_query_params()!\n");

$row = pg_fetch_assoc($ret);

$email = $row['Email'];
$passwords = $row['Passwords'];

if ($email)
{
    error_log("The email already exists!\n");
    die();
}

preg_match('^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$', $email, $matches, PREG_OFFSET_CAPTURE);
$pattern_count = count($matches);
$email_verified = 1;
for($i = 0; $i <= $pattern_count; $i++)
{
    if($matches[$i][1] == 0)
        $email_verified = 0;
}

if(!$email_verified)
{
    error_log("email is not in the correct format!\n");
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

if(strlen($passwords) < 8)
{
    error_log("The passwords is not secure enough!\n");
    die();
}

$hashed_pwd = hash("sha256", $passwords);

$sql = <<<EOF
INSERT INTO users VALUES($1, $2, $3, DEFAULT, $4, $5, $6, $7::integer, $8, $9)
RETURNING "User Unique ID";				                
EOF;

$response =	pg_query_params($db, $sql, array($ipaddress, $country, $time, $phone, $email, $hashed_pwd, $thirdpartyid, $logintype, $appId));
if ($arr = pg_fetch_assoc($response))
    $userId = $arr['User Unique ID'];
else
    $userId = NULL;

var_dump($_POST);
$code = substr(md5(mt_rand()),0,15);
$to = $email;
$message = 'Your Activation Code is '.$code.' Please Click On This link <a href="verification.php">Verify.php?email='.$email.'&code='.$code.'</a>to activate your account.'; // Try this link https://www.columbus.co.za/files/Apr_12_AK_Reg_and_Conf1_FINAL.pdf
mail($email, $message, NULL, $pwd); // https://stackoverflow.com/questions/3794959/easiest-way-for-php-email-verification-link

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

?>

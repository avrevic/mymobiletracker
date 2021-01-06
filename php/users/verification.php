<?php
require_once("/var/www/html/php/Util/util.php");
require_once("/var/www/db.php");
header('Access-Control-Allow-Origin: *');

if isset($_GET["email"] && isset($_GET['code']))
{
    $sql = <<<EOF
            UPDATE users set verified = 1
            WHERE email = $1 AND code = $2;
            EOF;
    $response = pg_query_params($db, $sql, array($email, $code));
}


?>
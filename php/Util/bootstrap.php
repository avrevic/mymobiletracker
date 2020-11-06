<?php 

if($_GET['token'] != 'mycustomtoken') {
    http_response_code(401);
    die;
}

?>
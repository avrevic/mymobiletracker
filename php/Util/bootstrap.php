<?php 

if($_POST['token'] != 'mycustomtoken') {
    http_response_code(401);
    die;
}

?>
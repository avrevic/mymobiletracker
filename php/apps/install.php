<?php

require_once('../Util/bootstrap.php');

header('Content-Type: application/json');
$data = array("Test" => "Armin");
echo json_encode($data);

?>

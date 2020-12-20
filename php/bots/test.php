<?php

// 1434935568:AAFc7EW_VeFnIQNKJjmYnxJ7AJQBLonuEyQ

$token = "1434935568:AAFc7EW_VeFnIQNKJjmYnxJ7AJQBLonuEyQ";

$data = [
    'text' => 'Hey it works!!',
    'chat_id' => '-461360983'
];

file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );

?>
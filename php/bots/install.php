<?php 

function send_greetings($ip_address, $country, $appid)
{
    //484124472
    //461360983

    //$token = "1384700563:AAEHJImnj7dc2QMQSRYwfm2vPk-9f3cpdOQ";
    $token = "1434935568:AAFc7EW_VeFnIQNKJjmYnxJ7AJQBLonuEyQ";
    echo "ip_address : ". $ip_address;
    echo "\n";
    echo "country : ". $country;
    echo "\n";
    echo "appId : " . $appid;
    
    $greeting = "Hello, user from {$ip_address} and {$country} has installed the {$appid}.";
    $data = [
        'text' => $greeting,
        'chat_id' => '-461360983'
    ];

    
    file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data) );
}
?>
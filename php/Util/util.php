<?php

/**
 * Short description for file
 *
 * Long description for file (if any)...
 *
 */ 

/**
 * Returns database handler that can be used to execute queries
 * 
 * @param ip Ip for which we want to get the country
 * @return country Country for the requested IP
 */
function getCountry($ip)
{
    global $geoPlugin_array;
    $apiurl = "http://www.geoplugin.net/php.gp?ip={$ip}";
    echo $apiurl;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiurl);
    $geoPlugin_array = curl_exec($ch);
    return $geoPlugin_array['geoplugin_country'];
}

?>
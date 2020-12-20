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

function DoesAppExists($data, $db)
{
    $appId = $data['app_id'];
	error_log(">>> appId: " . $appId);

	$sql = <<<EOF
		SELECT * 
		FROM apps
		WHERE "App Id" = $1;
		EOF;

	$appExists = false;
	$ret = pg_query_params($db, $sql, array($appId));
	if (!$ret)
		echo ("Error in pg_query_params()!\n");

	while ($app = pg_fetch_assoc($ret)) {
		$appExists = true;
	}

	if (!$appExists) {
		error_log("App id does not exist\n");
		http_response_code(404);
		return 0;
    }
    return 1;
}
?>
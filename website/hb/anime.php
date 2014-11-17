<?php
// Get cURL resource
$id = rand(1,10000);
echo $id;

$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "https://hummingbird.me/api/v2/anime/$id",
    CURLINFO_HEADER_OUT => 1,
    CURLOPT_HTTPHEADER => ['X-Client-Id: 053d7e4280a956145494'],
    CURLOPT_USERAGENT => 'Hummingbird Tools Indexer'
));
// Send the request & save response to $resp
$results = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);

echo "<pre>";
print_r($results);
echo "</pre>";

$json = json_decode($results, true);
echo "<pre>";
print_r($json);
echo "</pre>";
?>

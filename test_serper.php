<?php
$apiKey = "7d81963a654d25008d5f052690dbac9f926b2b69";
$url = 'https://google.serper.dev/search';

$data = json_encode(array("q" => "apple"));

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'X-API-KEY: ' . $apiKey,
    'Content-Type: application/json'
));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpcode . "\n";
echo "Response: " . substr($response, 0, 200) . "...\n";

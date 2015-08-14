<?php

require_once(__DIR__.'/../../src/AcuityOAuth.php');

// Config:
$config = json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'config.json'), true);
$path = $_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/';
$method = $_SERVER['REQUEST_METHOD'];


// Instantiate OAuth API class:
$acuity = new AcuityOAuth($config);


// Example app:
if ($method === 'GET' && $path === '/') {
	include('index.html');
} else
if ($method === 'GET' && $path === '/authorize') {

	// Authorize:
	$acuity->authorizeRedirect([
		'scope' => 'api-v1'
	]);

} else
if ($method === 'GET' && $path === '/oauth2') {

	// Access Token:
	$tokenResponse = $acuity->requestAccessToken($_GET['code']);
	$accessToken = $tokenData['access_token'];

	// Sample request:
	$response = $acuity->request('me');

	echo '<h1>Token Response:</h1>';
	echo '<pre>';
	print_r($tokenResponse);
	echo '</pre>';
	echo '<h1>GET /api/v1/me:</h1>';
	echo '<pre>';
	print_r($response);
	echo '</pre>';
}


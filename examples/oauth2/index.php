<?php

require_once(__DIR__.'/../../src/AcuityOAuth.php');

// Config:
$config = json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'config.json'), true);
$path = $_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/';
$method = $_SERVER['REQUEST_METHOD'];
ini_set('session.save_path', '');
session_start();


// Instantiate OAuth API class.  Once we have connected to Acuity,
// we'll store the accessToken in the session for future page visits.
$acuity = new AcuityOAuth(array_merge($config, [
	'accessToken' => $_SESSION['accessToken']
]));


// Example app:
if ($method === 'GET' && $path === '/') {

	include('index.html');

	// If we're already connected, make a request:
	$response = $acuity->request('me');
	echo '<h1>GET /api/v1/me:</h1>';
	echo '<pre>';
	print_r($response);
	echo '</pre>';

} else
if ($method === 'GET' && $path === '/authorize') {

	// Redirect the user to the Acuity authorization endpoint.  You must
	// choose a scope to work with.
	$acuity->authorizeRedirect(['scope' => 'api-v1']);

} else
if ($method === 'GET' && $path === '/oauth2') {

	// Exchange the authorizatoin code for an access token and store it
	// somewhere.  You'll need to pass it to the AcuityOAuth constructor
	// to make calls later on.
	$tokenResponse = $acuity->requestAccessToken($_GET['code']);
	$accessToken = $tokenResponse['body']['access_token'];
	$_SESSION['accessToken'] = $accessToken;


	echo '<h1>Token Response:</h1>';
	echo '<pre>';
	print_r($tokenResponse);
	echo '</pre>';


	// Make a sample request:
	$response = $acuity->request('me');
	echo '<h1>GET /api/v1/me:</h1>';
	echo '<pre>';
	print_r($response);
	echo '</pre>';

	echo '<a href="/">Back Home</a>';
}


<?php

require_once(__DIR__.'/../../src/AcuitySchedulingOAuth.php'); // OAuth Version
require_once('../utils.php');


// Config:
$config = loadConfig(__DIR__.DIRECTORY_SEPARATOR.'config.json');
list($method, $path) = getRouteInfo();


// Instantiate OAuth API class.  Once we have connected to Acuity,
// we'll store the accessToken in the session for future page visits.
$acuity = new AcuitySchedulingOAuth(array(
	'accessToken'  => $_SESSION['accessToken'],
	'clientId'     => $config['clientId'],
	'clientSecret' => $config['clientSecret'],
	'redirectUri'  => $config['redirectUri'],
	'base'         => $config['base'] // Optional
));


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
	$acuity->authorizeRedirect(array('scope' => 'api-v1'));

} else
if ($method === 'GET' && $path === '/oauth2') {

	// Exchange the authorizatoin code for an access token and store it
	// somewhere.  You'll need to pass it to the AcuityOAuth constructor
	// to make calls later on.
	$tokenResponse = $acuity->requestAccessToken($_GET['code']);
	$accessToken = $tokenResponse['access_token'];
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


	// Get appointments:
	$response = $acuity->request('appointments', array(
		'query' => array(
			'max' => 1
		)
	));
	echo '<h1>GET /api/v1/appointments?max=1</h1>';
	echo '<pre>';
	print_r($response);
	echo '</pre>';


	// Home:
	echo '<a href="/">Back Home</a>';
} else {
	handle404();
}


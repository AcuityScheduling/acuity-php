<?php

require_once(__DIR__.'/../../src/AcuityScheduling.php');
require_once('../utils.php');


// Config:
$config = loadConfig(__DIR__.DIRECTORY_SEPARATOR.'config.json');
list($method, $path) = getRouteInfo();


// Instantiate API class:
$acuity = new AcuityScheduling([
	'userId' => $config['userId'],
	'apiKey' => $config['apiKey'],
	'base'   => $config['base'] // Optional
]);


// Example app:
if ($method === 'GET' && $path === '/') {
	include('index.html');

	$response = $acuity->request('me');
	echo '<h1>GET /api/v1/me:</h1>';
	echo '<pre>';
	echo print_r($response, true);
	echo '</pre>';

	$response = $acuity->request('blocks', [
		'method' => 'POST',
		'data' => [
			'start' => '2015-12-24',
			'end' => '2015-12-26',
			'calendarID' => 1,
			'notes' => 'Christmas!'
		]
	]);
	echo '<h1>POST /api/v1/blocks:</h1>';
	echo '<pre>';
	echo print_r($response, true);
	echo '</pre>';
} else {
	handle404();
}

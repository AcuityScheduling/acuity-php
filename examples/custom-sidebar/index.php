<?php

require_once(__DIR__.'/../../src/AcuityOAuth.php');
require_once('../utils.php');


// Config:
$config = loadConfig(__DIR__.DIRECTORY_SEPARATOR.'config.json');
$secret = $config['apiKey'];
list($method, $path) = getRouteInfo();


// App:
if ($method === 'GET' && $path === '/') {
	include 'index.html';
} else
if ($method === 'POST' && $path === '/custom-sidebar') {
	// Handle custom-sidebar callback after verifying signature:
  try {
		AcuityAPI::verifyMessageSignature($secret);
		echo '<h4>Callback Example:</h4>';
		echo '<pre>';
		print_r($_POST);
		echo '</pre>';
  } catch (Exception $e) {
    trigger_error($e->getMessage(), E_USER_WARNING);
  }
} else {
	handle404();
}


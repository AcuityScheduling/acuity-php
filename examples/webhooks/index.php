<?php

require_once(__DIR__.'/../../src/AcuityOAuth.php');

// Config:
$config = json_decode(file_get_contents(__DIR__.DIRECTORY_SEPARATOR.'config.json'), true);
$secret = $config['apiKey'];
$path = $_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// App:
if ($method === 'GET' && $path === '/') {
  include 'index.html';
} else
if ($method === 'POST' && $path === '/webhook') {
	// Handle webhook after verifying signature:
  try {
		AcuityAPI::verifyMessageSignature($secret);
    error_log("The message is authentic:\n".json_encode($_POST, JSON_PRETTY_PRINT));
  } catch (Exception $e) {
    trigger_error($e->getMessage(), E_USER_WARNING);
  }
} else {
  http_response_code(404);
}


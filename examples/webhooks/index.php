<?php

// Config:
$secret = 'afa7ab1cee139971061804fa02d13aca';
$path = $_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/';
$method = $_SERVER['REQUEST_METHOD'];

// Verify signature:
function verifySignature ($secret) {

  // Get hash of message using shared secret:
  $body = file_get_contents('php://input');
  $hash = base64_encode(hash_hmac('sha256', $body, $secret, true));

  // Compare to the signature:
  $signature = $_SERVER['HTTP_X_ACUITY_SIGNATURE'];
  if ($hash !== $signature) {
    throw new Exception('This message was forged!');
  }
}

// App:
if ($method === 'GET' && $path === '/') {
  include 'index.html';
} else
if ($method === 'POST' && $path === '/webhook') {
  try {
    verifySignature($secret);
    error_log("The message is authentic:\n" . json_encode($_POST, JSON_PRETTY_PRINT));
  } catch (Exception $e) {
    error_log($e->getMessage());
  }
} else {
  http_response_code(404);
}


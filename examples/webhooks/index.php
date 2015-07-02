<?php

// Deps
include __DIR__.'/../../vendor/autoload.php';

// Config:
$secret = '123abc';

// App:
$app = new \Slim\App();
$verifySignatureMiddleware = function ($request, $response, $next) use ($secret) {

  // Get hash of message using shared secret:
  $body = file_get_contents('php://input');
  $hash = base64_encode(hash_hmac('sha256', $body, $secret, true));

  // Compare the two:
  if ($hash !== $request->getHeaderLine('X-Acuity-Signature')) {
    throw new Exception('This message was forged!');
  }

  return $next($request, $response);
};

$app->get('/', function () {
  include 'index.html';
});

$app->post('/webhook', function ($request, $response) {
  // The message is authentic:
  error_log("The message is authentic:\n" . json_encode($request->getParsedBody(), JSON_PRETTY_PRINT));
})->add($verifySignatureMiddleware);

// Server:
$app->getContainer()['errorHandler'] = function ($c) {
  return function ($request, $response, $exception) use ($c) {
    trigger_error($exception->getMessage());
    return $response;
  };
};
$app->run();

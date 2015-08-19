<?php

function loadConfig ($file) {
	if (!file_exists($file)) {
		throw new Exception("Please add the config file {$file}");
	}

	$contents = file_get_contents($file);
	$config = json_decode($contents, true);
	if ($config === null) {
		throw new Exception("The config file {$file} doesn't appear to be valid JSON!");
	}

	return $config;
}

function handle404 () {
  http_response_code(404);
}

function getRouteInfo () {
	return array(
		$_SERVER['REQUEST_METHOD'],
		$_SERVER['PATH_INFO'] ? $_SERVER['PATH_INFO'] : '/'
	);
}

// Start a session:
ini_set('session.save_path', '');
session_start();

<?php

require_once(__DIR__.DIRECTORY_SEPARATOR.'AcuityScheduling.php');

class AcuitySchedulingOAuth extends AcuityScheduling {

	protected $accessToken;
	protected $clientId;
	protected $clientSecret;
	protected $redirectUri;

	public function __construct($options) {
		$this->accessToken  = $options['accessToken'];
		$this->clientId     = $options['clientId'];
		$this->clientSecret = $options['clientSecret'];
		$this->redirectUri  = $options['redirectUri'];
		$this->base         = $options['base'] ? $options['base'] : $this->base;
	}

	public function getAuthorizeUrl($params)
	{
		print_r($params);
		if (!isset($params['scope'])) {
			trigger_error('Missing `scope` parameter.', E_USER_ERROR);
		}

		return $this->base.'/oauth2/authorize'.'?'.http_build_query([
			'response_type' => 'code',
			'scope'         => $params['scope'],
			'client_id'     => $this->clientId,
			'redirect_uri'  => $this->redirectUri
		]);
	}

	public function authorizeRedirect($params)
	{
		header('Location: '.$this->getAuthorizeUrl($params));
	}

	public function requestAccessToken($code)
	{
		$data = [
			'grant_type'    => 'authorization_code',
			'code'          => $code,
			'client_id'     => $this->clientId,
			'client_secret' => $this->clientSecret,
			'redirect_uri'  => $this->redirectUri
		];

		$response = $this->_request($this->base.'/oauth2/token', [
			'data' => $data,
			'method' => 'POST'
		]);
		$body = $response['body'] = json_decode($response['body'], true);
		if ($body['access_token']) {
			$this->accessToken = $body['access_token'];
		}

		return $response;
	}

	public function request($path, $options = []) {
		$url = $this->base.'/api/v1/'.$path;
		return $this->_request($url, array_merge($options, [
			'json' => true,
			'headers' => [
				'Authorization' => 'Bearer '.$this->accessToken
			]
		]));
	}

}

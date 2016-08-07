<?php
namespace Acuity;

//require_once(__DIR__.DIRECTORY_SEPARATOR.'AcuityScheduling.php');

class OAuth extends Scheduling
{

    protected $accessToken;
    protected $clientId;
    protected $clientSecret;
    protected $redirectUri;
    protected $scope; //Set scope globally

    public function __construct($options)
    {
        if (!isset($options['scope'])) {
            trigger_error('Missing `scope` parameter.', E_USER_ERROR);
        }
        $this->accessToken  = isset($options['accessToken']) ? $options['accessToken'] : "";
        $this->clientId     = $options['clientId'];
        $this->clientSecret = $options['clientSecret'];
        $this->redirectUri  = $options['redirectUri'];
        $this->base         = isset($options['base']) ? $options['base'] : $this->base;
    }

    public function getAuthorizeUrl($params = [])
    {
        $query = array(
            'response_type' => 'code',
            'scope'         => $this->scope,
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUri
        );

        if (isset($params['state'])) {
            $query['state'] = $params['state'];
        }

        return $this->base.'/oauth2/authorize'.'?'.http_build_query($query);
    }

    public function authorizeRedirect($params = [])
    {
        header('Location: '.$this->getAuthorizeUrl($params));
    }

    public function requestAccessToken($code)
    {
        $data = array(
            'grant_type'    => 'authorization_code',
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri
        );

        $body = $this->__request($this->base.'/oauth2/token', array(
            'data' => $data,
            'method' => 'POST'
        ));
        $body = json_decode($body, true);
        if ($body['access_token']) {
            $this->accessToken = $body['access_token'];
        }

        return $body;
    }

    public function isConnected()
    {
        return $this->accessToken ? true : false;
    }

    public function request($path, $options = array())
    {
        // Ensure call made only to endpoint matching scope
        $url = $this->base.'/'.str_replace("-", "/", $this->scope).'/'.$path;
        return $this->__request($url, array_merge($options, array(
            'json' => true,
            'headers' => array(
                'Authorization' => 'Bearer '.$this->accessToken
            )
        )));
    }
}

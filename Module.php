<?php

namespace madurmanov\FacebookApiDriver;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
  const API_URL = 'https://graph.facebook.com';
  const OAUTH_PERMISSION_URL = 'https://www.facebook.com/dialog/oauth';
  const OAUTH_ACCESS_TOKEN_URL = 'https://graph.facebook.com/oauth/access_token';

  public $clientID = 0;
  public $pageID = 0;
  public $secret = '';
  public $scope = [];
  public $accessToken = '';

  public function request($method, $type = 'GET', $params = [], $accessToken = false)
  {
    $result = '';
    if ($accessToken) $params['access_token'] = $this->accessToken;
    $url = self::API_URL . "/{$this->pageID}/{$method}";
    switch ($type) {
      case 'GET':
        $url .= "?" . http_build_query($params);
        $result = file_get_contents($url);
        break;
      case 'POST':
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        break;
    }
    return json_decode($result);
  }

  public function getAccessTokenUrl()
  {
    return self::OAUTH_ACCESS_TOKEN_URL
      . '?' . http_build_query([
        'type' => 'client_cred',
        'client_id' => $this->clientID,
        'client_secret' => $this->secret
      ]);
  }

  public function getPermissionUrl($callback)
  {
    return self::OAUTH_PERMISSION_URL
      . '?' . http_build_query([
        'client_id' => $this->clientID,
        'client_secret' => $this->secret,
        'redirect_uri' => $callback,
        'scope' => implode(',', $this->scope),
        'response_type' => 'token'
      ]);
  }
}

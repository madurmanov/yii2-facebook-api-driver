<?php

namespace madurmanov\FacebookApiDriver;

use yii\base\Module as BaseModule;

class Module extends BaseModule
{
  const API_URL = 'https://graph.facebook.com';

  public $pageID = 0;
  public $accessToken = '';

  public function request($method, $type = 'GET', $params = [], $accessToken = false)
  {
    $result = false;
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
}

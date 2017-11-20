<?php

namespace madurmanov\FacebookApiDriver;

use Facebook\Facebook as FacebookSDK;
use yii\base\Module as BaseModule;

class Module extends BaseModule
{
  public $appID = 0;
  public $appSecret = '';
  public $pageID = 0;
  public $accessToken = '';
  public $graphVersion = 'v2.8';

  protected $api = null;

  public function init()
  {
    $this->api = new FacebookSDK([
      'app_id' => $this->appID,
      'app_secret' => $this->appSecret,
      'default_graph_version' => $this->graphVersion
    ]);
    if ($this->accessToken) {
      $this->api->setDefaultAccessToken($this->accessToken);
    }
  }

  public function request($method, $params = [], $accessToken = '')
  {
    if (!$accessToken) $accessToken = $this->accessToken;
    return $this->api->post($method, $params, $accessToken);
  }

  public function getPageAccessToken($pageID)
  {
    $pages = $this->api->get('/me/accounts');
    $pages = $pages->getGraphEdge()->asArray();
    foreach ($pages as $page) {
      if ($page['id'] == $pageID) return $page['access_token'];
    }
    return null;
  }

  public function login($redirectUri, $permissions)
  {
    $helper = $this->api->getRedirectLoginHelper();
    $accessToken = $helper->getAccessToken();
    if (isset($accessToken)) {
      $oAuth2Client = $this->api->getOAuth2Client();
      $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
      return (string) $longLivedAccessToken;
    }
    return $helper->getLoginUrl($redirectUri, $permissions);
  }
}

# yii2-facebook-api-driver
Module that enables send request to facebook api for Yii Framework 2.0.

## Installation
```
composer require madurmanov/yii2-facebook-api-driver "@dev"
```

## AccessToken
- Create app [https://developers.facebook.com](https://developers.facebook.com)
- Set enabled url addresses in app settings and product login settings
- Execute next code with entered `appID` and `appSecret` parameters in module configuration
```
$FacebookApiDriver = Yii::$app->getModule('FacebookApiDriver');
// link should be coincide with page url where function call
var_dump($FacebookApiDriver->login('http://example.com', ['manage_pages', 'publish_pages']));
```
- First you will get link for login on which you need to follow
- After redirect to entered page you will get access token for configurate

## Configuration
```
'modules' => [
  'FacebookApiDriver' => [
    'class' => 'madurmanov\FacebookApiDriver\Module',
    'appID' => 0,
    'appSecret' => 0,
    'pageID' => 0,
    'accessToken' => ''
  ]
]
```

## Usage
```
$FacebookApiDriver = Yii::$app->getModule('FacebookApiDriver');
$FacebookApiDriver->request("/{$FacebookApiDriver->pageID}/feed", 'POST', [
  'message' => ''
], $FacebookApiDriver->getPageAccessToken($FacebookApiDriver->pageID));
```

## License
**yii2-facebook-api-driver** is released under the MIT License. See the bundled `LICENSE.md` for details.

# yii2-facebook-api-driver
Module that enables send request to facebook api for Yii Framework 2.0.

## Installation
```
composer require madurmanov/yii2-facebook-api-driver "@dev"
```

## Configuration
```
'modules' => [
  'FacebookApiDriver' => [
    'class' => 'madurmanov\FacebookApiDriver\Module',
    'pageID' => 0,
    'accessToken' => ''
  ]
]
```

## Usage
```
$FacebookApiDriver = Yii::$app->getModule('FacebookApiDriver');
$FacebookApiDriver->request('feed', 'POST', [
  'message' => ''
], true);
```

## License
**yii2-facebook-api-driver** is released under the MIT License. See the bundled `LICENSE.md` for details.

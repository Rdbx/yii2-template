<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php',
);

return [
    'id' => 'advanced-doc',
    'basePath' => dirname(__DIR__),
    'layout' => false,
    'controllerNamespace' => 'api\controllers',
    'bootstrap' => [
        'swagger_module',
        \doc\Bootstrap::class,
    ],
    'components' => [

        //<editor-fold desc="swagger">
        'swagger' => [
            'class' => \Redbox\Swagger\SwaggerManager::class,
            'scopeProvider' => [
                'class' => \Redbox\Auth\ScopeProvider::class
            ],
            'servers' => [
                [
                    'url'         => env('API_URL'),
                    'description' => 'Endpoint рабочего API',
                ],
                [
                    'url'         => env('DOC_API_URL'),
                    'description' => 'Endpoint с заглушками',
                ],
            ],
            'verbs'   => [],
        ],
        //</editor-fold>

        'request' => [
            'class' => \yii\web\Request::class,
            'cookieValidationKey' => 'test-cookie-key',
            'baseUrl' => '/doc',
            'parsers' => [
                'application/json+rpc-2.0' => [
                    'class' => \yii\web\JsonParser::class,
                    'asArray' => false,
                ],
                'application/json' => \yii\web\JsonParser::class,
                'text/xml' => \api\parsers\XmlParser::class,
                'application/xml' => \api\parsers\XmlParser::class,
                'multipart/form-data' => \yii\web\MultipartFormDataParser::class,
            ],
        ],
        'response' => [
            'class' => \yii\web\Response::class,
        ],
        'errorHandler' => [
            'class' => \doc\exceptions\Handler::class,
        ],
        // <editor-fold desc="session">
        'session' => [
            'class' => \yii\web\Session::class,
            'name' => 'advanced-doc',
        ],
        // </editor-fold>
    ],
    'modules' => [
        'swagger_module' => [
            'class' => \Redbox\Swagger\Module::class,
        ],
    ],
    'params' => $params,
];

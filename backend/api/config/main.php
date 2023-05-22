<?php

$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/params.php',
);

return [
    'id'                  => 'advanced-api',
    'basePath'            => dirname(__DIR__),
    'layout'              => false,
    'controllerNamespace' => 'api\controllers',
    'bootstrap'           => [
        \api\Bootstrap::class,
    ],
    'components'          => [
        'request'      => [
            'class'               => \api\Request::class,
            'trustedHosts' => [
                $_SERVER['SERVER_ADDR'],
            ],
            'cookieValidationKey' => 'test-key',
            "baseUrl"             => "/api",
            'parsers'             => [
//                'application/json+rpc-2.0' => \Redbox\JsonRpc\Parser::class,
                'application/json'    => \yii\web\JsonParser::class,
                'text/xml'            => \Redbox\Core\Parsers\XmlParser::class,
                'application/xml'     => \Redbox\Core\Parsers\XmlParser::class,
                'multipart/form-data' => \yii\web\MultipartFormDataParser::class,
            ]
        ],
        'response' => [
            'class' => \yii\web\Response::class,
//            'format' => \yii\web\Response::FORMAT_JSON,
            'formatters' => [
//                'json+rpc-2.0' => [
//                    'class' => \Redbox\JsonRpc\Formatter::class,
//                    'prettyPrint' => YII_DEBUG,
//                    // используем "pretty" в режиме отладки
//                    'encodeOptions' => JSON_UNESCAPED_SLASHES
//                        | JSON_UNESCAPED_UNICODE,
//                ],
                \yii\web\Response::FORMAT_XML => [
                    'class' => \yii\web\JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    // используем "pretty" в режиме отладки
                    'encodeOptions' => JSON_UNESCAPED_SLASHES
                        | JSON_UNESCAPED_UNICODE,
                ],
                \yii\web\Response::FORMAT_JSON => [
                    'class' => \yii\web\JsonResponseFormatter::class,
                    'prettyPrint' => YII_DEBUG,
                    // используем "pretty" в режиме отладки
                    'encodeOptions' => JSON_UNESCAPED_SLASHES
                        | JSON_UNESCAPED_UNICODE,
                ],
            ],
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            "class" => \api\exceptions\Handler::class,
            "maxTraceSourceLines" => 10,
//            'errorAction' => 'site/error',
        ],
    ],
    'modules'             => [
    ],
    'params'              => $params,
];

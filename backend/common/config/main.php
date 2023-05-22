<?php

use Redbox\Auth\AccountModel;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

$config = [
    'language'       => 'ru-RU',
    'sourceLanguage' => 'ru-RU',
    'timeZone'       => 'Europe/Moscow',

    //<editor-fold desc="bootstrap">
    'bootstrap'      => [
        'file_module',
        'core_module',
        'auth_module',
        'collection_module',
        'log',
        'queue',
        'oauth2',
        \common\Bootstrap::class,
    ],
    //</editor-fold>
    //<editor-fold desc="bootstrap">
    'container'      => [
        "singletons" => [
            'fql' => [
                "class"                                             => \Redbox\Filter\FQL\Parser::class,
                "requestParam"                                      => "filter",
                'on '
                .\Redbox\Filter\FQL\Parser::EVENT_FILTER_HAS_ERRORS => function (
                    \yii\base\Event $event
                ) {
                    throw new \Redbox\AdvanceActiveRecord\Exceptions\ValidateException($event->sender);
                }
            ],
        ]
    ],
    //</editor-fold>
    //<editor-fold desc="aliases">
    'aliases'        => [
        '@cdn'            => env('STORAGE_PUBLIC_URL'),
        '@frontend'       => env('FRONTEND_URL'),
        '@host'           => env('HOST_URL'),
        '@web'            => '',
        '@public_default' => '@cdn/default',
        '@public'         => '@cdn',
        '@storage'        => '@app/../../storage',
        '@root'           => '@vendor/../../backend',
        '@bower'          => '@vendor/bower-asset',
        '@npm'            => '@vendor/npm-asset',
        '@tests'          => '@root/tests',
        '@doc'            => '@root/doc/web',
    ],
    //</editor-fold>

    //<editor-fold desc="vendorPath">
    'vendorPath'     => dirname(__DIR__, 2).'/vendor',
    //</editor-fold>

    //<editor-fold desc="components">
    'components'     => [
        'i18n'         => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],

        //<editor-fold desc="urlManager">
        'urlManager'   => [
            'ruleConfig'          => ['class' => \Redbox\Core\UrlRule::class],
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => true,
            'showScriptName'      => false,
            'rules'               => [],
        ],
        //</editor-fold>

        //<editor-fold desc="errorHandler">
        'errorHandler' => [
            'class'               => \common\exceptions\Handler::class,
            "maxTraceSourceLines" => 5
        ],
        //</editor-fold>

        //<editor-fold desc="authManager">
        'authManager'  => [
            'class'        => \yii\rbac\PhpManager::class,
            'defaultRoles' => ['guest'],
        ],
        //</editor-fold>

        // <editor-fold desc="permission">
        'permission'   => [
            'class' => \common\modules\permission\Permission::class,

            'enableCache' => true,

            // Casbin model setting.
            'model'       => [
                // Available Settings: "file", "text"
                'config_type'      => 'file',
                'config_file_path' => __DIR__.'/casbin-model.conf',
                'config_text'      => '',
            ],

            // Casbin adapter.
            'adapter'     => \common\modules\permission\Adapter::class,

            // Casbin database setting.
            'database'    => [
                // Database connection for following tables.
                'connection'         => 'db',
                // CasbinRule tables and model.
                'casbin_rules_table' => '{{%permission_rules}}',
            ],
        ],
        // </editor-fold>
        //<editor-fold desc="user">
        'user'         => [
            'class'           => \yii\web\User::class,
            'loginUrl'        => null,
            'identityClass'   => AccountModel::class,
            'enableAutoLogin' => false,
            'enableSession'   => false,
        ],
        //</editor-fold>

        //<editor-fold desc="session">
        'session'      => [
            'class' => \yii\web\Session::class,
            'name'  => 'advanced-api',
        ],
        //</editor-fold>

        //<editor-fold desc="cache">
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        //</editor-fold>

        //<editor-fold desc="db">
        'mutex'        => [
            'class' => \yii\mutex\PgsqlMutex::class,
        ],

        'db'     => [
            'class'    => yii\db\Connection::class,
            'dsn'      => implode(":", [
                env('DB_DRIVER'),
                implode(";", [
                    'host='.env('DB_HOST'),
                    'port='.env('DB_PORT', "3306"),
                    'dbname='.env('DB_DATABASE'),
                ])
            ]),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset'  => 'utf8',
        ],


        //</editor-fold>

        //<editor-fold desc="mailer">
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => env('SMTP_HOST'),
                'username'   => env('SMTP_USERNAME'),
                'password'   => env('SMTP_PASSWORD'),
                'port'       => env('SMTP_PORT'),
                'encryption' => 'ssl',
            ],
        ],

        //</editor-fold>


        //<editor-fold desc="redis">
        'redis'  => [
            'class' => \yii\redis\Connection::class,
            // ...
        ],
        //</editor-fold>

        //<editor-fold desc="queue">
        'queue'  => [
            'class'     => \common\Queue::class,
            'db'        => 'db',
            // Компонент подключения к БД или его конфиг
            'tableName' => '{{%queue}}',
            // Имя таблицы
            'channel'   => 'default',
            // Выбранный для очереди канал
            'mutex'     => \yii\mutex\PgsqlMutex::class,
            //            'mutex'                        => \yii\mutex\MysqlMutex::class,
            // Мьютекс для синхронизации запросов
            'as log'    => \yii\queue\LogBehavior::class,

            'on '.\yii\queue\Queue::EVENT_AFTER_ERROR => function (
                \yii\queue\ExecEvent $event
            ) {
                (new \console\exceptions\QueueHandler())->handle($event->job,
                    $event->error);
            },
        ],
        //</editor-fold>
    ],
    //</editor-fold>

    //<editor-fold desc="modules">
    'modules'        => [
        "file_module"       => [
            'class'              => Redbox\FileManager\Module::class,
            "fileModel"          => \common\models\FileModel::class,
            "savePath"           => "@storage/public",
            "domain"             => "@cdn",
            "thumbs"             => [
                'icon'   => [
                    'w'    => 50,
                    'h'    => 50,
                    'q'    => 50,
                    'slug' => 'icon'
                ],
                'small'  => [
                    'w'    => 320,
                    'h'    => 320,
                    'q'    => 50,
                    'slug' => 'small'
                ],
                'low'    => [
                    'w'    => 640,
                    'h'    => 640,
                    'q'    => 50,
                    'slug' => 'low'
                ],
                'normal' => [
                    'w'    => 1024,
                    'h'    => 1024,
                    'q'    => 50,
                    'slug' => 'normal'
                ]
            ],
            "imageExtensions"    => [
                'jpg',
                'png',
                'bmp',
                'gif'
            ],
            "userFileName"       => false,
            "userQueueThumbnail" => false,
        ],

        "collection_module" => [
            "class" => \Redbox\Collection\Module::class
        ],
        "auth_module"       => [
            "class" => \Redbox\Auth\Module::class,
        ],
        "core_module"       => [
            "class"      => \Redbox\Core\Module::class,
            "authFilter" => [
                'class'       => \filsh\yii2\oauth2server\filters\auth\CompositeAuth::class,
                'authMethods' => [
                    ['class' => HttpBearerAuth::class],
                    ['class' => QueryParamAuth::class],
                ],
                'except'      => ['options'],
            ],
        ],
        "oauth2"            => [
            'class'               => \filsh\yii2\oauth2server\Module::class,
            'tokenParamName'      => 'access-token',
            'tokenAccessLifetime' => 3600 * 24,
            'useJwtToken'         => true,
            'components'          => [
                'request'  => function () {
                    return \filsh\yii2\oauth2server\Request::createFromGlobals();
                },
                'response' => [
                    'class' => \filsh\yii2\oauth2server\Response::class,
                ],
            ],
            'storageMap'          => [
                'user_credentials' => \Redbox\Auth\AccountModel::class,
                'public_key'       => \Redbox\Auth\PublicKeyStorage::class,
                'access_token'     => \OAuth2\Storage\JwtAccessToken::class,
            ],
            'grantTypes'          => [
                'user_credentials' => [
                    'class' => \OAuth2\GrantType\UserCredentials::class,
                ],
                'refresh_token'    => [
                    'class'                          => \OAuth2\GrantType\RefreshToken::class,
                    'always_issue_new_refresh_token' => true
                ]
            ],
            'options'             => [
                'allow_implicit'             => true,
                'require_exact_redirect_uri' => false
            ]
        ],
    ],
    //</editor-fold>
];


if (YII_DEBUG) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class'      => 'yii\debug\Module',
        'traceLine'  => '<a href="phpstorm://open?url={file}&line={line}">{file}:{line}</a>',
        // uncomment and adjust the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '78.138.147.154', '*'],
        'panels'     => [
            'user' => false,
        ],
    ];
}

return $config;
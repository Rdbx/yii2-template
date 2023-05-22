<?php
$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/params.php',
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'seeder' => [
            'class' => \antonyz89\seeder\SeederController::class
        ],
        'migrate' => [
            'class' => \yii\console\controllers\MigrateController::class,
            'migrationPath' => [
                '@console/migrations',
                '@vendor/rdbx/yii2-collection/migrations',
                '@vendor/rdbx/yii2-filemanager/migrations',
            ]
        ]
    ],
    'components' => [
        //<editor-fold desc="errorHandler">
        'errorHandler' => [
            'class' => \console\exceptions\ConsoleHandler::class,
            "maxTraceSourceLines" => 5
        ],
        //</editor-fold>
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules'             => [
        'generator' => [
            'class' => \console\modules\generator\Module::class,
        ],
        'install' => [
            'class' => \console\modules\install\Module::class,
        ],
    ],
];

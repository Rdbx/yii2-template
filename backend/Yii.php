<?php

abstract class ApplicationPlaceholders {
    public \yii\queue\Queue $queue;
    public \Redbox\Swagger\SwaggerManager $swagger;
}

class Yii extends \yii\BaseYii
{
    /** @var \yii\console\Application|\yii\web\Application|\yii\base\Application|ApplicationPlaceholders $app **/
    public static $app;

    /** @inheritdoc  */
    public static $container;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require __DIR__ . '/vendor/yiisoft/yii2/classes.php';
Yii::$container = new yii\di\Container();
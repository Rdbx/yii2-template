<?php

namespace doc;

use filsh\yii2\oauth2server\models\OauthScopes;
use OpenApi\Annotations\Flow;
use yii\base\BootstrapInterface;
use yii\helpers\ArrayHelper;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        try {
            $scopes = OauthScopes::find()->select(['scope', 'title'])->all();
            $scopes = ArrayHelper::map($scopes, 'scope', 'title');
            \Yii::$app->swagger->security = [
                'flows' => [
                    new Flow([
                        'authorizationUrl' => 'api/oauth/authorize',
                        'flow'             => 'implicit',
                        'scopes'           => $scopes,
                    ]),
                ]
            ];
        } catch (\Throwable $ex){
            if ($ex->getCode() === '42P01'){
                throw new \Exception(\Yii::t('app', 'Please migrate oauth plugin', []));
            }
        }
    }
}

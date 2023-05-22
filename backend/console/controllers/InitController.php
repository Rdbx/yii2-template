<?php

namespace console\controllers;

use common\exceptions\ValidationException;
use common\models\Collection;
use common\models\MetaCommonField;
use common\models\User;
use console\AbstractConsoleController;
use Faker\Factory;
use filsh\yii2\oauth2server\models\OauthClients;
use Redbox\Core\ConsoleController;
use Symfony\Component\Console\Output\OutputInterface;
use Yii;
use yii\console\Application;

class InitController extends ConsoleController
{
    public function consoleLog($message, $writeLn = false)
    {
        if (\Yii::$app instanceof Application) {
            $this->output->write($message, $writeLn,
                OutputInterface::OUTPUT_NORMAL);
        }
    }

    public function actionAll()
    {
        $this->actionOAuth();
    }

    public function actionOAuth()
    {
        /** @var OauthClients $temp */
        $temp = OauthClients::find()->andWhere(["client_id" => 'self'])->one();
        if (!$temp)
            $this->output->writeln("Не найден oauth.client_id = self, инициализируйте базу данных!");

        $temp->client_secret = Yii::$app->security->generateRandomString(32);
        $temp->redirect_uri = Yii::getAlias('@host/');
        $temp->save();

        $this->output->writeln("success");
    }

}
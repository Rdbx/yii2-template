<?php

namespace console\controllers;

use common\models\User;
use common\models\UserProfile;
use Redbox\Core\ConsoleController;

class UserController extends ConsoleController
{
    const NAME = "Админ";
    const EMAIL = "i@rdbx.ru";
    const PHONE = "79046784532";

    public function actionInit()
    {
        $user = User::findOne(1);

        if( $user ) {
          echo "Пользователь уже добавлен\n";
          return;
        }

        // $password = \Yii::$app->security->generateRandomString(9);
        $password = "007121";

        $user = new User();
        $user->username = self::PHONE;
        $user->email = self::EMAIL;
        $user->status = User::STATUS_ACTIVE;
        $user->generateAuthKey();
        $user->setPassword($password);

        if($user->save()) {
          $model = new UserProfile();
          $model->user_id = $user->id;
          $model->name = self::NAME;
          $model->phone = self::PHONE;

          $model->save(false);

          $auth = \Yii::$app->authManager;
          $role = $auth->getRole('admin');
          $auth->assign($role, $user->id);

          echo "Пользователь добавлен. Логин: {$user->username} / пароль: {$password}\n";
          return;
        }
      }
}

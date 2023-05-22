<?php

namespace tests\fixtures;

use yii\test\ActiveFixture;

class TestFixture extends ActiveFixture
{
    public $modelClass = 'common\models\User';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
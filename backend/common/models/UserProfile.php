<?php

namespace common\models;

use Redbox\Auth\AccountModel;
use Redbox\Auth\AccountQuery;
use Yii;

/**
 * This is the model class for table "{{%user_profiles}}".
 *
 * @property AccountModel $account
 */
class UserProfile extends \common\database\table\UserProfile
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[]);
    }

    /**
    * {@inheritdoc}
    */
    public function extraFields()
    {
        return array_merge(parent::extraFields(), [
            "account" => function() {
                return $this->account;
            },
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            //'id' => 'ID',
            //'account_id' => 'Account ID',
            //'last_name' => 'Last Name',
            //'first_name' => 'First Name',
            //'third_name' => 'Third Name',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
        ]);
    }

    /**
     * Gets query for [[Account]].
     *
     * @return \yii\db\ActiveQuery|AccountQuery
     */
    public function getAccount($relationClass = AccountModel::class)
    {
        return parent::getAccount($relationClass);
    }
}

<?php

namespace common\database\table;

use Redbox\Auth\AccountDatabase;
use Redbox\Auth\AccountModel;
use Redbox\Auth\AccountQuery;
use Yii;

/**
 * This is the model class for table "{{%user_profiles}}".
 *
 * @property int $id
 * @property int $account_id
 * @property string|null $last_name
 * @property string $first_name
 * @property string|null $third_name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AccountDatabase $account
 *
 */
class UserProfile extends \common\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_profiles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(),[
            [['account_id', 'first_name', 'created_at', 'updated_at'], 'required'],
            [['account_id'], 'default', 'value' => null],
            [['account_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['last_name', 'first_name', 'third_name'], 'string', 'max' => 255],
            [['account_id'], 'unique'],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => AccountModel::className(), 'targetAttribute' => ['account_id' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'account_id' => 'Account ID',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'third_name' => 'Third Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }



    /**
    * Gets query for [[Account]].
    *
    * @return \yii\db\ActiveQuery|AccountQuery
    */
    public function getAccount($relationClass = AccountDatabase::class)
    {
    return $this->hasOne($relationClass, ['id' => 'account_id']);
    }


    /**
     * {@inheritdoc}
     * @return \common\queries\UserProfileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\queries\UserProfileQuery(get_called_class());
    }
}

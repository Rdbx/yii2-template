<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_profile}}`.
 */
class m000000_000001_create_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user_profiles}}', [
            'id' => $this->primaryKey(),
            'account_id' => $this->integer()->notNull()->unique(),

            'last_name' => $this->string(),
            'first_name' => $this->string()->notNull(),
            'third_name' => $this->string(),

            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull(),
        ], $tableOptions);

        $this->createIndex(
            'IDX_USER_PROFILE_ACCOUNT_ID',
            '{{%user_profiles}}',
            'account_id'
        );

        $this->addForeignKey(
            'FK_USER_PROFILE_ACCOUNT_ID',
            '{{%user_profiles}}',
            'account_id',
            '{{%accounts}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
           'FK_USER_PROFILE_ACCOUNT_ID',
           '{{%user_profiles}}'
        );

        $this->dropIndex(
           'IDX_USER_PROFILE_ACCOUNT_ID',
           '{{%user_profiles}}'
        );

        $this->dropTable('{{%user_profiles}}');
    }
}

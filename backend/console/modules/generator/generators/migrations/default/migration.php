<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $sourceTableName string full table name */
/* @var $metaTableName string full table name  */
/* @var $filePrefix string prefix */

echo "<?php\n";
?>

use yii\db\Migration;

/**
 * Class <?=$filePrefix?>_<?=$metaTableName?>
 */
class <?=$filePrefix?>_<?=$metaTableName?> extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(
            '<?=$metaTableName?>',
            [
                'id' => $this->primaryKey(11)->unsigned(),
                "meta_field_id" => $this->integer(11)->unsigned()->notNull(),
                "entity_id" => $this->integer(11)->unsigned()->notNull(),
                "value" => $this->binary()->null(),
                "created_at" => $this->timestamp(),
                "updated_at" => $this->timestamp()
            ],
            $tableOptions
        );



        $this->createIndex("IDX_<?=strtoupper($metaTableName)?>_META_FIELD_ID", "<?=$metaTableName?>", ["meta_field_id"]);
        $this->createIndex("IDX_<?=strtoupper($metaTableName)?>_ENTITY_ID", "<?=$metaTableName?>", ["entity_id"]);

        $this->addForeignKey(
            'FK_<?=strtoupper($metaTableName)?>_ENTITY_ID',
            '<?=$metaTableName?>',
            'entity_id',
            '{{%<?=$sourceTableName?>}}',
            'id',
            "CASCADE",
            "CASCADE"
        );

        $this->addForeignKey(
            'FK_<?=strtoupper($metaTableName)?>_META_FIELD_ID',
            '<?=$metaTableName?>',
            'meta_field_id',
            '_meta_common_fields',
            'id',
            "CASCADE",
            "CASCADE"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211222_121503__meta_regions_values cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211222_121503__meta_regions_values cannot be reverted.\n";

        return false;
    }
    */
}

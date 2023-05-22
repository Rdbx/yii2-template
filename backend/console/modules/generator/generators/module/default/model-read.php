<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $baseClass string base class name */
/* @var $ns string namespace */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */


echo "<?php\n";
?>

namespace <?= $ns ?>\<?=$moduleID?>\models\read;

use Yii;

class <?= $className ?>Read extends <?= "\\common\\models\\$className\n" ?>
{
    /**
    * {@inheritdoc}
    */
    public function extraFields()
    {
        return array_merge(parent::extraFields(), []);
    }

    /**
    * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
<?php foreach ($labels as $name => $label): ?>
            <?= "//'$name' => ".$generator->generateString($label).",\n" ?>
<?php endforeach; ?>
        ]);
    }
}

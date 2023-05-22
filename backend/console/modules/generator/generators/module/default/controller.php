<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */
/* @var string $className */
/* @var string $moduleID */
/* @var string $tableName */
/* @var string $ns */

$relation_imploded = "";
if (!empty($relations)) {
    $temp = [];

    foreach ($relations as $name => $relation) {
        $temp[] = "\"". \yii\helpers\Inflector::camel2id($name, '_', true) ."\"";
    }
    $relation_imploded = implode(",",$temp);
}

echo "<?php\n";
?>

namespace <?= "$ns\\$moduleID\\controllers" ?>;

use yii\db\ActiveRecord;
use <?=$ns?>\<?=$moduleID?>\models\read\<?= $className ?>Read;
use <?=$ns?>\<?=$moduleID?>\models\write\<?= $className ?>Write;
use Redbox\Swagger\Attributes\Patterns\IndexAction;
use Redbox\Swagger\Attributes\Patterns\ViewAction;
use Redbox\Swagger\Attributes\Patterns\CreateAction;
use Redbox\Swagger\Attributes\Patterns\UpdateAction;
use Redbox\Swagger\Attributes\Patterns\DeleteAction;

#[IndexAction(summary: 'Получить все "<?=$tableName?>"', readClass:<?= $className ?>Read::class, writeClass:<?= $className ?>Write::class)]
#[ViewAction(summary: 'Получение элемента "<?=$tableName?>"', readClass:<?= $className ?>Read::class, writeClass:<?= $className ?>Write::class)]
#[CreateAction(summary: 'Добавление элемента "<?=$tableName?>"', readClass:<?= $className ?>Read::class, writeClass:<?= $className ?>Write::class)]
#[UpdateAction(summary: 'Изменение элемента "<?=$tableName?>"', readClass:<?= $className ?>Read::class, writeClass:<?= $className ?>Write::class)]
#[DeleteAction(summary: 'Удаление элемента "<?=$tableName?>"', readClass:<?= $className ?>Read::class, writeClass:<?= $className ?>Write::class)]
class <?= $className ?>Controller extends \api\ApiActiveController
{
    /** @var string|ActiveRecord|<?= $className ?>Read */
    public null|object|string $readModelClass = <?= $className ?>Read::class;
    /** @var string|ActiveRecord|<?= $className ?>Write */
    public null|object|string $writeModelClass = <?= $className ?>Write::class;
}
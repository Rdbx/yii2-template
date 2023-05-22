<?php
/**
 * This is the template for generating a module class file.
 */

/* @var $className string */
/* @var $this yii\web\View */
/* @var $models array */
/* @var $generator yii\gii\generators\module\Generator */


echo "<?php\n";
?>

namespace <?= "$ns\\$moduleID" ?>;

/**
 * <?= $generator->moduleID ?> module definition class
 */
class <?= $className ?> extends \common\AbstractModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = '<?= $generator->getControllerNamespace() ?>';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
    * @inheritdoc
    */
    public function routes($moduleID)
    {
        $moduleID = $this->id;
        return [
<?php foreach ($models as $model): ?>
            //<editor-fold desc="<?=$model["tableName"]?>">
            "PUT,PATCH <?=\yii\helpers\Inflector::camel2id($model["className"])?>/<id:\d+>" => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/update",
            "DELETE <?=\yii\helpers\Inflector::camel2id($model["className"])?>/<id:\d+>"    => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/delete",
            "GET,HEAD <?=\yii\helpers\Inflector::camel2id($model["className"])?>/<id:\d+>"  => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/view",
            "POST <?=\yii\helpers\Inflector::camel2id($model["className"])?>"               => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/create",
            "GET,HEAD <?=\yii\helpers\Inflector::camel2id($model["className"])?>"           => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/index",
            "OPTIONS <?=\yii\helpers\Inflector::camel2id($model["className"])?>/<id:\d+>"   => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/options",
            "OPTIONS <?=\yii\helpers\Inflector::camel2id($model["className"])?>"            => "{$moduleID}/<?=\yii\helpers\Inflector::camel2id($model["className"])?>/options",
            //</editor-fold>
<?php endforeach; ?>

        ];
    }
}

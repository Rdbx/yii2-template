<?php
namespace console\modules\install;

class Module extends \yii\base\Module
{
    public $id = "install";

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'console\modules\install\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::setAlias("@install", "@root/console/modules/install");
        \Yii::setAlias("@install_resources", "@install/resources");
    }
}

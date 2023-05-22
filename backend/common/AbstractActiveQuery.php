<?php

namespace common;

use yii\db\ActiveQuery;
use yii\db\QueryBuilder;

abstract class AbstractActiveQuery extends ActiveQuery
{
    public function __construct($modelClass, $config = [])
    {
        parent::__construct($modelClass, $config);
//        $this->with("metaValues");
    }

}
<?php

namespace common\modules\metaInfo\models\write;

use Yii;

class MetaCommonFieldWrite extends \common\models\MetaCommonField
{
    public static function __docAttributeIgnore()
    {
        return [
            "id",
            "created_at",
            "updated_at"
        ];
    }
}

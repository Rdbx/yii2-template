<?php

namespace common\models;

class FileModel extends \Redbox\FileManager\FileModel
{
    /**
     * @return array|false
     */
    public function fields()
    {
        $fields = [
            "id",
            "title",
            "description",
            "slug",
            "name",
            "ext",
            'linkAbsolute'
        ];

        if($this->getIsImage()){
            $fields['thumbnails'] = 'imageThumbs';
        }

        return $fields;
    }
}
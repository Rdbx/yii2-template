<?php
namespace common;

use Carbon\Carbon;
use common\contracts\ISwaggerDoc;
use common\exceptions\ValidationException;
use OpenApi\Annotations\OpenApi;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\web\UploadedFile;

abstract class BaseModel extends Model implements ISwaggerDoc
{
    public static function __docAttributeExample()
    {
        return [
            "id" => random_int(1,100),
            "updated_at" => Carbon::now()->format(Carbon::DEFAULT_TO_STRING_FORMAT),
            "created_at" => Carbon::now()->format(Carbon::DEFAULT_TO_STRING_FORMAT),
        ];
    }

    public static function __docAttributeIgnore()
    {
        return [];
    }

    public static function __makeDocumentationEntity()
    {
        return new static();
    }

    public function __set($name, $value)
    {
        $setter = Inflector::variablize("set_{$name}_attribute");
        if (method_exists($this, $setter)) {
            $this->$setter($value);
            return;
        } else {
            parent::__set($name, $value);
        }
    }

    public function __get($name)
    {
        $getter = Inflector::variablize("get_{$name}_attribute");
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } else {
            return parent::__get($name);
        }
    }


    public function __docs(OpenApi $openApi)
    {
        $reflect = new \ReflectionClass($this);
        $schema = new Schema([
            "schema"     => $reflect->getShortName(),
            "title"      => $reflect->getShortName(),
            "properties" => []
        ]);

        $types = [];

        if (method_exists($this, "__docAttributeTypes")) {
            $types = $this->__docAttributeTypes();
        }

        $examples = $this->__docAttributeExample();

        $fields = array_keys(array_merge(
            $this->attributes,
            $this->fields(),
            $this->extraFields()
        ));

        foreach ($fields as $field) {
            if ($field === null) {
                continue;
            }
            if (!in_array($field, $this->__docAttributeIgnore())) {
                $propertyData = [
                    "property"    => $field,
                    "title"       => $this->getAttributeLabel($field),
                    "description" => $field,
                ];

                if (isset($types[$field])) {
                    $type = $types[$field];

                    if ($type == UploadedFile::class) {
                        $type = "file";
                    }

                    $propertyData["type"] = $type;
                } else {
                    $propertyData["type"] = "string";
                }

                $prop = new Property($propertyData);
                if (array_key_exists($field, $examples)) {
                    $prop->example = $examples[$field];
                }

                $schema->properties[] = $prop;
            }
        }

        return $schema;
    }
}

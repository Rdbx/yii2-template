<?php

namespace common;

use api\helpers\UrlRule;
use common\contracts\ISwaggerDoc;
use OpenApi\Annotations\OpenApi;
use OpenApi\Annotations\Property;
use OpenApi\Annotations\Schema;
use Yii;
use yii\base\BootstrapInterface;
use yii\base\InvalidRouteException;
use yii\db\ActiveRecord;
use yii\web\Controller;

abstract class AbstractModule extends \yii\base\Module
    implements BootstrapInterface
{
    /**
     * @param $moduleID
     *
     * @return string[]|mixed
     */
    abstract public function routes($moduleID);

    public function bootstrap($app)
    {
        $urlManager = Yii::$app->getUrlManager();
        $moduleID = $this->id;

        foreach ($this->routes($moduleID) as $pattern => $route) {
            if (is_array($route)){
                $urlManager->addRules([
                    $route
                ]);
            }
            else if (preg_match("/(?<verb>(?:(?:GET|PUT|POST|PATCH|DELETE|OPTIONS|HEAD)[,]?)+ )?(?<url>.*)/",
                    $pattern, $match) !== false
            ) {
                $rule = [
                    'class'   => \Redbox\Core\UrlRule::class,
                    "pattern" => $pattern,
                    "route"   => $route
                ];

                if (isset($match["verb"])) {
                    $rule["verb"] = explode(",", trim($match["verb"]));
                }
                if (isset($match["url"])) {
                    $rule["pattern"] = trim($match["url"]);
                }

                $urlManager->addRules([
                    $rule
                ]);
            }
        }
    }
}
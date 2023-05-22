<?php

namespace console\modules\install\controllers;

use console\AbstractConsoleController;
use console\modules\install\actions\InstallAuthAction;
use console\modules\install\actions\InstallCollectionAction;
use console\modules\install\actions\InstallMetaAction;
use Redbox\Core\ConsoleController;

class DefaultController extends ConsoleController
{
    public function actions()
    {
        return [
            "auth"       => [
                "class" => InstallAuthAction::class,
                "resources" => [
                    "@install_resources/auth/default.php"
                ],
            ],
            "collection" => [
                "class" => InstallCollectionAction::class,
                "resources" => [
                    "@install_resources/collections/default.php"
                ],
            ],
            "meta"       => [
                "class" => InstallMetaAction::class,
                "resources" => [
                    "@install_resources/meta/default.php"
                ],
            ]
        ];
    }

}
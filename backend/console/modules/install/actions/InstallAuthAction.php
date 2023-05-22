<?php

namespace console\modules\install\actions;

use common\rbac\roles\Role;
use console\AbstractConsoleController;
use yii\base\Action;
use yii\rbac\Permission;

/**
 * @property AbstractConsoleController $controller
 */
class InstallAuthAction extends Action
{
    public $resources = [];

    public function run($collection = null)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        $auth = \Yii::$app->authManager;
        $auth->removeAll();
        try {
            foreach ($this->resources as $collectionFile) {
                $data = include realpath(\Yii::getAlias($collectionFile));
                $maxCount = count($data);
                $this->controller->consoleLog("Установка файла доступов: <number>$collectionFile</number> (<number>$maxCount</number>):", true);

                if (array_key_exists("permissions", $data)){
                    foreach ($data['permissions'] as $permissionName =>  $permissionData){
                        $this->initPermission($permissionName, $permissionData);
                    }
                }
                if (array_key_exists("roles", $data)){
                    foreach ($data['roles'] as $roleName =>  $roleData){
                        $this->initRole($roleName, $roleData);
                    }
                }
                unset($data);
            }
            $transaction->commit();
        } catch (\Throwable $ex) {
            $transaction->rollBack();
            $this->controller->consoleLog("<error>{$ex->getMessage()}</error>", true);
        }
        $this->controller->consoleLog("<value>Авторизация загружена!</value>", true);
    }

    private function initRole($roleName, $roleData)
    {
        $auth = \Yii::$app->authManager;
        $role = $auth->getRole($roleName);
        if (!$role){
            $role = new Role();
            $role->name = $roleName;
            $role->description = $roleData["title"] ?? "Сгенерировано автоматически";
            $role->priority = 0;
            $auth->add($role);
        }

        if (array_key_exists('assign_roles', $roleData)){
            foreach ($roleData["assign_roles"] as $assignRoleName){
                $assignRole = $this->initRole($assignRoleName, []);
                if ($auth->canAddChild($assignRole, $role)){
                    $auth->addChild($role,$assignRole);
                }
            }
        }
        if (array_key_exists('assign_permission', $roleData)){
            foreach ($roleData["assign_permission"] as $assignPermissionName){
                $assignPermission = $this->initPermission($assignPermissionName, []);
                $auth->addChild($role, $assignPermission);
            }
        }

        return $role;
    }

    private function initPermission($roleName, $roleData)
    {
        $auth = \Yii::$app->authManager;
        $permission = $auth->getPermission($roleName);
        if (!$permission){
            $permission = new Permission();
            $permission->name = $roleName;
            $permission->description = $roleData["title"] ?? "Сгенерировано автоматически";
            $auth->add($permission);
        }

        if (array_key_exists('assign_permission', $roleData)){
            foreach ($roleData["assign_permission"] as $assignPermissionName){
                $assignPermission = $this->initPermission($assignPermissionName, []);
                $auth->addChild($permission, $assignPermission);
            }
        }

        return $permission;
    }
}
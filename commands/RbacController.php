<?php
namespace app\commands;
 
use Yii;
use yii\console\Controller;
use \app\rbac\UserGroupRule;
 
class RbacController extends Controller
{
    public function actionInit()
    {
        $authManager = \Yii::$app->authManager;

        $authManager -> removeAll();
 
        $admin  = $authManager->createRole('admin');

        $authManager->add($admin);

        $viewAdminPage = $authManager->createpermission('viewAdminPage');
        $viewAdminPage->description = 'Доступ к панели администратора';

        $authManager->add($viewAdminPage);

        $authManager->addChild($admin, $viewAdminPage);
 
        $authManager -> assign($admin, 41);
    }
}
<?php

namespace app\modules\user\controllers;

use app\modules\user\models\UserSettings;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Controller;
use app\models\User;

use Yii;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
    * Метод, в котором определяется вывод информации о пользователе
    * Если был получен GET параметр name_param, то производится формирование "информационной" страницы,
    * т.е. страницы без возможности редактирований
    * Если этого параметра нет, то производится формирование страницы редактирования
    * Данные страницы доступны авторизированным пользователям
    */
    public function actionUserInfo($name_param = false)
    {
        if($name_param === false)
        {
            $data['userInfo'] = Yii::$app->user->identity;
        }
        else
        {

            if(!$data['userInfo'] = User::findByUserName($name_param))
                throw new \yii\web\NotFoundHttpException('Пользователя не существует');
        }

        $data['name_param'] = $name_param;

        $model = new UserSettings;
        $data['modelImageUpload'] = new UserSettings;

        if(Yii::$app->request->isPost)
        {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->uploadImage())
            {
                $this->refresh();
            }
        }
        
        return $this->render('userinfo', $data);
    }

    /**
    * Действие загрузки изображения профиля
    */
    public function actionUploadImage()
    {
        $model = new UserSettings;

        if(Yii::$app->request->post('modelImageUpload'))
        {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if($model->uploadImage())
            {
                echo 'done';
            }
        }
        else
        {
            echo 'nope'; die;
        }
    }
}

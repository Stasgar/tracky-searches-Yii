<?php

namespace app\modules\auth\controllers;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use Yii;

use app\modules\auth\models\PasswordResetRequestForm;
use app\modules\auth\models\PasswordChangeForm;
use app\modules\auth\models\ResetPasswordToken;

class PasswordManagementController extends Controller
{
    public function actionChangePassword($token = false)
    {
        if($token) //если token получен, то производим восстановление пароля
        {
            $modelPasswordChange = new PasswordChangeForm();

            $resetPasswordModel = ResetPasswordToken::findOne(['token' => $token]);
            if($resetPasswordModel)
            {
                if($resetPasswordModel->expires > Date('Y-m-d h:m:s'))
                {
                    if(Yii::$app->request->post('PasswordChangeForm'))
                    {
                        $modelPasswordChange->attributes = Yii::$app->request->post('PasswordChangeForm');

                        if($modelPasswordChange->validate())
                        {
                            $modelPasswordChange->changeUserPassword($resetPasswordModel);
                            return $this->render('ChangeSuccess');
                        }
                        
                    }
                    
                    return $this->render('PasswordChange', ['model' => $modelPasswordChange]);
                }
                else
                {
                    echo 'token is not valid anymore, it stays active only for 30 mins';
                    return $this->goHome();
                }
            }

                echo 'token is not valid';
                return $this->goHome();

        }
        else //если токена нет, то производим изменение п
        {
            echo 'no reset token';die;
        }
        
    }

    public function actionResetPasswordRequest()
    {
        $model = new PasswordResetRequestForm();

        if(Yii::$app->request->Post('PasswordResetRequestForm'))
        {
            $model->attributes = Yii::$app->request->Post('PasswordResetRequestForm');

            if($model->validate())
            {
                $model->sendResetLink();
                return $this->render('ResetSuccess');
            }
        }

        return $this->render('PasswordResetRequestForm', ['model'=>$model]);
    }
}
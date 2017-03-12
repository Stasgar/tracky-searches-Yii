<?php

namespace app\modules\auth\controllers;
use yii\web\Controller;
use yii\helpers\Url;
use app\models\User;
use Yii;

use app\modules\auth\models\PasswordManagement\PasswordResetRequestForm;
use app\modules\auth\models\PasswordManagement\PasswordChangeForm;
use app\modules\auth\models\PasswordManagement\ResetPasswordToken;

use app\components\SendEmail;

class PasswordManagementController extends Controller
{

    public function actionResetPasswordRequest()
    {
        $model = new PasswordResetRequestForm();

        if(Yii::$app->request->Post('PasswordResetRequestForm'))
        {
            $model->attributes = Yii::$app->request->Post('PasswordResetRequestForm');

            if($model->validate())
            {
                define("EXPIRE_TIME", 30); //время в минутах, после которого токен считается не валидным

                $user = User::findOne(['user_email' => $model->email]);//получаем пользователя по имейлу

                //формирование записи в таблице reset_password_token
                $resetPasswordToken = new ResetPasswordToken();
                $resetPasswordToken->user_id = $user->user_id;
                $resetPasswordToken->token = sha1(mt_rand(10000, 99999).time());//генерация рандомного токена
                $resetPasswordToken->expires = Date('Y-m-d h:i:s', strtotime("+".EXPIRE_TIME." minutes"));

                $resetUrl = Url::base(true).Url::toRoute(['/change-password', 'token' => $resetPasswordToken->token]);

                if($resetPasswordToken->save())
                {
                    SendEmail::sendResetPasswordMail($model->email, $resetUrl);
                }

                return $this->render('ResetSuccess');
            }
        }

        return $this->render('PasswordResetRequestForm', ['model'=>$model]);
    }

    public function actionChangePassword($token = false)
    {
        $message = 'Ваша ссылка восстановления не действительна';

        if($token) //если token получен, то производим восстановление пароля
        {
            $model = new PasswordChangeForm();
            $resetPasswordToken = ResetPasswordToken::findOne(['token' => $token]);
            
            //проверка наличия и валидности токена
            if($resetPasswordToken && ! $resetPasswordToken->expires())
            {
                if(Yii::$app->request->post('PasswordChangeForm'))
                {
                    $model->attributes = Yii::$app->request->post('PasswordChangeForm');

                    if($model->validate())
                    {
                        $model->changeUserPassword($resetPasswordToken);
                        return $this->render('ChangeSuccess');
                    }
                }
                
                return $this->render('PasswordChange', ['model' => $model]);
            }

            $message = 'Срок действия вашей уникальной ссылки истек. Срок действия - 30 минут с момента получения';
        }

        return $this->render('@app/views/site/error', 
            [
                'name'=>'Ошибка валидации', 
                'message'=>$message]
        );
    }

}

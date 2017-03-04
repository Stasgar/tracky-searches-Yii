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
    public function actionChangePassword($token = false)
    {

        if($token) //если token получен, то производим восстановление пароля
        {
            $modelPasswordChange = new PasswordChangeForm();
            $resetPasswordModel = ResetPasswordToken::findOne(['token' => $token]);

            if($resetPasswordModel)
            {
                if($resetPasswordModel->expires > Date('Y-m-d h:i:s'))
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
                    return $this->render('@app/views/site/error', 
                        [
                            'name'=>'Ошибка валидации', 
                            'message'=>'Срок действия вашей уникальной ссылки истек. Срок действия - 30 минут с момента получения.']
                    );
                }
            }
        }

        return $this->render('@app/views/site/error', 
            [
                'name'=>'Ошибка валидации', 
                'message'=>'Ваша ссылка восстановления не действительна.']
        );
    }

    public function actionResetPasswordRequest()
    {
        $model = new PasswordResetRequestForm();

        if(Yii::$app->request->Post('PasswordResetRequestForm'))
        {
            $model->attributes = Yii::$app->request->Post('PasswordResetRequestForm');

            if($model->validate())
            {
                define("EXPIRE_TIME", 30);//время в минутах, после которого токен считается не валидным
                $user = User::findOne(['user_email' => $model->email]);//получаем пользователя по имейлу

                $resetPasswordToken = new ResetPasswordToken();
                $resetPasswordToken->user_id = $user->user_id;
                $resetPasswordToken->token = sha1(mt_rand(10000, 99999).time());//генерация рандомного токена
                $resetPasswordToken->expires = Date('Y-m-d h:i:s', strtotime("+".EXPIRE_TIME." minutes"));

                $resetUrl = Url::base(true).Url::toRoute(['/change-password', 'token' => $resetPasswordToken->token]);

                if($resetPasswordToken->save())
                    SendEmail::sendResetPasswordMail($model->email, $resetUrl);

                return $this->render('ResetSuccess');
            }
        }

        return $this->render('PasswordResetRequestForm', ['model'=>$model]);
    }
}

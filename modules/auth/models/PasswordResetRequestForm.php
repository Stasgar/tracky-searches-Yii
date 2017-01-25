<?php

namespace app\modules\auth\models;

use yii\helpers\Url;
use app\models\User;
use yii\base\Model;
use Yii;

use app\modules\auth\models\ResetPasswordToken;
use himiklab\yii2\recaptcha\ReCaptchaValidator;

class PasswordResetRequestForm extends Model
{
    public $email;
    public $reCaptcha;

    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Введите адрес, на который зарегистрирован аккаунт'],
            ['email', 'email', 'message'=>'Адрес введен не корректно'],
            ['email', 'validateEmail'],
            [['reCaptcha'], ReCaptchaValidator::className(), 'uncheckedMessage' => 'Вы не прошли проверку ReCaptcha']
        ];
    }

    public function validateEmail($attribute)
    {
        $user = User::findOne(['user_email' => $this->email]);

        if(!$user)
        {
            $this->addError($attribute, 'К сожалению мы не нашли пользователя с таким адресом :(');
        }
    }

    public function sendResetLink()
    {
        define("TOKEN_EXPIRE_TIME", 30);//время в минутах, после которого токен считается не валидным
        $user = User::findOne(['user_email' => $this->email]);//получаем пользователя по имейлу

        $reset_password_token = new ResetPasswordToken();
        $reset_password_token->user_id = $user->user_id;
        $reset_password_token->token = sha1(mt_rand(10000, 99999).time());//генерация рандомного токена
        $reset_password_token->expires = date("Y-m-d h:i:s", strtotime("+".TOKEN_EXPIRE_TIME." minutes"));

        $resetUrl = Url::base(true).Url::toRoute(['/change-password', 'token' => $reset_password_token->token]);
        if($reset_password_token->save())
        {            
                try{
                Yii::$app->mailer
                    ->compose('layouts/reset-password',
                        ['resetLink' => $resetUrl]
                    )
                    ->setFrom('email@mail.ru')
                    ->setTo($this->email)
                    ->setSubject('Восстановление пароля tracky-searches.ru')
                    ->send();
                }
                catch(\Swift_TransportException $e)
                {
                    echo "К сожалению мы не смогли отправить сообщение на указанный адрес.";
                    echo $e->getMessage();die;
                }
        }

    }

}
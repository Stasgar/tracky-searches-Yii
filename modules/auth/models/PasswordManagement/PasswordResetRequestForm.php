<?php

namespace app\modules\auth\models\PasswordManagement;

use yii\helpers\Url;
use app\models\User;
use yii\base\Model;
use Yii;

use app\modules\auth\models\PasswordManagement\ResetPasswordToken;
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

}
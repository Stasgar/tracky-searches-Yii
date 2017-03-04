<?php

namespace app\modules\auth\models\PasswordManagement;

use app\models\User;
use yii\base\Model;

use app\modules\auth\models\PasswordManagement\ResetPasswordToken;

class PasswordChangeForm extends Model
{
    public $password;
    public $repeat_password;

    public function rules()
    {
        return [
            [['password', 'repeat_password'], 'required', 'message' => 'Не все поля заполнены'],
            [
                ['password','repeat_password'],
                'match',
                'pattern'=>'/^[A-Za-z0-9]{6,32}$/',
                'message'=>'Пароль может содержать от 6-ти до 32-х символов латинского алфавита и цифры.'
            ],
            [
                'repeat_password',
                'compare',
                'compareAttribute'=>'password',
                'message'=>'Пароли не совпадают'
            ],
        ];
    }

    public function changeUserPassword($resetPasswordModel)
    {
        $user = User::findOne($resetPasswordModel->user_id);
        $user->user_password = User::hashPassword($this->password);
        $user->update();
        $resetPasswordModel->delete();//удаляем использованный токен
        return true;
    }
}
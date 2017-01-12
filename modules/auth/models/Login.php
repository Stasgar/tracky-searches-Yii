<?php

namespace app\modules\auth\models;

use yii\base\Model;
use app\models\User;

class Login extends Model
{
    public $user_name;
    public $user_password;

    public function rules()
    {
        return[
            [['user_name','user_password'],'required', 'message' => 'Поле не может быть пустым'],
            ['user_name','validateUser']
        ];
    }

    public function getUser()
    {
        return User::findOne(['user_name'=>$this->user_name]);
    }

    /**
    * Метод валидации пользователя. Сравнивает введенные данные и данные в БД
    */
    public function validateUser($attribute)
    {
        $user = $this->getUser();

        if(!$user || ( User::hashPassword($this->user_password) != $user->user_password))
        {
                $this->addError($attribute,'Логин или пароль не верны');
        }
        if($user && $user->user_activated == 0)
        {
            $this->addError($attribute, 'Ваш аккаунт не активирован');
        }
    }
}
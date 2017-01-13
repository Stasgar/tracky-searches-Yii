<?php

namespace app\modules\auth\models;

use app\models\User;
use yii\base\Model;

class Signup extends Model
{
    public $user_name;
    public $user_password;
    public $user_repeat_password;
    public $user_email;
    public $user_authkey;
    public $user_activated;

    public function rules()
    {
        return [
            [
                'user_name', 
                'match', 
                'pattern'=>'/^[A-Za-z0-9_-]{3,16}$/', 
                'message'=>'Логин может состоять из латинских символов, цифр, одинарного дефиса или подчеркивания. Логин должен содержать от 3-х до 16-ти символов'
            ],
            [
                ['user_password','user_repeat_password'],
                'match',
                'pattern'=>'/^[A-Za-z0-9]{6,32}$/',
                'message'=>'Пароль может содержать от 6-ти до 32-х символов латинского алфавита и цифры.'
            ],
            [
                ['user_name','user_password','user_repeat_password','user_email'],
                'required', 
                'message' => 'Поле не может быть пустым',
            ],
            ['user_email', 'email', 'message'=>'Адрес введен не корректно'],
            ['user_repeat_password', 'compare', 'compareAttribute'=>'user_password', 'message'=>'Пароли не совпадают'],
            ['user_name','unique','targetClass'=>'app\models\User', 'message'=>'Имя пользователя занято'],
            ['user_email','unique', 'targetClass'=>'app\models\User', 'message'=>'Пользователь с таким адресом уже зарегистрирован'],
        ];
    }


    /**
    * Метод регистрации. Сравнивает идентичность введенный паролей и производит запись пользователя в БД
    */
    public function signup()
    {
        $user = new User;
        if($this->user_password == $this->user_repeat_password)
        {
            $user->user_name = $this->user_name;
            $user->user_password = User::hashPassword($this->user_password);
            $user->user_email = $this->user_email;
            $user->user_authkey = $this->user_authkey;
        }

        return $user->save();
    }

    /**
    * Метод активации. Производит проверку переданного ключа с тем, что находится в БД
    */
    public function activate($authkey)
    {
        $user = new User;
        if($user->find()->where(['user_authkey'=>$authkey])->exists())
        {
            $user = $user->find()->where(['user_authkey'=>$authkey])->one();
            $user->user_activated = true;
            $user->save();
            return true;
        }
        else
        return false;

    }
}
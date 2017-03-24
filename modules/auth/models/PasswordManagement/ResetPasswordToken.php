<?php

namespace app\modules\auth\models\PasswordManagement;

use app\models\User;
use Yii;

/**
 * This is the model class for table "reset_password_token".
 *
 * @property integer $reset_password_token_id
 * @property integer $user_id
 * @property string $token
 * @property string $expires
 */
class ResetPasswordToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reset_password_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'token'], 'required'],
            [['user_id'], 'integer'],
            [['expires'], 'safe'],
            [['token'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reset_password_token_id' => 'Reset Password Token ID',
            'user_id' => 'User ID',
            'token' => 'Token',
            'expires' => 'Expires',
        ];
    }

    /*
        Возвращает true, если время действия токена истекло
    */
    public function expires()
    {
        $currentDate = Date('Y-m-d h:i:s');
        $expiresDate = $this->expires;
        if( $expiresDate < $currentDate )
        {
            return true;
        }

        return false;
    }

    //формирование записи в таблице reset_password_token
    public function createTokenForUser(User $user)
    {
        define("EXPIRE_TIME", 30); //время в минутах, после которого токен считается не валидным

        $this->user_id = $user->user_id;
        $this->token = sha1(mt_rand(10000, 99999).time());//генерация рандомного токена
        $this->expires = Date('Y-m-d h:i:s', strtotime("+".EXPIRE_TIME." minutes"));

        if($this->save())
        {
            return true;
        }

        return false;
    }

}

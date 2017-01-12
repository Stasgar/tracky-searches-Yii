<?php

namespace app\models;

use app\modules\tracking\models\Chat;
use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $user_name
 * @property string $user_password
 * @property string $user_email
 * @property string $user_role
 * @property integer $user_ban_status
 * @property string $user_avatar
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'user_password', 'user_email'], 'required'],
            [['user_ban_status'], 'integer'],
            [['user_name', 'user_password', 'user_avatar'], 'string', 'max' => 256],
            [['user_role'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'user_password' => 'User Password',
            'user_email' => 'User Email',
            'user_role' => 'User Role',
            'user_ban_status' => 'User Ban Status',
            'user_avatar' => 'User Avatar',
        ];
    }


    /**
     * Хэширует пароль
     */
    public static function hashPassword($password)
    {
        return hash('ripemd128',$password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUserName($user_name)
    {
        return static::find()->where(['user_name'=>$user_name])->one();
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->user_id;
    }

    public function getAuthKey()
    {
        return $this->user_authkey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

}

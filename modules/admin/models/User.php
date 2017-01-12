<?php

namespace app\modules\admin\models;

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
 * @property string $reg_time
 * @property string $user_authkey
 * @property integer $user_activated
 *
 * @property Chat[] $chats
 */
class User extends \yii\db\ActiveRecord
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
            [['user_ban_status', 'user_activated'], 'integer'],
            [['reg_time'], 'safe'],
            [['user_name', 'user_password', 'user_email', 'user_avatar', 'user_authkey'], 'string', 'max' => 256],
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
            'reg_time' => 'Reg Time',
            'user_authkey' => 'User Authkey',
            'user_activated' => 'User Activated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['user_id' => 'user_id']);
    }
}

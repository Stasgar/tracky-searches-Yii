<?php

namespace app\modules\auth\models\PasswordManagement;

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
}

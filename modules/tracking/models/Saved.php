<?php

namespace app\modules\tracking\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "saved".
 *
 * @property integer $track_id
 * @property integer $user_id
 * @property string $track_value
 * @property string $datetime
 */
class Saved extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'saved';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'track_value'], 'required'],
            [['user_id'], 'integer'],
            [['datetime'], 'safe'],
            [['track_value'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'track_id' => 'Track ID',
            'user_id' => 'User ID',
            'track_value' => 'Track Value',
            'datetime' => 'Datetime',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['track_id'=>'user_id']);
    }

    public static function getSaved()
    {
        if( !Yii::$app->user->isGuest )
            return self::find()->where(['user_id' => Yii::$app->user->identity->user_id])->all();
        else
            return false;
    }
}

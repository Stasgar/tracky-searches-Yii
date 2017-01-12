<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property integer $message_id
 * @property integer $parent_id
 * @property integer $reply_id
 * @property integer $user_id
 * @property string $message_text
 * @property integer $pos_rating
 * @property integer $neg_rating
 * @property string $datetime
 *
 * @property User $user
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'pos_rating', 'neg_rating'], 'integer'],
            [['user_id', 'message_text'], 'required'],
            [['datetime'], 'safe'],
            [['message_text'], 'string', 'max' => 256],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'message_id' => 'Message ID',
            'user_id' => 'User ID',
            'message_text' => 'Message Text',
            'pos_rating' => 'Pos Rating',
            'neg_rating' => 'Neg Rating',
            'datetime' => 'Datetime',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'user_id']);
    }
}

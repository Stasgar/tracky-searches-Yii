<?php

namespace app\modules\tracking\models;

use app\models\User;
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
 * @property integer $message_count
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
            [['message_text', 'user_id'], 'required', 'message' => 'Поле не может быть пустым'],
            [['user_id', 'pos_rating', 'neg_rating'], 'integer'],
            [['datetime'], 'safe'],
            [['message_text'], 'string', 'max' => 256],
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
    * Получение последних сообщений из чата
    * @num - кол-во сообщений
    */
    public function getLastMessages($num)
    {
        return $this->find()->with('user')->orderBy(['message_id' => SORT_DESC])->limit($num)->all();
    }

    /**
    * Метод возвращает разницу между последним сообщением в чате у пользователя, и последним в БД
    * нужен для обновления данных на клиенте
    */
    public function getNewMessagesCount($last_message_id)
    {
        $message = $this->find()->orderBy(['message_id' => SORT_DESC])->one();

        return $message->message_id - $last_message_id;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(),['user_id'=>'user_id']);
    }

}
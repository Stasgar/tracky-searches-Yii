<?php
namespace app\modules\user\models;

use app\models\User;
use Yii;

class UserSettings extends \yii\base\Model
{

    public $imageFile;

    public function rules()
    {
        return[
            ['imageFile', 'file', 'skipOnEmpty'=>false, 'extensions'=> 'png, jpg, jpeg', 'maxSize' => 5000*1024],
        ];
    }

    public function uploadImage()
    {
        define('DEFAULT_AVATAR_NAME', 'default.jpg');
        if($this->validate())
        {
            $modelUser = new User;
            $userName = Yii::$app->user->identity->user_name;
            if(Yii::$app->user->identity->user_avatar !== DEFAULT_AVATAR_NAME)
            {
                $oldAvatar = 'storage/avatars/'.Yii::$app->user->identity->user_avatar;
                unlink($oldAvatar);
            }

            $this->imageFile
                ->saveAs('storage/avatars/' . $this->formFileName($userName) . '.' . 'jpg');

            $modelUser = $modelUser
                ->findOne(['user_name' => $userName]);
            $modelUser->user_avatar = $this->formFileName($userName). '.' . 'jpg';

            if($modelUser->save())
            {
                return true;
            }
        }
        
            return false;
    }

    /**
    * Формирует имя файла:ник пользователя + дата, и возвращает в виде хэша
    * требуется, чтобы обойти кеширование изображений браузерами, и всегда выводить
    * актуальное изображение профиля
    */
    public static function formFileName($user_name)
    {
        return hash('ripemd128',$user_name.date("Y-m-d H:i:s"));
    }

}
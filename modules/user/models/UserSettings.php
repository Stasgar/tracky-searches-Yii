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
        define('AVATARS_PATH', 'storage/avatars/');

        if($this->validate())
        {
            $currentUser = Yii::$app->user->identity;

            $curUserAvatar = $currentUser->user_avatar;
            
            if($curUserAvatar !== DEFAULT_AVATAR_NAME)
            {
                $oldAvatarFile = 'storage/avatars/' . $curUserAvatar;
                unlink($oldAvatarFile);
            }

            $curUserName = $currentUser->user_name;

            $newAvatarFileName = $this->formFileName($curUserName) . '.' . 'jpg';
            $this->imageFile->saveAs(AVATARS_PATH . $newAvatarFileName);

            $modelUser = User::findOne(['user_name' => $curUserName]);
            $modelUser->user_avatar = $this->formFileName($curUserName). '.' . 'jpg';

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
<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\base\Widget;
use Yii;

class AvatarWidget extends Widget
{
    public $avatarHtml;
    public $avatarName = false;
    public $size = '16px';

    public function init()
    {
        parent::init();
        if($this->avatarName === false)
        {
            $this->avatarHtml = '<img style="border-radius:50%" width='.$this->size.'px height='.$this->size.'px src="' .'/storage/avatars/' . Yii::$app->user->identity->user_avatar . '" class="user-avatar">';
        }
        else
        {
            $this->avatarHtml =  '<img style="border-radius:50%" width='.$this->size.'px height='.$this->size.'px src="' .'/storage/avatars/' . $this->avatarName . '" class="user-avatar">';
        }


    }

    public function run()
    {
        parent::run();
        return $this->avatarHtml;
    }
}
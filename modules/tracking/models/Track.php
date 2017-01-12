<?php

namespace app\modules\tracking\models;

use app\modules\tracking\classes\SearchTrack;
use Yii;

class Track extends \yii\base\Model
{
    public $trackNumber;

    public function rules()
    {
        return [
            ['trackNumber','required', 'message' => 'Для начала введите трек-номер отправления'],
            ['trackNumber', 'isAvailable'],
        ];
    }

    public function searchForInfo()
    {
        Yii::info('searchForInfo() initialized with track:' . $this->trackNumber);
        $searchTrack = new SearchTrack();
       
        $searchResults = $searchTrack->start($this->trackNumber);
       

        Yii::info('searchForInfo[2], info:' . json_encode($searchResults));
        return $searchResults;
        
    }

    /**
    * Метод, используемый в правилах валидации.
    * Определяет, имеет ли система метод для отслеживания такого типа трека
    */
    public function isAvailable($attributes)
    {
        $searchTrack = new SearchTrack();
        $availablePosts = $searchTrack->posts;
        $type = substr($this->trackNumber, strlen($this->trackNumber)-2, 2);

        if(!in_array($type, $availablePosts))
        {
            $this->addError($attributes, 'К сожалению данный тип трек-номера не поддерживается нашей системой');
        }

    }
}

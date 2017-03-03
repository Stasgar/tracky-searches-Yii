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

        $searchTrack = new SearchTrack($this->trackNumber);
        $searchResults = $searchTrack->getParcelInfo();

        return $searchResults;
        
    }

    /**
    * Метод, используемый в правилах валидации.
    * Определяет, имеет ли система метод для отслеживания такого типа трека
    */
    public function isAvailable($attributes)
    {
        $searchTrack = new SearchTrack($this->trackNumber);
        if( !$searchTrack->isAvailable() )
        {
            $this->addError($attributes, 'К сожалению данный тип трек-номера не поддерживается нашей системой');
        }

    }
}

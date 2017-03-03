<?php
namespace app\modules\tracking\classes;

use app\modules\tracking\classes\ServiceFI;
use app\modules\tracking\classes\ServiceNL;
use app\modules\tracking\classes\ServiceSG;

use Yii;

/*
    Класс модифицированный Context (Strategy pattern).
    Используется для получения информации о почтовом управлении.
*/
class SearchTrack
{
    // непосредственно текстовое значение "трек-номера"
    private $track_number;

    public function __construct($track_number)
    {
        $this->track_number = $track_number;
    }

    /*
        Метод проверяет существует ли стратегия для данного типа трек-номера.
    */
    public function isAvailable()
    {
        $type = $this->getType(); // get type

        if(!class_exists($this->getServiceName())) //check if service exists
        {
            return false;
        }

        return true;
    }

    /**
    * Метод, используется для поиска информации по предоставленному трек-номеру.
    * Используется идентификатор отпарвления (track_number), переданный в конструкторе.
    * Результат возвращается в виде массива PHP 
    */
    public function getParcelInfo()
    {

        if($this->isAvailable())
        {
            $serviceName = $this->getServiceName();
            $service = new $serviceName();
            $result = $this->getArrayInfo($service);
            return $result;
        }

        return false;
        
    }

    /*
        Метод для непосредственного поиска информации об отправлении по предоставленному алгоритму
    */
    private function getArrayInfo(AbstractPostService $service)
    {
        return $service->getResult($this->track_number);
    }

    /*
        Метод для определения типа отправления.
        Может быть расширен при добавлении нового типа трека.
        На данный момент тип получается путем получения двух последних символов:
        ***FI - тип "FI" и т.д.
    */
    private function getType()
    {
        //return 2 last characters of the track number
        return substr($this->track_number, strlen($this->track_number)-2, 2);
    }

    /*
        Метод для получения полного имени класса сервиса (алгоритма).
    */
    private function getServiceName()
    {
        $type = $this->getType();
        $serviceName = '\Service'.$type;
        $serviceModel = __NAMESPACE__.$serviceName;
        return $serviceModel;
    }

}

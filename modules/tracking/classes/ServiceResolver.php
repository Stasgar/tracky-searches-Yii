<?php
namespace app\modules\tracking\classes;

class ServiceResolver
{
    private $track_number;

    public function __construct($track_number)
    {
        $this->track_number = $track_number;
    }
    /*
        Метод проверяет существует ли сервис для данного типа трек-номера.
    */
    public function isServiceAvailable()
    {
        $type = $this->getType();

        if(!class_exists($this->getServiceName()))
        {
            return false;
        }

        return true;
    }

    /*
        Метод для получения полного имени класса сервиса (алгоритма).
    */
    public function getService()
    {
        $type = $this->getType();
        $serviceName = '\services\Service'.$type;
        $serviceModel = __NAMESPACE__.$serviceName;
        return new $serviceModel;
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
        $serviceName = '\services\Service'.$type;
        $serviceModel = __NAMESPACE__.$serviceName;
        return $serviceModel;
    }
}
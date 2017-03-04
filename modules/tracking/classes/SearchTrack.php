<?php
namespace app\modules\tracking\classes;

use app\modules\tracking\classes\ServiceResolver;

use Yii;

/*
    Используется для получения информации о почтовом управлении.
*/
class SearchTrack
{
    // непосредственно текстовое значение "трек-номера"
    private $track_number;
    private $serviceResolver;

    public function __construct($track_number)
    {
        $this->track_number = $track_number;
        $this->serviceResolver = new ServiceResolver($track_number);
    }

    public function isAvailable()
    {
        return $this->serviceResolver->isServiceAvailable();
    }

    /**
    * Метод, используется для поиска информации по предоставленному трек-номеру.
    * Используется идентификатор отпарвления (track_number), переданный в конструкторе.
    * Результат возвращается в виде массива PHP 
    */
    public function getParcelInfo()
    {

        if($this->serviceResolver->isServiceAvailable())
        {
            //$serviceName = $this->serviceResolver->getServiceName();
            $service = $this->serviceResolver->getService();
            $result = $this->getArrayInfo($service);
            return $result;
        }

        return false;
        
    }

    /*
        Метод для непосредственного поиска информации об отправлении по предоставленному алгоритму
    */
    private function getArrayInfo(ServiceInterface $service)
    {
        return $service->getResult($this->track_number);
    }

}

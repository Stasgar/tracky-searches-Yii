<?php
namespace app\modules\tracking\classes;

use app\modules\tracking\classes\ServiceFI;
use app\modules\tracking\classes\ServiceNL;
use app\modules\tracking\classes\ServiceSG;

class SearchTrack
{
    
    public $availableServices = Array('FI', 'SG', 'NL');

    /**
    * Метод, используется для поиска информации по предоставленному трек-номеру.
    * @track_number - текстовое значение, идентифицирующее почтовое отправление
    * Результат возвращается в виде массива PHP 
    */
    public function getParcelInfo($track_number)
    {
        //$this->track = $track_number;
        //вырезает последние два символа из предоставленного трека
        $type = substr($track_number, strlen($track_number)-2, 2); 
        
        $serviceName = 'Service'.$type;
        $serviceModel = 'app\\modules\\tracking\\classes\\'.$serviceName;
        $service = new $serviceModel;

        $result = $this->getArrayInfo($service, $track_number);
        return $result;
    }

    public function getArrayInfo(AbstractPostService $service, $track_number)
    {
        return $service->getResult($track_number);
    }
        
}

?>
<?php
namespace app\modules\tracking\classes\services;

use app\modules\tracking\classes\ServiceInterface;
use app\modules\tracking\classes\ParseHelper;
use app\modules\tracking\classes\Translator;

/*
    Класс-алгоритм, используемый для поиска информации для треков с типом "FI"(финляндия)
*/
class ServiceFI implements ServiceInterface
{
    public function getResult($track)
    {
        $url = 'http://www.posti.fi/henkiloasiakkaat/seuranta/api/shipments/'.$track;
        $data = json_decode(ParseHelper::parse_get($url), true);

        if(isset($data['shipments'][0]['events']))
            $items = $data['shipments'][0]['events'];
        else
            return false;

        $result = array(
            'track_num' => $data['shipments'][0]['trackingCode'],
            'track_info' => array(
                'target' => $data['shipments'][0]['destinationPostcode'].', '.$data['shipments'][0]['destinationCountry'],
                'service' => $data['shipments'][0]['extraServices'][0]['en'],
                'type' => $data['shipments'][0]['product']['en']
            ),
            'track_status' => array()
        );
        for ($i = count($items)-1; $i >= 0; $i--){
            $result['track_status'][] = array(
                'status-en' => $items[$i]['description']['en'],
                'status-ru' =>Translator::translateText($items[$i]['description']['en']),
                'time' => date('Y-m-d H:i:s', strtotime($items[$i]['timestamp'])),
                'place' => $items[$i]['locationName'].' '.$items[$i]['locationCode']
            );
        }
        return $result;
    }
}

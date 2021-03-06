<?php
namespace app\modules\tracking\classes\services;

use app\modules\tracking\classes\ServiceInterface;
use app\modules\tracking\classes\ParseHelper;
use app\modules\tracking\classes\Translator;

/*
    Класс-алгоритм, используемый для поиска информации для треков с типом "NL"(нидерланды)
*/
class ServiceNL implements ServiceInterface
{
    public function getResult($track)
    {
        $url = 'http://postnl.post/details/';
        $params = array('barcodes' => $track);
        $html = ParseHelper::parse_post($url, $params);
        $result = array(
            'track_num' => $track,
            'track_status' => array()
        );
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_use_internal_errors(false);
        $table = $doc->getElementsByTagName('tbody');
        $i = 0;

        if(null === ($table->item(0)))
            return false;

        foreach($table->item(0)->getElementsByTagName('tr') as $tr){
            foreach($tr->getElementsByTagName('td') as $td){
                $data[$i][] = htmlentities(utf8_decode($td->nodeValue), ENT_QUOTES, 'UTF-8');
            }
            $i++;
        }
        for ($i = count($data)-1; $i >= 0; $i--){
            $result['track_status'][] = array(
                'status-en' => $data[$i][1],
                'status-ru' => Translator::translateText($data[$i][1]),
                'time' =>  date('Y-m-d H:i:s', strtotime($data[$i][0]))
            );
        }
        return $result;
    }
}

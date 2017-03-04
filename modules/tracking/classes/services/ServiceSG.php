<?php
namespace app\modules\tracking\classes\services;

use app\modules\tracking\classes\ServiceInterface;
use app\modules\tracking\classes\ParseHelper;
use app\modules\tracking\classes\Translator;
use DOMDocument;

/*
    Класс-алгоритм, используемый для поиска информации для треков с типом "SG"(сингапур)
*/
class ServiceSG implements ServiceInterface
{
    public function getResult($track)
    {
        $url = 'http://www.singpost.com/track-items';
        $params = array(
            'track_number' => $track,
            'captoken' => '',
            'op' => 'Check item status'
        );
        $html = ParseHelper::parse_post($url, $params);
        $result = array(
            'track_num' => $track,
            'track_status' => array()
        );
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($html);
        libxml_use_internal_errors(false);
        $table = $doc->getElementsByTagName('tbody');
        $i = 0;
        foreach($table->item(1)->getElementsByTagName('tr') as $tr){
            foreach($tr->getElementsByTagName('td') as $td){
                $data[$i][] = htmlentities(utf8_decode($td->nodeValue), ENT_QUOTES, 'UTF-8');
            }
            $i++;
        }
        for ($i = count($data)-1; $i >= 0; $i--){
            $result['track_status'][] = array(
                'status-en' => trim($data[$i][1]),
                'status-ru' => Translator::translateText(trim($data[$i][1])),
                'time' => trim($data[$i][0])
            );
        }

        if($result["track_status"][0]["status-en"] == '')
        {
            return false;
        }
        return $result;
    }
}

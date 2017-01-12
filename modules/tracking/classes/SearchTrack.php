<?php
namespace app\modules\tracking\classes;
use DOMDocument;

class SearchTrack
{
    public $track;
    
    public $posts = Array('FI', 'SG', 'NL');

    /**
    * Метод, используется для поиска информации по предоставленному трек-номеру.
    * @track_number - текстовое значение, идентифицирующее почтовое отправление
    * Результат возвращается в виде массива PHP 
    */
    public function start($track_number)
    {
        $this->track = $track_number;
        $type = substr($this->track, strlen($this->track)-2, 2);
        $result = $this->$type();
        return $result;
    }

    public function FI()
    {
        $url = 'http://www.posti.fi/henkiloasiakkaat/seuranta/api/shipments/'.$this->track;
        $data = json_decode($this->parse_get($url), true);

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
                'status-ru' =>self::translateText($items[$i]['description']['en']),
                'time' => date('Y-m-d H:i:s', strtotime($items[$i]['timestamp'])),
                'place' => $items[$i]['locationName'].' '.$items[$i]['locationCode']
            );
        }
        return $result;
    }

    public function NL()
    {
        $url = 'http://postnl.post/details/';
        $params = array('barcodes' => $this->track);
        $html = $this->parse_post($url, $params);
        $result = array(
            'track_num' => $this->track,
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
                'status-ru' => self::translateText($data[$i][1]),
                'time' =>  date('Y-m-d H:i:s', strtotime($data[$i][0]))
            );
        }
        return $result;
    }

    public function SG(){
        $url = 'http://www.singpost.com/track-items';
        $params = array(
            'track_number' => $this->track,
            'captoken' => '',
            'op' => 'Check item status'
        );
        $html = $this->parse_post($url, $params);
        $result = array(
            'track_num' => $this->track,
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
                'status-ru' => self::translateText(trim($data[$i][1])),
                'time' => trim($data[$i][0])
            );
        }

        if($result["track_status"][0]["status-en"] == '')
        {
            return false;
        }
        return $result;
    }

    //Метод для парсинга пост-запросом
    public function parse_post($url, $params){
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
            $out = curl_exec($curl);
            curl_close($curl);
            return $out;
        }
    }

    //Метод для парсинга гет-запросом
    public function parse_get($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }

    //метод для перевода, используется google api
    public static function translateText($text)
    {

        $text = rawurlencode($text);
        $apiKey = 'AIzaSyCux5r82Jm1WK3H1Iu-thUb15cSkg90fF4';
        $apiLink = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='.$text.'&source=en&target=ru';

        $response = file_get_contents($apiLink);
        if(isset(json_decode($response)->data->translations[0]->translatedText))
            return json_decode($response)->data->translations[0]->translatedText;
        else
            return "";

    }
}

?>
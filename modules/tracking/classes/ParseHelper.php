<?php
namespace app\modules\tracking\classes;

class ParseHelper
{
    //Метод для парсинга пост-запросом
    public static function parse_post($url, $params){
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
    public static function parse_get($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        curl_close($curl);
        return $out;
    }
}
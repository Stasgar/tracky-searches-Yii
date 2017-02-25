<?php
namespace app\modules\tracking\classes;

abstract class AbstractPostService
{
    abstract public function getResult($track); //вернуть результат в виде массива

    //метод для перевода статуса, используется google api
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
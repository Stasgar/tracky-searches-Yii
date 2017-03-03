<?php
namespace app\modules\tracking\classes;
use Yii;

abstract class AbstractPostService
{
    /*
        Абстрактный метод, возвращаемое значение - массив с данными об отправлении.
    */
    abstract public function getResult($track);

    /*
        Метод для перевода статуса, используется google api.
    */
    public static function translateText($text)
    {
        $text = rawurlencode($text);
        $apiKey = Yii::$app->params['googleTranslate']['key'];
        $apiLink = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='.$text.'&source=en&target=ru';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiLink);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $rawResponse = curl_exec($curl);
        curl_close($curl);

        $response = json_decode($rawResponse);

        if(isset($response->data->translations[0]->translatedText))
        {
            return $response->data->translations[0]->translatedText;
        }
        else
        {
            return '-';
        }

    }

}
<?php
namespace app\modules\tracking\classes;

use app\modules\tracking\classes\ParseHelper;

use Yii;

class Translator
{
    /*
        Метод для перевода статуса, используется google api.
    */
    public static function translateText($text)
    {

        if(Yii::$app->params['googleTranslate']['active'] == false)
        {
            return '-';
        }

        $text = rawurlencode($text);
        $apiKey = Yii::$app->params['googleTranslate']['key'];
        $apiLink = 'https://www.googleapis.com/language/translate/v2?key='.$apiKey.'&q='.$text.'&source=en&target=ru';
        $rawResponse = ParseHelper::parse_get($apiLink);

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
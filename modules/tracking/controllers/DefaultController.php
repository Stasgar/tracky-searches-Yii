<?php

namespace app\modules\tracking\controllers;
use yii\web\Controller;

use app\modules\tracking\models\Track;
use app\modules\tracking\models\Saved;
use app\modules\tracking\models\Chat;
use Yii;

/**
 * Default controller for the `tracking` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($track = false)
    {

        Yii::$app->view->registerMetaTag(
            ['name' => 'keywords', 'content' => 'Почтовое, отправление, посылка, трек-номер']
        );
        Yii::$app->view->registerMetaTag(
            [
                'name' => 'description', 
                'content' => 'Tracky-Searches - это онлайн сервис отслеживания почтовых отправлений'
            ]
        );
        
        $data = Array();

        $modelChat = new Chat();
        $modelTrack = new Track();
        $modelSaved = new Saved();

        //стандартные параметры для вывода кол-ва сообщений
        $message_count = 5;
        $last_message_id = 0;

        //Если у пользователя имеются свои параметры
        if (isset($_COOKIE["message_count"]))
            $message_count = $_COOKIE["message_count"];

        if (isset($_COOKIE["last_message_id"]))
            $last_message_id = $_COOKIE["last_message_id"];

        // При получении запроса из формы отслеживания посылки
        if(Yii::$app->request->post('Track') || $track !== false)
        {
            //проверяем, трек пришел из get или post запроса, и устанавливаем соответственно
            if($track !== false && !Yii::$app->request->post('Track'))
                $modelTrack->trackNumber = $track;
            else
                $modelTrack->attributes = Yii::$app->request->post('Track');

            Yii::info('TRACK_NUMBER_GET2: '.$modelTrack->trackNumber);// логирование
            
            if($modelTrack->validate())
            {
                $data['savedStatus'] = null;
                if(!Yii::$app->user->isGuest)
                {
                    $user_id = Yii::$app->user->identity->user_id;
                    if(Saved::find()->where(['track_value' => $modelTrack->trackNumber, 'user_id'=>$user_id])->one())
                    {
                        $data['savedStatus'] = true;
                    }
                    else
                    {
                        $data['savedStatus'] = false;
                    }
                }

                $data['trackInfo'] = Yii::$app->cache->get($modelTrack->trackNumber);
                if($data['trackInfo'] === false)// логика кэширования
                {
                    // обновляем информацию по треку, т.к. переменная не найдена в кэше,
                    // и сохраняем в кэш на 4 часа для дальнейшего использования:
                    define('HOURS_4_IN_SECONDS', 14400);
                    Yii::$app->cache->set($modelTrack->trackNumber,$modelTrack->searchForInfo(), HOURS_4_IN_SECONDS);
                    $data['trackInfo'] = $modelTrack->searchForInfo();
                }
            }
        }

        // при получении запроса из формы чата
        if(Yii::$app->request->post('Chat'))
        {
                $message_count = (null !== Yii::$app->request->post('message_count'))? Yii::$app->request->post('message_count') : 5;
                   
                $modelChat->attributes = Yii::$app->request->post('Chat');
                $modelChat->user_id = Yii::$app->user->identity->user_id;
                if(Yii::$app->user->identity->user_ban_status == 0)
                {
                    $modelChat->save();
                }
                
        }
        
        // -чат- Производим действия по формированию данных о сообщениях
        $new_messages_count = $modelChat->getNewMessagesCount($last_message_id);
        $message_count += $new_messages_count;
        $data['chatData'] = $modelChat->getLastMessages($message_count);
        
        $data['modelTrack'] = $modelTrack;
        $data['modelChat'] = $modelChat;
        $data['savedList'] = Saved::getSaved();
        $data['modelSaved'] = $modelSaved;

        return $this->render('index',$data);
    }


    /**
    * Метод, который производит запись трек-номера в БД в соответствии с пользователем
    */
    public function actionSavetrack($trackNumber = false)
    {
        $model = new Saved();

        if($trackNumber)
        {
            $model->track_value = $trackNumber;
            $model->user_id = Yii::$app->user->identity->user_id;

            return $model->save();
        }
    }

    /**
    * Метод, удаляющий сохраненный ранее трек-номер из БД
    */
    public function actionDeletetrack($id = false)
    {   
        if($id)
        {
            Saved::findOne($id)->delete();
            $savedList = Saved::getSaved();
            return $this->renderAjax('savedTable', ['savedList' => $savedList]);
        }
    }

    /**
    * Метод, добавляющий сообщение в БД (чата)
    */
    public function actionAddmessage()
    {
        $model = new Chat();

        if(Yii::$app->request->post('Chat'))
        {
            if(Yii::$app->user->identity->user_ban_status == 0)
            {
                $model->attributes = Yii::$app->request->post('Chat');
                $model->save();
            }
            
        }
    }

    /**
    * Отладочный метод, возвращающий последние 5 сообщений из чата
    */
    public function actionGetmessage()
    {
        $model = new Chat();
        echo '<pre>';
        foreach($model->getLastMessages() as $message)
        {
            print_r($message);
        }
    }

}

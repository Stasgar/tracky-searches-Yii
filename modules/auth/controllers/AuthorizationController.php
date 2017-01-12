<?php

namespace app\modules\auth\controllers;
use yii\web\Controller;

use app\models\User;
use app\modules\auth\models\Signup;
use app\modules\auth\models\Login;
use yii\helpers\Url;
use Yii;

/**
 * Default controller for the `auth` module
 */
class AuthorizationController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->goHome();
    }

    public function actionAuthorize()
    {
        
        $modelLogin = new Login();
        $modelSignup = new Signup();

        $tab = false;

        // При получении запроса на вход
        if(Yii::$app->request->post('Login'))
        {
            $modelLogin->attributes = Yii::$app->request->post('Login');
            
            $tab='#login';//which tab to open

            //При удачной авторизации производится переход на главную страницу
            if($modelLogin->validate())
            {
                Yii::$app->user->login($modelLogin->getUser());
                return $this->goHome();
            }
        }

        // При получении запроса на регистрацию
        $authurl = 'empty_url';
        if(Yii::$app->request->post('Signup'))
        {
            $modelSignup->attributes = Yii::$app->request->post('Signup');
            $modelSignup->user_authkey=sha1(mt_rand(10000, 99999).time().$modelSignup->user_email);

            $tab='#signup';//which tab to open
            if($modelSignup->validate() && $modelSignup->signup())
            {
                $authurl = Url::base(true).Url::to(['authorization/activation','authkey'=>$modelSignup->user_authkey]);

                try{
                Yii::$app->mailer
                    ->compose('layouts/activate-account',
                        [
                            'userName' => $modelSignup->user_name,
                            'authLink' => $authurl,
                        ]
                    )
                    ->setFrom('your-email')
                    ->setTo($modelSignup->user_email)
                    ->setSubject('Подтверждение аккаунта tracky-searches.ru')
                    ->send();
                }
                catch(\Swift_TransportException $e)
                {
                    echo "К сожалению мы не смогли отправить сообщение на указанный адрес.";
                }

                return Yii::$app->response->redirect(Url::to(['success']));
            }
        }
        
        return $this->render( 'authorize', 
            [
                'modelLogin'=>$modelLogin, 
                'modelSignup'=>$modelSignup, 
                'authurl'=>$authurl,
                'tab' => $tab
            ]
        );

    }

    /**
    * Действие, которое производит выход из учетной записи
    */
    public function actionLogout()
    {
        if(!Yii::$app->user->isGuest)
        {
            Yii::$app->user->logout();
            return $this->goHome();
        }
    }

    /**
    * Страница, на которой производится активация аккаунта по ключу
    * @authKey - ключ активации, который получает пользователь после регистрации
    */
    public function actionActivation($authkey)
    {
        $model = new Signup();

        $status = $model->activate($authkey);

        return $this->render('activation',['status'=>$status]);
    }

    /**
    * Страница с информацией об удачной регистрации
    */
    public function actionSuccess()
    {
        return $this->render('success');
    }
       
}

<?php

namespace app\modules\auth\controllers;
use yii\web\Controller;

use app\modules\auth\models\authorization\SignupForm;
use app\modules\auth\models\authorization\LoginForm;
use yii\helpers\Url;
use app\models\User;
use Yii;

use app\components\SendEmail;

/**
 * Default controller for the `auth` module
 */
class AuthorizationController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
            'class' => \yii\filters\AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['index', 'authorize', 'activation', 'success'],
                    'allow' => true,
                    'roles' => ['?']
                ],
                [
                    'actions' => ['logout'],
                    'allow' => true,
                    'roles' => ['@']
                ],

            ],
            ]
        ];
    }

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
        
        $modelLogin = new LoginForm();
        // При получении запроса на вход
        if(Yii::$app->request->post('LoginForm'))
        {
            $modelLogin->attributes = Yii::$app->request->post('LoginForm');
            
            //При удачной авторизации производится переход на главную страницу
            if($modelLogin->validate())
            {
                Yii::$app->user->login($modelLogin->getUser());
                return $this->goHome();
            }
        }

        $modelSignup = new SignupForm();
        // При получении запроса на регистрацию
        $authurl = 'empty_url';
        if(Yii::$app->request->post('SignupForm'))
        {
            $modelSignup->attributes = Yii::$app->request->post('SignupForm');
            $modelSignup->user_authkey=sha1(mt_rand(10000, 99999).time().$modelSignup->user_email);

            if($modelSignup->validate() && $modelSignup->signup())
            {
                $authurl = Url::base(true).Url::to(['authorization/activation','authkey'=>$modelSignup->user_authkey]);

                SendEmail::sendActivationMail($modelSignup->user_name, $modelSignup->user_email, $authurl);

                return Yii::$app->response->redirect(Url::to(['success']));
            }
        }
        
        return $this->render( 'authorize', 
            [
                'modelLogin'=>$modelLogin, 
                'modelSignup'=>$modelSignup,
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
        $model = new SignupForm();

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

<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class AdminBehavioursController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
            'class' => \yii\filters\AccessControl::className(),
            'rules' => [
                // deny all POST requests
                [
                    'allow' => true,
                    'roles' => ['admin']
                ],
            ],
            ]
        ];
    }
}

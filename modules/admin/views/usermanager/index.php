<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление пользователями';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'user_id',
            'user_name',
            //'user_password',
            'user_email:email',
            //'user_role',
            'user_ban_status',
            // 'user_avatar',
            'reg_time',
            // 'user_authkey',
            'user_activated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

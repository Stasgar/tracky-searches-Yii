<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\Url;

    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/chat.js');
?>

<div class="chat-body">

    <div class="panel panel-default" >
        <div class="panel-heading">
                <p>Онлайн чат</p>
        </div>   
        
        <div class="panel-body " style="max-height:500px;overflow-y:scroll">
            
            <?php Pjax::begin(['options' => ['id' => 'chat-pjax']]); ?>

            <?php foreach($chatData as $message): ?>
                    <?php $bubbleClass = (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_id == $message->user->user_id)? 'message-bouble-mine' : 'message-bouble'; ?>
                <div class="message <?= $bubbleClass ?>" id="<?= $message->message_id ?>">
                <p>
                <?= Html::showUserAvatar(40, $message->user->user_avatar) ?>
                <a class="chat-username" href="<?= Url::toRoute(['/user/'.$message->user->user_name]) ?>"><?= Html::encode($message->user->user_name) ?></a>
                <sup class="datatime-chat"><?= Html::encode($message->datetime) ?></sup>
                </p>
                    <span><?= Html::encode($message->message_text) ?></span>
                </div>
            <?php endforeach; ?>
                
            <?php Pjax::end(); ?>
            <?= Html::button('<span class="glyphicon glyphicon-menu-down"></span>',['class'=>'btn btn-success col-md-12 col-xs-12','id' => 'message_more', 'style' => 'padding:0']) ?>
            </div>
    </div>

</div>


<?php if(!Yii::$app->user->isGuest && Yii::$app->user->identity->user_ban_status == 0): ?>
    <form action="" id="chat-form">
    <div class="input-group">
        <input type="text" id="chat-message_text" class="form-control" placeholder="Сообщение" name="Chat[message_text]">
        <input type="hidden" name="message_count" value="5" id="message_count">
        <span class="input-group-btn" >
            <button type="submit" id="chat-send-btn" class="btn btn-success" url_for_js= "<?= Url::to(['index']) ?>"><span class="glyphicon glyphicon-comment"></span></button>
        </span>
    </div>
    </form>
<?php else: ?>
    <div class="alert alert-danger">
        Вам запрещен доступ в чат
    </div>
<?php endif; ?>

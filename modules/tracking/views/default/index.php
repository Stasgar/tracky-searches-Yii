<?php

    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use yii\helpers\Url;
    
    $this->registerJsFile(Yii::$app->request->baseUrl.'/js/tracking.js');
    $this->title = "Tracky-Searches";
?>

<h1>Отследить почтовое отправление</h1>

<div class="content">
    <div class="col-md-8 col-xs-12" style="border:0px solid purple" >

        <div class="well">
            <div class="tab-content">
                    <div class="supported-services">
                        <h4>
                            <span class="label label-default">Поддерживаемые сервисы:</span>
                            <span class="label label-success">FI</span>
                            <span class="label label-success">NL</span>
                            <span class="label label-success">SG</span>
                        </h4>
                    </div><br>
                    <?php Pjax::begin(['id' => 'search', 'timeout' => 10000]); ?>
                    
                        <?php $form = ActiveForm::begin(['options' => ['data-pjax' => true]]) ?>
                                <?= $form->field(
                                    $modelTrack, 
                                    'trackNumber',
                                    ['template' =>
                                        '<div class="input-group">{input}<span class="input-group-btn"> '.
                                        Html::submitButton('<span class="glyphicon glyphicon-search"></span>',['class' => 'btn btn-success', 'id' => 'track-submit-btn']).
                                        '</span></div>{error}'
                                ])->textInput(['placeholder' => 'Трек-номер'])->label(false); ?>
                                
                        <?php ActiveForm::end(); ?>
                        <?= $this->render('instructions'); ?>
                        <div class="spinner" hidden="hidden">
                          <div class="rect1"></div>
                          <div class="rect2"></div>
                          <div class="rect3"></div>
                          <div class="rect4"></div>
                          <div class="rect5"></div>
                        </div>
                            
                        <div id="search-results" hidden="hidden">
                        <?php if( isset($trackInfo)): ?>
                            <?php if($trackInfo && $trackInfo != ''): ?>
                                <?= $this->render('searchTable', ['trackInfo'=>$trackInfo, 'savedStatus' => $savedStatus]) ?>
                            <?php else: ?>
                            <br>
                            <div class="alert alert-warning">
                                <h3>К сожалению мы не нашли информации по вашему отправлению :(</h3>
                                <h5>Такое случается, возможно почтовая служба еще не успела обновить информацию по данному трек-номеру. В любом случае, если посылка не начнет отслеживаться через пару недель - это повод начать волноваться.</h5>

                                <?= Html::img('/images/sorry.png',['width'=>'120px']) ?>
                                
                            </div>
                            <?php endif; ?>
                        <?php endif; ?>
                        </div>
                        <div class="alert alert-warning" hidden="hidden" id="canceled-error">
                                <h3>Мы получаем от вас очень много запросов</h3>
                                <h5>Попробуйте позже :)</h5>
                        </div>
                    
                    <?php Pjax::end(); ?>

                <!-- </div> -->
                <hr>
                <!-- <div role="tabpanel" class="tab-pane" id="saved"> -->
                    <div class="saved-tracks">
                        <?php if( isset($savedList) && $savedList): ?>
                            <?php Pjax::begin(['id' => 'pjax-save', 'enablePushState' => false]) ?>
                                <?= $this->render('savedTable', ['savedList' => $savedList]) ?>
                            <?php Pjax::end() ?>
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                <!-- </div> -->
            </div>
            <br>
        </div>
    </div>

    <div class="col-md-4 col-xs-12">
        <div class="well">
            <?= $this->render('chat.php',['modelChat' => $modelChat, 'chatData'=>$chatData]); ?>
        </div>
    </div>
</div>

<script>

</script>



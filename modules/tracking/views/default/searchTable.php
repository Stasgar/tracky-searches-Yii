<?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\web\View;

    Yii::$app->view->registerJs('var save_track_url = "'. Url::to(['/tracking/default/savetrack', 'trackNumber' => $trackInfo['track_num']]) .'"',  \yii\web\View::POS_HEAD);

?>

<div>
    <?php if(isset($trackInfo['track_num'])):?> 
        <h4 class="black-header col-md-offset-2">Трек-номер: <?= $trackInfo['track_num'] ?> </h4>
    <?php endif; ?>

    <?php if(isset($trackInfo['track_info']['target'])):?> 
        <h4 class="black-header col-md-offset-2">Направление: <?= $trackInfo['track_info']['target'] ?> </h4>
    <?php endif; ?>

    <?php if(isset($trackInfo['track_info']['type'])):?> 
        <h4 class="black-header col-md-offset-2">Тип отправления: <?= $trackInfo['track_info']['type'] ?> </h4>
    <?php endif; ?>
    
    <!-- Кнопка сохранения трек-номера в базе  -->

        <?php if(isset($savedStatus) && !$savedStatus): ?>
            <h4 class="black-header col-md-offset-2" id="save-btn-block">
                Сохранить трек:
                <?= Html::button('Сохранить', ['id' => 'save', 'class' => 'btn btn-primary']) ?>
            </h4>

        <?php elseif($savedStatus): ?>
            <h4 class="black-header col-md-offset-2">
                Трек находится в сохраненных
            </h4>
        <?php endif; ?>
        <div class="alert alert-success" id="btn-saved-succesful" hidden="hidden">
            <h4>Удачно сохранено <span class="glyphicon glyphicon-ok"></span></h4> 
        </div>

    <!-- Конец кнопки сохранения -->

</div>
<div class="search-results-block">

<div id="trackStatusTable">

    <div id="translate-switch">
        <label class="switch">
            <input type="checkbox" id="translate-checkbox" checked="checked">
            <div class="slider"></div>
        </label>
        <div id="switch-text"><h4>Переводить статусы</h4></div>
    </div>

    <hr>
    <div id="trackStatusTableHeader"></div>
    <div id="trackStatusTableBody">
    <?php foreach($trackInfo['track_status'] as $track): ?>
        <div class="trackStatusTableRow row">

            <div class="trackTimeCell col-md-2 col-xs-4">
                <b><?php if(isset($track["time"])) echo $track["time"] ?></b>
            </div>

            <div class="trackLineBody col-md-2 col-xs-2">
                    <div class="trackLine"></div>
                    <div class="trackLineIcon"></div>
            </div>

            <div class="trackStatusCell col-md-6 col-xs-8">
                <span class="status-ru"><?php if(isset($track["status-ru"])) echo $track["status-ru"] ?></span>
                <span class="status-en" display="none"><?php if(isset($track["status-en"])) echo $track["status-en"] ?></span>
            </div>

            <?php if(isset($trackInfo["track_status"][0]["place"])): ?>
            <div class="trackPlaceCell col-md-2 hidden-xs">
                    <span><?php if(isset($track["place"])) echo $track["place"] ?></span>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach;?>
    </div>
</div>
<br><br>

</div>

<script>
    $('#save').click(function(){
    $.ajax(
        {url:save_track_url, 
        success:
        function(){ 
            //$('#save').html('Сохранен').attr('disabled','disabled');
            $('#save-btn-block').hide(500);
            $('#btn-saved-succesful').show(500);
            //$.pjax.reload("#pjax-save");
            $.pjax.reload({container: "#pjax-save"});
        }
    })
});
</script>

<script>
var isTranslateChecked;

    function initTranslation()
    {
        if(getCookie('translate_status') === 'false')
            isTranslateChecked = false
        else
            isTranslateChecked = true;

        $( "#translate-checkbox" ).prop( "checked", isTranslateChecked );
    }

    function translateStatus(translate)
    {
        if(translate)
        {
            $('.status-ru').show(400);
            $('.status-en').hide(400);
        }
        else
        {
            $('.status-ru').hide(400);
            $('.status-en').show(400);
        }
    }

    initTranslation();

    $('#translate-checkbox').change(function(){
        if ($('#translate-checkbox').is(':checked'))
            {
                setCookie('translate_status', true);
                translateStatus(true);
                console.log ('show_translated');
            }
            else
            {
                setCookie('translate_status', false);
                translateStatus(false);
                console.log ('show_not_translated')
            }  
    });

    translateStatus(isTranslateChecked);
</script>

<script>
    $('#checkbox-styled').click(function(){
        $('#translate-checkbox').toggle();
    });
</script>

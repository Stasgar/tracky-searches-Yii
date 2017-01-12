<?php 
    use yii\helpers\Html;
    use yii\widgets\Pjax;
?>
<div class="table-draft ">
<h4 style="text-align:center">Сохраненные трек-номера:</h4>
<hr>

<?php foreach($savedList as $saved): ?>
<div class="" >
    <div class="col-md-offset-2 col-md-4">
        <h4><?= $saved->track_value ?></h4>
    </div>
    <div class="col-md-6">
        <div class="btn-group">
        <?= Html::button('<b><span class="glyphicon glyphicon-search"></span> Отследить</b>', ['class' => 'btn btn-warning search-btn btn-responsive', 'track-number' => $saved->track_value]) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span>', ['deletetrack', 'id' => $saved->track_id], ['class' => 'btn btn-danger btn-responsive']) ?>
        </div>
    </div>
    <div class="clearfix"></div><br>
</div>
<?php endforeach;?>

</div>

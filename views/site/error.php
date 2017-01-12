<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>
<div class="site-error col-md-offset-2 col-md-8">

    <h2>К сожалению произошла ошибка :(</h2>

    <div class="alert alert-danger">
        <?= Html::encode($this->title) ?>:&nbsp;
        <?= nl2br(Html::encode($message)) ?>
    </div>
    <div class="clearfix"></div>
    <h4>
        <span>Если вы считаете, что так быть не должно, то пожалуйста сообщите <a href="<?php echo Yii::$app->urlManager->createUrl(['site/about']); ?>" >нам</a></span>
    </h4>

</div>

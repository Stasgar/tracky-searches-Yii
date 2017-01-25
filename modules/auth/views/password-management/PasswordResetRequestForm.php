<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $this->title = "Восстановление пароля";
?>
<br>
<div class="container">
<h1>Восстановление пароля</h1>
<p>Введите адрес, на который был зарегистрирован ваш аккаунт</p>

<div class="col-md-6">
    <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model,'email', ['template' => '<div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        {input}</div>{error}'])
                            ->textInput(['placeholder'=>'example@mail.com'])
                            ->label('E-mail адрес'); 
        ?>
        <?= Html::submitButton('Отправить',['class'=>'btn btn-success']); ?>
    <?php ActiveForm::end() ?>
</div>
</div>
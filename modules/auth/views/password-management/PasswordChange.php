<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    $this->title = "Восстановление пароля";
?>
<br>
<div class="container">
<h1>Восстановление пароля</h1>
<p>Введите новый пароль</p>

<div class="col-md-6">
    <?php $form = ActiveForm::begin() ?>
        <?= $form->field($model,'password', ['template' => '<div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        {input}</div>{error}'])
                            ->textInput(['placeholder'=>'Новый пароль'])
                            ->label('Пароль');
        ?>
        <?= $form->field($model,'repeat_password', ['template' => '<div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        {input}</div>{error}'])
                            ->textInput(['placeholder'=>'Повторите пароль'])
                            ->label('Повторите пароль');
        ?>
        
        <?= Html::submitButton('Отправить',['class'=>'btn btn-success']); ?>
    <?php ActiveForm::end() ?>
</div>
</div>
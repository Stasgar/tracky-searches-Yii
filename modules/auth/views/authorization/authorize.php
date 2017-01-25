<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use yii\widgets\Pjax;
    use yii\helpers\Url;
    $this->title = "Регистрация/Вход";
?>

<br>
<div class="col-md-4 col-md-offset-4 container well">


    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#login" aria-controls="login" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
        <li role="presentation"><a href="#signup" aria-controls="signup" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> Регистрация</a></li>
    </ul>

    <div class="tab-content" hidden><!-- tab begin -->

        <div class="tab-pane active" id="login">
        <?php Pjax::begin(); ?> 
        <?php $form = ActiveForm::begin(['options'=>['data-pjax'=>true]]) ?>
            
            <div class="form-label-height">
                <h1> Вход </h1>  
            </div>
            
            <?= 
                $form->field($modelLogin, 'user_name', ['template' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    {input}</div>{error}'])
                        ->textInput(['placeholder'=>'Имя пользователя'])
                        ->label('Имя пользователя'); 
            ?>

            <?= 
                $form->field($modelLogin,'user_password', ['template' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    {input}</div>{error}'])
                        ->passwordInput(['placeholder'=>'Пароль'])
                        ->label('Пароль');
            ?>
            
            <?= Html::submitButton('Вход',['class'=>'btn btn-success']); ?>
            <a class="pull-right" href="<?= Url::toRoute(['/reset-password']) ?>">Забыли пароль?</a>
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
        </div>

        <div class="tab-pane" id="signup">
        
        <?php Pjax::begin(); ?>
        <?php $form = ActiveForm::begin(['options'=>['data-pjax'=>true]]); ?>
            
            <div class="form-label-height">
               <h1> Регистрация </h1>
                <h4> После регистрации вам станут доступны новые возможности! </h4>
                <div class="alert alert-warning hidden">
                    <h1>Регистрация временно закрыта, оставайтесь на связи :)</h1>
                    <h3>Для ознакомления:<br>Логин: <b><u>qwerty</u></b><br>Пароль: <b><u>qwerty</u></b></h3>
                </div>
                
            </div>

            <?= 
                $form->field($modelSignup,'user_name',['template' => '<div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    {input}</div>{error}'])
                        ->textInput(['placeholder'=>'Имя пользователя'])
                        ->label(false); 
            ?>

            <?= 
                $form->field($modelSignup,'user_password',['template' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    {input}</div>{error}'])
                        ->passwordInput(['placeholder'=>'Пароль'])
                        ->label(false); 
            ?>
            <?= 
                $form->field($modelSignup,'user_repeat_password', ['template' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    {input}</div>{error}'])
                        ->passwordInput(['placeholder'=>'Повторите пароль'])
                        ->label('Повторите пароль'); 
            ?>

            <?= 
                $form->field($modelSignup,'user_email', ['template' => '<div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                    {input}</div>{error}'])
                        ->textInput(['placeholder'=>'example@mail.com'])
                        ->label('E-mail адрес'); 
            ?>
            
            <?= Html::submitButton('Регистрация',['class'=>'btn btn-success']); ?>
                
        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
        </div>
    </div><!-- tab end -->    

</div>

<script>
    window.onload = function(){
        $('.tab-content').show(300);
    };
</script>

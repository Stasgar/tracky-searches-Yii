<?php
    use yii\helpers\Html;
    $this->registerJsFile('js/bootstrap-filestyle.min.js');
    $this->title = "Мой аккаунт";
?>

<h1 class="col-md-8 col-md-offset-2">Профиль пользователя</h1>

<div class="well container col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">
<?php //Pjax::begin() ?>
    <div class="user-info">
        <div class="image-block col-md-6 ">
            <div class="col-md-offset-1 col-xs-offset-3">
                <?= Html::showUserAvatar(150, $userInfo->user_avatar) ?>
            </div>
            <?php if($name_param === false): ?>
                <?= $this->render('imageUploadForm', ['modelImageUpload'=>$modelImageUpload]);  ?>
            <?php endif; ?>
        </div>

        <div class="col-md-2">
            <table class="table table-user-information table-bordered">
                <tbody>
                    <tr>
                        <td>Логин:</td>
                        <td><?= $userInfo->user_name ?></td>
                    </tr>
                      
                    <tr>
                        <td>Email</td>
                        <td>
                            <a href="mailto:<?= $userInfo->user_email ?>"><?= $userInfo->user_email ?></a>
                        </td>
                    </tr>

                    <tr>
                        <td>Зарегистрирован:</td>
                        <td><?= $userInfo->reg_time ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
    
    
<?php //Pjax::end() ?>

</div>

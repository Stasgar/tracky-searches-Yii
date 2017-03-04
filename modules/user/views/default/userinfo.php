<?php
    use yii\helpers\Html;
    use app\widgets\AvatarWidget;
    $this->registerJsFile('js/bootstrap-filestyle.min.js');
    $this->title = "Мой аккаунт";
?>

<h1 class="col-md-8 col-md-offset-2">Профиль пользователя</h1>

<div class="well container col-md-8 col-md-offset-2 col-xs-10 col-xs-offset-1">

    <div class="user-info">
        <div class="image-block col-md-12 row">
            <?php if($name_param === false): ?>
                <div class="col-md-offset-2 col-md-3">
                    <?= AvatarWidget::widget(['size'=>'150px', 'avatarName'=>$userInfo->user_avatar]) ?>
                </div>
                <div class="image-upload col-md-6">
                    <?= $this->render('imageUploadForm', ['modelImageUpload'=>$modelImageUpload]);  ?>
                </div>
            <?php else: ?>
                <div class="col-md-offset-4 col-md-3">
                    <?= AvatarWidget::widget(['size'=>'150px', 'avatarName'=>$userInfo->user_avatar]) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-offset-3 col-md-6 row">
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

</div>

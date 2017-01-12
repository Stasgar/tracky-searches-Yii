<?php 
    use yii\helpers\Url;
?>
<h1>Панель администратора</h1>

<ul class="list-group"> 
    <li class="list-group-item"><a href="<?= Url::toRoute('/admin/usermanager') ?>" class="btn btn-success">Управление пользователями</a></li>
    <li class="list-group-item"><a href="<?= Url::toRoute('/admin/chatmanager') ?>" class="btn btn-success">Управление чатом</a></li>
</ul>

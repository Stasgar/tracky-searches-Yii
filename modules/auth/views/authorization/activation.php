<?php 
    $this->registerCssFile(Yii::$app->request->baseUrl.'/css/loader.css');

    use yii\helpers\Url;

    $this->title = "Активация аккаунта";
?>

<?php if($status) :?>
    
    <h1>Ваш аккаунт активирован, переходим на страницу авторизации</h1>
    <div class="loader col-md-2 col-md-offset-5"></div>

    <script>
        setTimeout(
    function(){
        location="<?= Url::to(['authorization/authorize']) ?>";
    }, 1000

    );
    </script>

<?php else: ?>
    <h1>К сожалению мы не смогли найти аккаунт, который требует подтверждения, проверьте корректность ссылки :(</h1>
<?php endif; ?>

<?php
    use yii\widgets\ActiveForm;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
?>

<div class="image-upload">
    <div class="panel-body">
                    
        <?php $form = ActiveForm::begin(
            ['options' => 
                [
                    'enctype' => 'multipart/form-data',
                    'data-pjax'=>true
                ]
            ]
        )?>
                    
            <?= $form
                ->field($modelImageUpload, 'imageFile')
                ->fileInput(['id'=>'files', 'class' => 'filestyle'])
                ->label(false)
            ?>
                    
        <?= Html::submitButton('Изменить', ['class' => 'btn btn-success col-md-12', 'id' => 'uploadImageBtn']) ?>

        <?php ActiveForm::end() ?>

    </div>
</div>

<script>
// код, предназначенный для вывода превью картинки
    document.getElementById("files").onchange = function () {
    var reader = new FileReader();

    reader.onload = function (e) {
        $('.user-avatar').attr("src",e.target.result);
    };
    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
    };
</script>

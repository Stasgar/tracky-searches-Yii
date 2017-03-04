<?php
namespace app\modules\tracking\classes;
use Yii;

interface ServiceInterface
{
    /*
        Метод получения результата, возвращаемое значение - массив с данными об отправлении.
    */
    public function getResult($track);
}

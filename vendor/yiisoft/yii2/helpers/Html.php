<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\helpers;
use Yii;

/**
 * Html provides a set of static methods for generating commonly used HTML tags.
 *
 * Nearly all of the methods in this class allow setting additional html attributes for the html
 * tags they generate. You can specify for example. 'class', 'style'  or 'id' for an html element
 * using the `$options` parameter. See the documentation of the [[tag()]] method for more details.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Html extends BaseHtml
{
    /**
     * @param int $size image size, for example: 16 (16x16 px size)
     */
    public static function showUserAvatar($size=16, $avatarName = false)
    {
        if(!$avatarName)
            return '<img style="border-radius:50%" width='.$size.'px height='.$size.'px src="' .'/storage/avatars/' . Yii::$app->user->identity->user_avatar . '" class="user-avatar">';
        else
            return '<img style="border-radius:50%" width='.$size.'px height='.$size.'px src="' .'/storage/avatars/' . $avatarName . '" class="user-avatar">';
    }


}
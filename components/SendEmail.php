<?php

namespace app\components;

use Yii;

class SendEmail
{
    const EMAIL_FROM = 'email@mail.ru';

    public static function sendActivationMail($user_name, $email, $authurl)
    {
        try{
            Yii::$app->mailer
                ->compose('layouts/activate-account',
                    [
                        'userName' => $user_name,
                        'authLink' => $authurl,
                    ]
                )
                ->setFrom(static::EMAIL_FROM)
                ->setTo($email)
                ->setSubject('Подтверждение аккаунта tracky-searches.ru[test]')
                ->send();
        }
        catch(\Swift_TransportException $e)
        {
            echo "К сожалению мы не смогли отправить сообщение на указанный адрес.";
            echo $e->getMessage();
        }
    }

    public static function sendResetPasswordMail($email, $reset_url)
    {
        try{
            Yii::$app->mailer
                ->compose('layouts/reset-password',
                    ['resetLink' => $reset_url]
                )
                ->setFrom(static::EMAIL_FROM)
                ->setTo($email)
                ->setSubject('Восстановление пароля tracky-searches.ru')
                ->send();
        }
        catch(\Swift_TransportException $e)
        {
            echo "К сожалению мы не смогли отправить сообщение на указанный адрес.";
            echo $e->getMessage();
        }
    }
}

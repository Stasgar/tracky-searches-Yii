# tracky-searches-Yii

Репозиторий веб-сайта tracky-searches.ru

Перед началом работы необходимо произвести настройку 
* Произвести настройку БД в файле config/db.php
* В файле config/web.php произвести настройку SwiftMailer
  * В контроллере авторизации (modules/auth/controllers/AuthorizationController.php) установить свое значение в поле "->setFrom('your-email')"

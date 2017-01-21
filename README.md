# tracky-searches-Yii
[![Build Status](https://travis-ci.org/Stasgar/tracky-searches-Yii.svg?branch=master)](https://travis-ci.org/Stasgar/tracky-searches-Yii)

Репозиторий веб-сайта tracky-searches.ru

Данный проект представляет из себя сервис по отслеживанию посылок.

Приложение поделено на 4 основных модуля:
* admin - модуль, реализующий панель администратора
* auth - модуль, реализующий функционал регистрации и авторизации
* tracking - модуль, реализующий функционал отслеживания почтовых отправлений и онлайн-чат
* user - модуль, реализующий раздел профиля пользователя

Перед началом работы необходимо произвести настройку 
* Произвести настройку БД в файле config/db.php
* В файле config/web.php произвести настройку SwiftMailer
  * В контроллере авторизации (modules/auth/controllers/AuthorizationController.php) установить свое значение в поле "->setFrom('your-email')"

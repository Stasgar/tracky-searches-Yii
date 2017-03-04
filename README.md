# tracky-searches-Yii <img width="26" height="26" src="https://tracky-searches.ru/images/logo_img.png">

<img src="https://s23.postimg.org/l3e6vcxob/tracky_preview.png">
Репозиторий веб-сайта [tracky-searches.ru](https://tracky-searches.ru/)

### О приложении
Данный проект представляет из себя сервис по отслеживанию посылок.

Приложение поделено на 4 основных модуля:
* admin - модуль, реализующий панель администратора
* auth - модуль, реализующий функционал регистрации и авторизации, также функционал восстановления пароля
* tracking - модуль, реализующий функционал отслеживания почтовых отправлений и онлайн-чат
* user - модуль, реализующий раздел профиля пользователя

### Настройка

##### |Composer

Перед началом работы с проектом требуется установить дополнительные модули:
```sh
$ composer install
```
Все требуемые компоненты и зависимости будут загружены в директорию *vendor*

##### |База Данных
Настройка подключения к вашей базе данных производится в файле конфигурации `config/db.php`

После настройки подключения для воссоздания требуемой структуры таблиц проекта следует применить миграцию:
```sh
$ php yii migrate
```

##### |SwiftMailer

Для работы функционала, требующего отправку e-mail сообщений требуется произвести настройку SMTP

Для этого в файле конфигурации `config/email_data.php` произведите настройки в соответствии с вашим почтовым клиентом:
```php
return [
    'class' => 'Swift_SmtpTransport',
    'host' => 'smtp.mail.ru',
    'username' => 'email@mail.ru',
    'password' => 'email-passsword',
    'port' => '465',
    'encryption' => 'ssl',
];
```

В классе для отправки сообщений на почту `components/SendEmail.php` следует заменить значение константы `EMAIL_FROM` (отправителя):
```php
const EMAIL_FROM = 'email@mail.ru';
```

*Подробнее о работе SwiftMailer можно узнать в [официальной документации](http://swiftmailer.org/docs/introduction.html) плагина.*

##### |Переводчик Google
По-умолчанию переводчик выключен, при желании вы можете настроить его в `config/params.php`,
для этого укажите ваш API-ключ, и измените параметр `active` на `true`:
```php
'googleTranslate' => [
        'key' => 'your-api-key',
        'active' => false,
    ],
```
*Подробнее о работе с Google API можно узнать на официальной [странице Google API](https://console.developers.google.com)
##### |reCaptcha
Зарегистрируйте ваш домен на официальной странице [reCaptcha](https://www.google.com/recaptcha/intro/comingsoon/invisiblebeta.html)
Введите полученные данные в конфигурацию `config/reCaptcha_data.php`:
```php
return [
    'name' => 'reCaptcha',
    'class' => '\himiklab\yii2\recaptcha\ReCaptcha',
    'siteKey' => 'your-site-key',
    'secret' => 'your-secret-key',
];

```
##### |Определение администратора
Для того, чтобы дать пользователю роль администратора в приложении - нужно определить его с помощью id в `rbac/assignments.php`
```php
return [
    1 => [
        'admin',
    ],
];
```

##### |Добавление нового парсера почтового сервиса
*В разработке...

> Данный проект разрабатывался в качестве курсового проекта **СПБКТ**

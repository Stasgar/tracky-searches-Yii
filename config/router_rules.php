<?php
return [
        '' => 'tracking/default/index',
        'about' => 'site/about',
        'user' => 'user/default/user-info',
        'user/<name_param:\w+>' => 'user/default/user-info',
        'authorization' => 'auth/authorization/authorize',
        'change-password' => 'auth/password-management/change-password',
        'reset-password' => 'auth/password-management/reset-password-request'
];
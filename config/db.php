<?php
return [
    'class'    => 'yii\db\Connection',
    'dsn'      => $_SERVER['DB_DSN'],
    'username' => $_SERVER['DB_USER'],
    'password' => $_SERVER['DB_PASSWORD'],
    'charset'  => 'utf8mb4',
];

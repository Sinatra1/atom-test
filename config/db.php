<?php

$db = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=atom_test',
    'username' => 'root',
    'password' => '1',
    'charset' => 'utf8',
];

require(__DIR__ . '/local.db.php');

return $db;

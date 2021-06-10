<?php
require "libs/rb-mysql.php";

// Подключаемся к БД
R::setup( 'mysql:host=localhost;dbname=articles',
        'root', '' );

// Проверка подключения к БД
if(!R::testConnection()) die('No DB connection!');
?>

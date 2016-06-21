<?php

//кодировка в UTF-8
mb_internal_encoding('utf-8');
//вывод ошибок
error_reporting(E_ALL);
//стартую сессию
session_start();

//подключаю функцию проверки 
include "function.php";
// подключаю базу данных 
include "models/database.php";
include "models/change.php";
//подключаем хранение ссылочных данных
include "variables.php";
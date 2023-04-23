<?php
define("ConnString",json_decode("../../config/config.json",true));
$pdo = new PDO("ConnString['DRIVER']:host=ConnString['SERVER'];port=ConnString['SERVER_PORT'];dbname=ConnString['DBNAME']",ConnString['USERNAME'],ConnString['PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

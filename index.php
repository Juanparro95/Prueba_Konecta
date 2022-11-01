<?php 

require 'app/Configs/Parro.php';
use ParroFramework\Configs\Parro;

Parro::init_composer();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
Parro::run();

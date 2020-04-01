<?php 

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = new Dotenv\Dotenv(dirname(__DIR__), '.env.testing');
$dotenv->load();

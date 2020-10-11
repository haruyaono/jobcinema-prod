<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(dirname(__DIR__), '.env.testing');
$dotenv->load();

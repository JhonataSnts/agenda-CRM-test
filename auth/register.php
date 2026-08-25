<?php

require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

session_start();

$authController = new AuthController();

$authController->showRegister();





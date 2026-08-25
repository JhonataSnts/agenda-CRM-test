<?php

use App\Controllers\AuthController;

require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

session_start(); 

$authController = new AuthController();

$authController->logout();
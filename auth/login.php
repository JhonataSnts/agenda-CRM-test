<?php
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

require_once '../helpers/functions.php';
session_start();

$authController = new AuthController();

$authController->showLogin();







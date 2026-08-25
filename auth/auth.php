<?php 
session_start();

require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\AuthController;

$authController = new AuthController();

$authController->login();

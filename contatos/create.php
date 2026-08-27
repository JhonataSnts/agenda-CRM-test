<?php

use App\Controllers\ContactController;

require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

$contactController = new ContactController;

$contactController->create();


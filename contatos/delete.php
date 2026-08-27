<?php

require_once '../auth/protect.php';
require_once '../helpers/functions.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;

$contactController = new ContactController;

$contactController->delete();

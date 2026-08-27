<?php

require_once '../auth/protect.php';
require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/validation.php';
require_once '../vendor/autoload.php';

use App\Controllers\ContactController;
use App\Repositories\ContactRepository;

$contactController = new ContactController;

$contactController->store();

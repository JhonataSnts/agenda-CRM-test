<?php
require_once '../helpers/functions.php';

session_start();

session_destroy();   

redirect('../auth/login.php');
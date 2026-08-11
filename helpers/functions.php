<?php

function redirect($path) {
    header("Location: $path");
    exit();
}

function e($value) {
    return htmlspecialchars($value ?? '');
}
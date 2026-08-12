<?php

function isBlank($value)
{
    return trim($value ?? '') === '';
}

function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function onlyNumbers($value)
{
    return preg_replace('/\D/', '', $value ?? '');
}

function isValidCpfLength($cpf)
{
    return strlen(onlyNumbers($cpf)) === 11;
}

function isPositiveId($id)
{
    return (int) $id > 0;
}
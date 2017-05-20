<?php
namespace Components\Database;

function studlyCaps($string)
{
    $string = preg_replace('/[^a-z0-9]/i',' ',$string);

    $string = ucwords($string);

    $string = str_replace(' ','',$string);

    return $string;
}

function snakeCase($string)
{
    return preg_replace('/[^a-z0-9]/i','_',$string);
}
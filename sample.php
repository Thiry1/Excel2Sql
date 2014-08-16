<?php

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require_once __DIR__ . '/vendor/autoload.php';

    try
    {
        Excel2Sql\SqlBuilder::create(__DIR__.'/sampleFile/product.xlsx');
    }
    catch(Exception $e)
    {
        echo($e->getMessage());
    }
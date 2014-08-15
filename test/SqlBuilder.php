<?php

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require_once __DIR__ . '/../vendor/autoload.php';

    class SqlBuilderTest extends PHPUnit_Framework_TestCase
    {
        public function testSqlBuilder()
        {
            $this->assertEquals(
                Excel2Sql\SqlBuilder::create(__DIR__.'/sampleFile/product.xlsx'),
                array(
                    'insert into Product(ProductName,Price) values(\'商品1\',1980)',
                    'insert into Product(ProductName,Price) values(\'商品2\',2980)',
                    'insert into Product(ProductName,Price) values(\'商品3\',100)'
                )
            );
        }
    }

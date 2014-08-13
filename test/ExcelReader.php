<?php

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require_once __DIR__ . '/../vendor/autoload.php';

    class ExcelReaderTest extends PHPUnit_Framework_TestCase
    {
        /**
         * openメソッドにファイルパスを渡さない
         *
         * @expectedException        InvalidArgumentException
         * @expectedExceptionMessage Excel file path not given.
         */
        public function testOpenWithoutFilePath()
        {
            $response = Excel2Sql\ExcelReader::open();
        }

        /**
         * openメソッドに存在しないファイルへのパスを渡す
         *
         * @expectedException        PHPExcel_Reader_Exception
         * @expectedExceptionMessage Could not open /undefined.xlsx for reading! File does not exist.
         */
        public function testOpenInvalidFilePath()
        {
            $response = Excel2Sql\ExcelReader::open('/undefined.xlsx');
        }

        /**
         * openメソッドにExcel以外のファイルへのパスを渡す
         *
         * @expectedException        Excel2Sql\E2SException
         * @expectedExceptionMessage invalid extension. Extension should be 'xlsx' or 'xls'
         */
        public function testOpenInvalidFile()
        {
            $response = Excel2Sql\ExcelReader::open('/undefined.txt');
        }

    }

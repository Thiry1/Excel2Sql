<?php
    /**
     * ExcelファイルをPHPで扱える形で展開するPHPExcelのラッパークラス
     *
     * @package Excel2Sql
     * @author Thiry
     * @since PHP 5.4
     * @version 1.0.0
     * @uses PHPExcel
     * @uses Excel2Sql\E2SException
     */
    namespace Excel2Sql;
    use Excel2Sql\E2SException;

    final class ExcelReader
    {
        /**
         * 渡されたファイルパスにあるExcelファイルを展開するための初期化処理を行う
         *
         * @param String $filePath Excelファイルのパス
         * @return PHPExcel
         * @throws Excel2Sql\E2SException
         * @throws InvalidArgumentException
         */
        public static function open($filePath = null)
        {
            //ファイルパスが与えられていないかチェックする
            if( $filePath === null )
            {
                throw new \InvalidArgumentException('Excel file path not given.');
            }

            //PHPExcelライブラリのロード
            require_once(__DIR__ . '/../PHPExcel.php');
            require_once(__DIR__ . '/../PHPExcel/IOFactory.php');

            $excel = null;//PHPExcelインスタンスを格納する

            //ファイルの拡張子からExcelのフォーマットの識別し、適切なファイルオープン要求をする
            switch( pathinfo($filePath, PATHINFO_EXTENSION) )
            {
                case 'xlsx':    $excel = self::openExcelFile($filePath, 'Excel2007');    break;
                case 'xls':     $excel = self::openExcelFile($filePath, 'Excel5');       break;
                default:        throw new E2SException('invalid extension. Extension should be \'xlsx\' or \'xls\'');
            }


            if( !($excel instanceof \PHPExcel) )
            {
                throw new E2SException('Cound\'t create PHPExcel instance');
            }

            return $excel;
        }

        /**
         * Excelファイルを開く
         *
         * @param String $filePath Excelファイルのパス
         * @param String $fileType Excelファイルの種類
         *                         e.g. 'Excel5', 'Excel2007'
         * @return PHPExcel
         * @throws PHPExcel_Reader_Exception
         */
        private static function openExcelFile($filePath, $fileType)
        {
            $reader = \PHPExcel_IOFactory::createReader($fileType);
            return $reader->load($filePath);
        }
    }
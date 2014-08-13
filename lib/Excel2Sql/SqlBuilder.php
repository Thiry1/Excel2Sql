<?php
    /**
     * Excelデータを解析し、SQLを作成する
     *
     * @package Excel2Sql
     * @author Thiry
     * @since PHP 5.4
     * @version 1.0.0
     * @uses Excel2Sql\ExcelReader
     * @uses Excel2Sql\E2SException
     */
    namespace Excel2Sql;
    use Excel2Sql\E2SException;

    final class SqlBuilder
    {
        /**
        * エクセルデータのプロパティ
        *
        * @property PHPExcel $sheet アクティブなシートを格納する
        * @property int シートの行数を格納する
        * @property int シートの列数を格納する
        */
        private $sheet;
        private $rowCount = 0;
        private $colCount = 0;

        /**
         * ExcelファイルからSQLを作成する
         *
         * @param String $filePath Excelファイルのパス
         * @return array
         */
        public static function create($filePath = null)
        {
            $sb = new self(ExcelReader::open($filePath));
        }
        /**
         * SqlBuilderコンストラクタ
         *
         * @param PHPExcel $excel Excelデータ
         */
        private function __construct($excel)
        {
            //PHPExcelオートローダー
            require_once(__DIR__ . '/../PHPExcel/Autoloader.php');

            //シート１を選択
            $excel->setActiveSheetIndex(0);

            //シートの内容を格納
            $this->sheet = $excel->getActiveSheet();
            //シートの行数を取得
            $this->rowCount = $this->sheet->getHighestRow();
            //シートの列数を取得
            $this->colCount = \PHPExcel_Cell::columnIndexFromString($this->sheet->getHighestColumn()) - 1;
        }


    }


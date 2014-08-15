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
     * @uses Excel2Sql\DB
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
        * エクセルデータのデータ位置
        *
        * @property-read String CELL_SQL SQLテンプレートが格納されているセル
        */
        const CELL_SQL = 'B1';

        /**
         * ExcelファイルからSQLを作成する
         *
         * @param String $filePath Excelファイルのパス
         * @return array
         */
        public static function create($filePath = null)
        {
            $sb = new self(ExcelReader::open($filePath));

            //シートからSQLのテンプレートを取得
            $sqlTemp = $sb->getSqlPlaceHolder();

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
            $this->colCount = \PHPExcel_Cell::columnIndexFromString($this->sheet->getHighestColumn());

        }

        /**
         * ExcelからSQLテンプレートを取り出す
         */
        private function getSqlPlaceHolder()
        {
            $sql = $this->sheet->getCell( $this::CELL_SQL )->getValue();

            //SQLの取り出しに失敗していれば例外を出す
            if( null === $sql )
            {
                throw new E2SException('couldn\'t get SQL Template. column: ' . $this::CELL_SQL);
            }

            return $sql;
        }

    }


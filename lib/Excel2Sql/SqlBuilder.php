<?php
    /**
     * Excelデータを解析し、SQLを作成する
     *
     * @package Excel2Sql
     * @author Thiry
     * @since PHP 5.5
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
        * @property int $rowCount シートの行数を格納する
        * @property int $colCount シートの列数を格納する
        * @property String $sqlTemp SQLテンプレートを格納する
        */
        private $sheet;
        private $rowCount = 0;
        private $colCount = 0;
        private $sqlTemp = null;

        /**
        * エクセルデータのデータ位置
        *
        * @property-read String CELL_SQL SQLテンプレートが格納されているセル
        * @property-read String CELL_DATA_START_ROW データが格納されている行の始端
        * @property-read String CELL_DATA_START_COL データが格納されている列の始端( 0 = A )
        */
        const CELL_SQL = 'B1';
        const CELL_DATA_START_ROW = '4';
        const CELL_DATA_START_COL = '0';

        /**
         * ExcelファイルからSQLを作成する
         *
         * @param String $filePath Excelファイルのパス
         * @return array
         */
        public static function create($filePath = null)
        {
            $sb = new self(ExcelReader::open($filePath));

            $queries = $sb->build();
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

            //シートからSQLのテンプレートを取得
            $this->setSqlPlaceHolder();
        }

        /**
         * ExcelからSQLテンプレートを取り出す
         */
        private function setSqlPlaceHolder()
        {
            $this->sqlTemp = $this->sheet->getCell( $this::CELL_SQL )->getValue();

            //SQLの取り出しに失敗していれば例外を出す
            if( null === $this->sqlTemp )
            {
                throw new E2SException('couldn\'t get SQL Template. column: ' . $this::CELL_SQL);
            }
        }

        /**
         * Excelからデータを抽出し、SQLテンプレートと合成する
         *
         * @return array
         */
        private function build()
        {

        }

        /**
         * Excelのデータエリアの行番号を返すジェネレータ
         * @return int 行番号
         */
        private function row()
        {
            //データの行数を取得
            $dataRowCount = $this->rowCount - ( $this::CELL_DATA_START_ROW - 1 );

            foreach( range(0, ( $dataRowCount - 1 ) ) as $rowNum )
            {
                yield ( $rowNum + $this::CELL_DATA_START_ROW );
            }
        }

        /**
         * Excelのデータエリアの列番号を返すジェネレータ
         * @return int 列番号
         */
        private function col()
        {
            //SQL内の置き換え対象('?')の数を取得する
            $paramCount = substr_count($this->sqlTemp, '?');

            foreach( range(0, ( $paramCount - 1 ) ) as $colNum )
            {
                yield $colNum;
            }
        }
    }


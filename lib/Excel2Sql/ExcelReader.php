<?php
    /**
     * Excelファイルを展開する
     *
     * @package Excel2Sql\SqlBuilder
     * @author Thiry
     * @since PHP 5.4
     * @version 1.0.0
     */
    namespace Excel2Sql;
    final class ExcelReader
    {
        /**
         * 渡されたファイルパスにあるExccelファイルを展開する
         *
         */
        public static function open($filePath = null)
        {
            if( $filePath === null )
            {
                throw new E2SException('Excel file path not given.');
            }
        }
    }
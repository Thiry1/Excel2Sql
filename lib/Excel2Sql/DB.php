<?php
    /**
     * データベースアクセスクラス
     *
     * @package Excel2Sql
     * @author Thiry
     * @since PHP 5.4
     * @version 1.0.0
     */
    namespace Excel2Sql;
    use Excel2Sql\E2SException;

    final class DB
    {
        /**
         * データベースコネクションを返す
         * MySQLとOracle以外？知らない。
         *
         * @return PDO データベースコネクション
         */
        public static function connect()
        {
            $dsn = null;
            //データベースの種類にあったDSNを定義する
            switch( Config\DB::DATABASE )
            {
                case 'mysql':
                    $dsn = sprintf('mysql:dbname=%s;host=%s;port=%d;charset=%s', Config\DB::DB_NAME, Config\DB::HOST, Config\DB::PORT, Config\DB::CHARSET);
                    break;
                case 'oracle':
                    $dsn = sprintf('oci:dbname=//%s:%d/%s;charset=%s', Config\DB::HOST, Config\DB::PORT, Config\DB::DB_NAME, Config\DB::CHARSET);
                    break;
                default:
                    throw new E2SException('Unknown Database Type');
            }


            return new \PDO($dsn, Config\DB::USER, Config\DB::PASSWORD);
        }

    }


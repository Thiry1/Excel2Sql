<?php
    /**
     * データベースアクセスに必要なデータを保持する
     *
     * @package Excel2Sql\Config
     * @author Thiry
     * @since PHP 5.4
     * @version 1.0.0
     */
    namespace Excel2Sql\Config;
    final class DB
    {
        /**
        * データベースの接続情報
        *
        * @property-read String DATABASE 接続データベースの種類。
        *                                e.g mysql, oracle
        * @property-read String HOST ホストアドレス
        * @property-read Int PORT ポート番号
        * @property-read String DB_NAME　データベース名
        * @property-read String CHARSET 文字コード
        * @property-read String USER　ユーザー名
        * @property-read String PASSWORD　パスワード
        */
        const DATABASE = 'mysql';
        const HOST = 'localhost';
        const PORT = 3306;
        const DB_NAME = 'test';
        const CHARSET = 'utf8';
        const USER = 'USERNAME';
        const PASSWORD = 'PASSWORD';
    }
Excel2Sql
=========

ExcelファイルからSQLを作成し実行するライトプログラム

必須環境
============
- PHP version **5.5.0** or higher
- PDO

実行
===========

Excel2Sql\SqlBuilder::create('エクセルファイルへのパス')


設定
===========
- config/DB.php　データベース接続情報を記述してください

編集
===========
### Excelファイル

セルB1にSQLのプレースホルダを記述します。  
**その際、名前付きプレースホルダは使用しないでください。(今後対応するかも)**
例) insert into Product(ProductName,Price) values(?,?)  
  
A4以降にデータを入れていきます。  
|   | A     | B        |
|---|-------|----------|
| 4 | 商品1 | 1980     |
| 5 | 商品2 | 2980     |
| 6 | 商品3 | 100      |
| 7 | 商品4 | 19555555 |

この状態で実行すると以下の様なクエリが作成、実行される。  
insert into Product(ProductName,Price) values('商品1',1980)  
insert into Product(ProductName,Price) values('商品2',2980)  
insert into Product(ProductName,Price) values('商品3',100)  
insert into Product(ProductName,Price) values('商品4',19555555)  

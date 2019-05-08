<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    echo 'logout';
    exit;
}

//header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);


//echo $sql."<hr>";

/**
 * MySQLに接続
 */
try{
  //$dbh = new PDO($dsn, $user, $password);
  $dbh = new PDO("mysql:host=localhost:3306; dbname=testmol; charset=utf8", 'mol', 'mol');
    /* データの取得
    * PDO::FETCH_ASSOC 連想配列で返すフラグみたいなもの
    */
    $sql = "SELECT 
    `molid`
    FROM `pubchem`
    ;";
    $stmt = $dbh->query($sql);
    // SQLを実行
    $stmt->execute();
    // 取得したデータを出力
    // fetchメソッドでSQLの結果を取得
    // 定数をPDO::FETCH_ASSOC:に指定すると連想配列で結果を取得できる
    // 取得したデータを$productListへ代入する
    $productList = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $productList[] = array(
            'molid'    => $row['molid']
        );
        $id = $row['molid'];
        echo $id."\n";
        $url="http://localhost:8888/moldb/img.php?id=".$id;
        $img = file_get_contents($url);
        $img_name = $id.".png";

        //画像を保存
        $savepath = '‎⁨/Applications/MAMP/htdocs/moldb/img/' . $img_name;
        file_put_contents($savepath, $img);
        echo $id." !\n";
    }

    //var_dump($productList);





}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}

// 接続を閉じる
$dbh = null;
?>
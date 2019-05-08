<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

//header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);

$limit = 10;
if(isset($_REQUEST['limit'])) {
    if ($_REQUEST["limit"] != "") {
        $limit = $_REQUEST["limit"];
    }
}

$offset = 0;
if(isset($_REQUEST['offset'])) {
    if ($_REQUEST["offset"] != "") {
        $offset = $_REQUEST["offset"];
    }
}


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
    #,`mol2d`
    ,`PUBCHEM_COMPOUND_CID`
    ,`PUBCHEM_CACTVS_HBOND_ACCEPTOR`
    ,`PUBCHEM_CACTVS_HBOND_DONOR`
    #,`PUBCHEM_IUPAC_OPENEYE_NAME`
    ,`PUBCHEM_IUPAC_NAME`
    ,`PUBCHEM_IUPAC_INCHIKEY`
    ,`PUBCHEM_MOLECULAR_FORMULA`
    ,`PUBCHEM_MOLECULAR_WEIGHT`
    ,`created` 
    FROM `pubchem` 
    LIMIT ".$limit." OFFSET ".$offset."
    ;";
    $stmt = $dbh->query($sql);
    // SQLを実行
    $stmt->execute();
    // 取得したデータを出力

    $productList = array();

    // fetchメソッドでSQLの結果を取得
    // 定数をPDO::FETCH_ASSOC:に指定すると連想配列で結果を取得できる
    // 取得したデータを$productListへ代入する
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $productList[] = array(
            'molid'    => $row['molid'],
            #'mol2d'    => $row['mol2d'],
            'PUBCHEM_COMPOUND_CID'  => $row['PUBCHEM_COMPOUND_CID'],
            'PUBCHEM_CACTVS_HBOND_ACCEPTOR' => $row['PUBCHEM_CACTVS_HBOND_ACCEPTOR'],
            'PUBCHEM_CACTVS_HBOND_DONOR' => $row['PUBCHEM_CACTVS_HBOND_DONOR'],
            #'PUBCHEM_IUPAC_OPENEYE_NAME' => $row['PUBCHEM_IUPAC_OPENEYE_NAME'],
            'PUBCHEM_IUPAC_NAME' => $row['PUBCHEM_IUPAC_NAME'],
            'PUBCHEM_IUPAC_INCHIKEY' => $row['PUBCHEM_IUPAC_INCHIKEY'],
            'PUBCHEM_MOLECULAR_FORMULA' => $row['PUBCHEM_MOLECULAR_FORMULA'],
            'PUBCHEM_MOLECULAR_WEIGHT' => $row['PUBCHEM_MOLECULAR_WEIGHT'],
            'created' => $row['created']

        );
    }

    // ヘッダーを指定することによりjsonの動作を安定させる
    header('Content-type: application/json');
    // htmlへ渡す配列$productListをjsonに変換する
    echo json_encode($productList);

}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}

// 接続を閉じる
$dbh = null;
?>
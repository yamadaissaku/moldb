<?php
//session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}

ini_set('auto_detect_line_endings', 1);

$productList = array();
$molfile = "";
/**
 * MySQLに接続
 */
try{
	//$dbh = new PDO($dsn, $user, $password);
	$dbh = new PDO("mysql:host=localhost:3306; dbname=testmol; charset=utf8", 'mol', 'mol');
	  /* データの取得
	  * PDO::FETCH_ASSOC 連想配列で返すフラグみたいなもの
	  */
	  $sql = "SELECT mol2d FROM `pubchem` WHERE molid=".$id." ;";
	  $stmt = $dbh->query($sql);
	  // SQLを実行
	  $stmt->execute();
	  // 取得したデータを出力
  
	  //$productList = array();
  
	  // fetchメソッドでSQLの結果を取得
	  // 定数をPDO::FETCH_ASSOC:に指定すると連想配列で結果を取得できる
	  // 取得したデータを$productListへ代入する
	  while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		  $productList[] = array(
			  'mol2d'    => $row['mol2d']
		  );
	  }
  
	  // ヘッダーを指定することによりjsonの動作を安定させる
	  //header('Content-type: application/json');
	  // htmlへ渡す配列$productListをjsonに変換する
	  //echo json_encode($productList);
  
  }catch (PDOException $e){
	print('Error:'.$e->getMessage());
	die();
  }
  
  // 接続を閉じる
  $dbh = null;


//var_dump($productList);


$molfile = $productList[0]["mol2d"];
//echo $molfile;

?>
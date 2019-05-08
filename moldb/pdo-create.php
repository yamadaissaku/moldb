<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}



try {
	// DBへ接続
	$dbh = new PDO("mysql:host=localhost:3306; dbname=testmol; charset=utf8", 'mol', 'mol');

	// SQL作成
	$sql = 'CREATE TABLE testmoltable (
		id INT(11) AUTO_INCREMENT PRIMARY KEY,
		name VARCHAR(100),
		age INT(11),
		registry_datetime DATETIME
	) engine=innodb';

	// SQL実行
	$res = $dbh->query($sql);

} catch(PDOException $e) {
    die();
    exit('データベース接続失敗。' . $e->getMessage());
}

// 接続を閉じる
$dbh = null;


echo 'created';



?>
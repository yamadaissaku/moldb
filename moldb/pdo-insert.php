<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}



try {
	// DBへ接続
	$pdo = new PDO("mysql:host=localhost:3306; dbname=testmol; charset=utf8", 'mol', 'mol');

// insert
	$stmt = $pdo -> prepare("INSERT INTO testmoltable (name, age, registry_datetime) VALUES (:name, :age ,:registry_datetime)");
	$name = 'wanko';
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$age = 3;
	$stmt->bindValue(':age', $age, PDO::PARAM_INT);
	$created_at = new DateTime();
	$stmt->bindValue(':registry_datetime', $created_at->format('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->execute();

// select
	$sql = "SELECT * FROM `testmoltable`";
	$stmt = $pdo->query($sql);

	// 値を取得
	$results = $stmt->fetchAll();

	echo var_dump($results).'<br>';
	echo '<hr>';

} catch(PDOException $e) {
    die();
    exit('データベース接続失敗。' . $e->getMessage());
}

// 接続を閉じる
$dbh = null;


echo 'inserted';



?>
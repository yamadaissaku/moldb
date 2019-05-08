<?php
include('menu.php');

set_time_limit(0);

//アップロードしたファイル名
$a = $_FILES['file1']['name'];
echo $a; //test1.txt
echo nl2br("\n"); //改行

//一時的なファイル名
$b = $_FILES['file1']['tmp_name'];
//echo $b; //D:\xampp\tmp\phpF5E8.tmp
//echo nl2br("\n"); //改行

//ファイルのサイズ
$c = $_FILES['file1']['size'];
echo $c; //170
echo nl2br("\n"); //改行

//ファイルのタイプ
$d = $_FILES['file1']['type'];
echo $d; //text/plain
echo nl2br("\n"); //改行

//エラーコード
$e = $_FILES['file1']['error'];
echo $e; //0
echo nl2br("\n"); //改行


if (is_uploaded_file($b)) {

	date_default_timezone_set('Asia/Tokyo');

	$dt = date("Y-m-d-H-i-s_").$a;
	if ( move_uploaded_file($b , './sdf/'.$dt )) {
		echo $dt.nl2br("\n");
		echo "uploaded";

	} else {
		echo "Failed";
	}

} else {
	echo "File not exist";
} 
?>
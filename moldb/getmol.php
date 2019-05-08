<?php
date_default_timezone_set('Asia/Tokyo');
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

$id="0001";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}


ini_set('auto_detect_line_endings', 1);
$molfile = "";

try {
    //echo $id;
    require_once(__DIR__ . '/getmolfile.php');

}catch (Exception $e){
	print('Error:'.$e->getMessage());
	die();
}
echo $molfile;
?>
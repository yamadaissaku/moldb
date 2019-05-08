<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>
<?php

$file_path = 'sdf/633139487571641872.sdf';
if(isset($_REQUEST['file'])) {
    if ($_REQUEST["file"] != "") {
        $file_path = $_REQUEST["file"];
    }
}

// HTTPヘッダ設定
// ファイルを強制ダウロードする場合↓
// header('Content-Type: application/force-download');
// ファイルの種類は気にしない場合↓
header('Content-Type: application/octet-stream');
header('Content-Length: '. filesize($file_path));
$name = str_replace("sdf/", "", $file_path);
header('Content-Disposition: attachment; filename*=UTF-8\'\'' . rawurlencode($name)); 

// ファイル出力
readfile($file_path);

?>
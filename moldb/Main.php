<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Main</title>
    </head>
    <body>
        <h1>Main</h1>
        
<?php include('menu.php'); ?>


    </body>
</html>
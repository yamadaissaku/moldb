<?php
session_start();

if (isset($_SESSION["NAME"])) {
    $errorMessage = "logout";
} else {
    $errorMessage = "timeout";
}

// セッションの変数のクリア
$_SESSION = array();

// セッションクリア
@session_destroy();
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Logout</title>
    </head>
    <body>
        <h1>Logout</h1>
        <div><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></div>
        <ul>
            <li><a href="Login.php">Login</a></li>
        </ul>
    </body>
</html>
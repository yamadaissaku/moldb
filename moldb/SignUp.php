<?php
// https://github.com/KosukeGit/loginManagement/blob/master/SignUp.php

require 'password.php';   // password_hash()はphp 5.5.0以降の関数のため、バージョンが古くて使えない場合に使用
// セッション開始
session_start();

$groupid = 'MidMol2Pharma';

$db['host'] = "localhost:3306";  // DBサーバのURL
$db['user'] = "mol";  // ユーザー名
$db['pass'] = "mol";  // ユーザー名のパスワード
$db['dbname'] = "loginManagement";  // データベース名

// エラーメッセージ、登録完了メッセージの初期化
$errorMessage = "";
$signUpMessage = "";

// ログインボタンが押された場合
if (isset($_POST["signUp"])) {
    // 1. ユーザIDの入力チェック
    if (empty($_POST["groupid"])) {  // 値が空のとき
        $errorMessage = 'groupidが未入力です。';
    } else if (empty($_POST["username"])) {  // 値が空のとき
        $errorMessage = 'ユーザーIDが未入力です。';
    } else if (empty($_POST["password"])) {
        $errorMessage = 'パスワードが未入力です。';
    } else if (empty($_POST["password2"])) {
        $errorMessage = 'パスワードが未入力です。';
    }

    if (!empty($_POST["groupid"]) && !empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["password2"]) && $_POST["password"] === $_POST["password2"]) {
        
        if ($_POST["groupid"] === $groupid) {
            // 入力したユーザIDとパスワードを格納
            $username = $_POST["username"];
            $password = $_POST["password"];

            // 2. ユーザIDとパスワードが入力されていたら認証する
            $dsn = sprintf('mysql:host=%s; dbname=%s; charset=utf8', $db['user'], $db['pass']);

            // 3. エラー処理
            try {

                $pdo = new PDO("mysql:host=localhost:3306; dbname=loginManagement; charset=utf8", 'mol', 'mol');
                //$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
                //$pdo = new PDO($dsn, $db['user'], $db['pass'], array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));

                $stmt = $pdo->prepare("INSERT INTO userData(name, password) VALUES (?, ?)");

                $stmt->execute(array($username, password_hash($password, PASSWORD_DEFAULT)));  // パスワードのハッシュ化を行う（今回は文字列のみなのでbindValue(変数の内容が変わらない)を使用せず、直接excuteに渡しても問題ない）
                $userid = $pdo->lastinsertid();  // 登録した(DB側でauto_incrementした)IDを$useridに入れる

                $signUpMessage = '登録が完了しました。あなたのIDは '. $username. ' です。パスワードは '. $password. ' です。';  // ログイン時に使用するIDとパスワード
            } catch (PDOException $e) {
                $errorMessage = 'データベースエラー...';
                // $e->getMessage() でエラー内容を参照可能（デバッグ時のみ表示）
                echo $e->getMessage();
            }
            $mess = '';
        }
        else {
            $mess = '正しいグループIDを入力してください。';
        }
    } else if($_POST["password"] != $_POST["password2"]) {
        $errorMessage = 'パスワードに誤りがあります。';
    }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <title>新規登録</title>
    </head>
    <body>
        <h1>新規登録画面</h1>
        <h2><?php if (isset($mess)) echo $mess; ?></h2>
        <form id="loginForm" name="loginForm" action="" method="POST">
            <fieldset>
                <legend>新規登録フォーム</legend>
                <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                <div><font color="#0000ff"><?php echo htmlspecialchars($signUpMessage, ENT_QUOTES); ?></font></div>
                <label for="username">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力" value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                <br>
                <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                <br>
                <label for="password2">パスワード</label><input type="password" id="password2" name="password2" value="" placeholder="再度パスワードを入力">(確認用)
                <br>
                <label for="groupid">group id</label><input type="groupid" id="groupid" name="groupid" value="" placeholder="groupid">
                <br>
                <input type="submit" id="signUp" name="signUp" value="新規登録">
            </fieldset>
        </form>
        <br>
        <form action="Login.php">
            <input type="submit" value="戻る">
        </form>
    </body>
</html>
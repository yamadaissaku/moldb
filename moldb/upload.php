<?php
set_time_limit(0);
include('menu.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>file upload</title>
</head>
<body >
<form enctype="multipart/form-data" method="post" action="upresult.php" >
<input type="file" name="file1"><br>
<input type="submit" value="File upload">
</form>
</body>
</html>
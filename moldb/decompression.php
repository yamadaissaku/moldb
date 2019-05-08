<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Main</title>
    </head>
    <body>
    
<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}


foreach(glob('sdf/{*.zip}', GLOB_BRACE) as $file) {
//foreach(glob('{*.sdf}',GLOB_BRACE) as $file){
    if(is_file($file)){
      $zip = new ZipArchive();

      if ($zip->open($file) === true) {
        if ($zip->extractTo('./sdf/') === true) {
          $zip->close();
        } else {
          exit('extract error.');
        }
      } else {
        exit('open error.');
      }

      echo $file."<br>";
      echo 'complete';
    }
}

foreach(glob('sdf/{*.gz}', GLOB_BRACE) as $file_name) {
//foreach(glob('{*.sdf}',GLOB_BRACE) as $file){
    if(is_file($file_name)){

        //This input should be from somewhere else, hard-coded in this example
        //$file_name = '2013-07-16.dump.gz';

        // Raising this value may increase performance
        $buffer_size = 4096; // read 4kb at a time
        $out_file_name = str_replace('.gz', '', $file_name); 

        // Open our files (in binary mode)
        $file = gzopen($file_name, 'rb');
        $out_file = fopen($out_file_name, 'wb'); 

        // Keep repeating until the end of the input file
        while (!gzeof($file)) {
            // Read buffer-size bytes
            // Both fwrite and gzread and binary-safe
            fwrite($out_file, gzread($file, $buffer_size));
        }

        // Files are done, close files
        fclose($out_file);
        gzclose($file);
    
    }
}
?>

<ul>
		<li><a href="Main.php">Main</a></li>
		<li><a href="mol_table.php">Table</a></li>
		<li><a href="decompression.php">SDF解凍</a></li>
		<li><a href="sdflist.php">SDFile List</a></li>
		<li><a href="Logout.php">ログアウト</a></li>
</ul>

</body>
</html>
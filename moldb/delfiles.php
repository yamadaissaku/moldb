<?php

foreach(glob('json/{*.json}', GLOB_BRACE) as $file) {
//foreach(glob('{*.sdf}',GLOB_BRACE) as $file){
    if(is_file($file)){

		unlink($file);
		echo "delete file: ".$file."<br>";
    }
}
echo "Deleted files";

?>
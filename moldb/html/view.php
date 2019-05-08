
<?php
$id="1";

foreach(glob('{*.html}',GLOB_BRACE) as $file){
    if(is_file($file)){
		//$path = dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$file;
		//$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$file;
		//echo $file."\n";
		//$json = file_get_contents($file);
		$html = file_get_contents($file);
		echo $html."<br>";

    }
}


?>
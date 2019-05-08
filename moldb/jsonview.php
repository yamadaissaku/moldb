
<?php
$id=1;
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}



$html .= "<button><a href=\"jsonview.php?id=".(string)(intval($id) - 1)."\" >Prev</a></button>";
$html .= "<button><a href=\"jsonview.php?id=".(string)(intval($id) + 1)."\" >Next</a></button>";

echo $html;

$path = "./json/".$id.".json";
//echo $i."<br>";
if(is_file($path)){
//$path = dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$file;
//$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$file;
//echo $path."\n";
//$json = file_get_contents($file);
$json = file_get_contents($path);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

echo var_dump($arr);


}







?>
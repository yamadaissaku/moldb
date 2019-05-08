
<?php
$id="1";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}

if (count($argv)>1){
	$id = $argv[1];
}

$path = dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$id.".json";
$json = file_get_contents($path);
$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);
$html .= "";
$html .= "<table border=\"1\">\n";
$html .= "<tr>\n";
$html .= "<td>id</td>\n";
$html .= "<td>\n";
$html .= $arr["id"]."\n";
$html .= "</td>\n";
$html .= "</tr>\n";

$html .= "<tr>\n";
$html .= "<td>image</td>\n";
$html .= "<td>\n";
$imaUrl = "./img.php?id=".intval($arr["id"]);
$html .= "<img border=\"0\" src=\"".$imaUrl."\" height=\"100\" alt=\"molecule image\">\n";
$html .= "</td>\n";
$html .= "</tr>\n";

//echo $arr["molfile"]."\n";
$html .= "<tr>\n";
$html .= "<td>CID</td>\n";
$html .= "<td>\n";
$html .= $arr["PUBCHEM_COMPOUND_CID"]."\n";
$html .= "</td>\n";
$html .= "</tr>\n";

$html .= "<tr>\n";
$html .= "<td>FORMULA</td>\n";
$html .= "<td>\n";
$html .= $arr["PUBCHEM_MOLECULAR_FORMULA"]."\n";
$html .= "</td>\n";
$html .= "<tr>\n";
$html .= "</table>\n";

$fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."html".DIRECTORY_SEPARATOR.$id.".html","w");
fwrite($fp, $html."\n");
fclose($fp);
?>
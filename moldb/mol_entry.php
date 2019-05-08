
<?php
$id=1;
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}


$count=10;
if(isset($_REQUEST['count'])) {
    if ($_REQUEST["count"] != "") {
        $count = $_REQUEST["count"];
    }
}

include('menu.php');

$html = "";

$html .= "<a href=\"mol_entry.php?id=".(string)(intval($id) - 10)."\" class=\"move_button\">Prev</a>";
$html .= "<a href=\"mol_entry.php?id=".(string)(intval($id) + 10)."\" class=\"move_button\">Next</a>";




$html .= "<table border=\"1\">\n";

$html .= "<tr>\n";
$html .= "<th>id</th>\n";
$html .= "<th>image</th>\n";
$html .= "<th>CID</th>\n";
$html .= "<th>FORMULA</th>\n";
$html .= "<th>CHARGE</th>\n";

$html .= "<th>COMPLEXITY</th>\n";
$html .= "<th>ROTATABLE_BOND</th>\n";
$html .= "<th>HEAVY_ATOM_COUNT</th>\n";


$html .= "</tr>\n";

$max = $id+$count;

for ($i=$id; $i<$max; $i++) { 
    $path = "./json/".$i.".json";
    //echo $i."<br>";
    if(is_file($path)){
    //$path = dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$file;
    //$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$file;
    //echo $file."\n";
    //$json = file_get_contents($file);
    $json = file_get_contents($path);
    $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
    $arr = json_decode($json,true);

    //echo $arr["id"]."\n";



    $html .= "<tr>\n";
    //$html .= "<td>id</td>\n";
    $html .= "<td>\n";
    $html .= $arr["id"]."\n";
    $html .= "</td>\n";
    //$html .= "</tr>\n";

    //$html .= "<tr>\n";
    //$html .= "<td>image</td>\n";
    $html .= "<td>\n";
    $imaUrl = "./img.php?id=".intval($arr["id"]);
    $html .= "<img border=\"0\" src=\"".$imaUrl."\" height=\"auto\"width=\"300\" alt=\"image\">\n";
    $html .= "</td>\n";
    //$html .= "</tr>\n";

    //echo $arr["molfile"]."\n";

    //$html .= "<tr>\n";
    //$html .= "<td>CID</td>\n";
    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_COMPOUND_CID"]."\n";
    $html .= "</td>\n";
    //$html .= "</tr>\n";

    //$html .= "<tr>\n";
    //$html .= "<td>FORMULA</td>\n";
    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_MOLECULAR_FORMULA"]."\n";
    $html .= "</td>\n";






    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_CACTVS_COMPLEXITY"]."\n";
    $html .= "</td>\n";

    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_CACTVS_ROTATABLE_BOND"]."\n";
    $html .= "</td>\n";

    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_HEAVY_ATOM_COUNT"]."\n";
    $html .= "</td>\n";


    
    $html .= "<td>\n";
    $html .= $arr["PUBCHEM_TOTAL_CHARGE"]."\n";
    $html .= "</td>\n";

    $id = intval($arr["id"]);
    //echo $id."\n";
    //$savePath = dirname(__FILE__).DIRECTORY_SEPARATOR."html".DIRECTORY_SEPARATOR.$id.".html";
    //echo $savePath."\n";
    //$fp = fopen($savePath,"w");
    //$fp = fopen("html".DIRECTORY_SEPARATOR.$id.".html","w");
    //fwrite($fp, $html."\n");
    //fclose($fp);
    $html .= "</tr>\n";
    }
}


$html .= "</table>\n";

echo $html;

?>
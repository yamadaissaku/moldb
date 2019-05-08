
<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}


$id="1";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}

foreach(glob('json/{*.json}',GLOB_BRACE) as $file){
    if(is_file($file)){
    	if ($file === "json/".$id.".json") {
			//$path = dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$file;
			//$path = dirname(__FILE__).DIRECTORY_SEPARATOR.$file;
			//echo $file."\n";
			//$json = file_get_contents($file);
			$json = file_get_contents($file);
			$json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
			$arr = json_decode($json,true);

			//echo $arr["id"]."\n";

			$html = "";
			$html .= "<table border=\"1\">\n";

			$html .= "<tr>\n";

			$html .= "<th>id</th>\n";
			$html .= "<th>CID</th>\n";			
			$html .= "<th>PUBCHEM_IUPAC_CAS_NAME</th>\n";

			$html .= "<th>FORMULA</th>\n";

			$html .= "<th>CHARGE</th>\n";
			$html .= "<th>COMPLEXITY</th>\n";
			$html .= "<th>ROTATABLE_BOND</th>\n";
			$html .= "<th>HEAVY_ATOM_COUNT</th>\n";
			$html .= "<th>image</th>\n";




			$html .= "</tr>\n";


			$html .= "<tr>\n";
			//$html .= "<td>id</td>\n";
			$html .= "<td>\n";
			$html .= $arr["id"]."\n";
			$html .= "</td>\n";
			//$html .= "</tr>\n";

			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_COMPOUND_CID"])){
				$html .= $arr["PUBCHEM_COMPOUND_CID"]."\n";
			}
			$html .= "</td>\n";
		
			$html .= "<td>\n";
		
			if(isset ($arr["PUBCHEM_IUPAC_CAS_NAME"])){
				$html .= $arr["PUBCHEM_IUPAC_CAS_NAME"]."\n";
			} 
			$html .= "</td>\n";
		
		
			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_MOLECULAR_FORMULA"])){
				$html .= $arr["PUBCHEM_MOLECULAR_FORMULA"]."\n";
			}
			$html .= "</td>\n";
		
			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_TOTAL_CHARGE"])){
				$html .= $arr["PUBCHEM_TOTAL_CHARGE"]."\n";
			}
			$html .= "</td>\n";
		
			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_CACTVS_COMPLEXITY"])){
				$html .= $arr["PUBCHEM_CACTVS_COMPLEXITY"]."\n";
			}
			$html .= "</td>\n";
		
			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_CACTVS_ROTATABLE_BOND"])){
				$html .= $arr["PUBCHEM_CACTVS_ROTATABLE_BOND"]."\n";
			}
			$html .= "</td>\n";
		
			$html .= "<td>\n";
			if(isset ($arr["PUBCHEM_HEAVY_ATOM_COUNT"])){
				$html .= $arr["PUBCHEM_HEAVY_ATOM_COUNT"]."\n";
			}
			$html .= "</td>\n";

			$html .= "<td>\n";
			$imaUrl = "./img.php?id=".intval($arr["id"]);
			$html .= "<img border=\"0\" src=\"".$imaUrl."\" height=\"200\" alt=\"image\">\n";
			$html .= "</td>\n";


			$html .= "<tr>\n";
			$html .= "</table>\n";

			echo $html;

			//$id = intval($arr["id"]);
			//echo $id."\n";
			//$savePath = dirname(__FILE__).DIRECTORY_SEPARATOR."html".DIRECTORY_SEPARATOR.$id.".html";
			//echo $savePath."\n";
			//$fp = fopen($savePath,"w");
			//$fp = fopen("html".DIRECTORY_SEPARATOR.$id.".html","w");
			//fwrite($fp, $html."\n");
			//fclose($fp);
		}

    }
}


?>
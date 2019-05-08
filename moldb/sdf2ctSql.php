<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

//header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);

$file = "Compound_000175001_000200000.sdf";
date_default_timezone_set('Asia/Tokyo');

if(isset($_REQUEST['file'])) {
    if ($_REQUEST["file"] != "") {
        $file = $_REQUEST["file"];
    }
}


$fp = fopen($file,"r");
//$wfp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."xml".DIRECTORY_SEPARATOR.$sdfile."_.xml","a");
//$wfp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$sdfile.".json","a");

$data = "";

//$jsonstr =  json_encode($value_array, JSON_UNESCAPED_UNICODE);

$idcount = 1;
/*
fwrite($wfp, "<?xml version=\"1.0\"?>\n<moldb>\n");
*/
$tag = array();
$tag_data = array();

$tagArray = array();
$tag_dataArray = array();

$arr_mol = array();
while (!feof($fp)) {
   $line = fgets($fp);


  //if ($idcount < 401) {
  if(strpos($line,'$$$$')!== false){
//    $wfp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$idcount.".json","w");
    $mol = explode("M  END", $data);
    //fwrite($wfp, "<molecule>\n");
    $tag = array();
    $tag_data = array();


    $idString = str_pad($idcount, 4, 0, STR_PAD_LEFT);
    $id = array('id'=>$idString);
    $tag[] = 'molid';
    $tag_data[] = $idString;
    

    //fwrite($wfp, "<id>".$idString."</id>\n");
    if (count($mol)>0){
      //fwrite($wfp, "<molfile>\n<![CDATA[".$mol[0]."]]>\n</molfile>\n");
      //fwrite($wfp, "<molfile>".$mol[0]."</molfile>\n");
      //$molfile = array_merge($hoge,array('molfile'=>$mol[0]));

      $tag[] = 'mol2d';
      $tag_data[] = $mol[0]."M  END";

    }
    if (count($mol)>1){
      //$pattern '/> <([!-~]+)>\n([a-zA-Z0-9_\n\s]+)\n/';
      //echo $mol[1];
      
      //$num2 = preg_match_all('/> <([a-zA-Z0-9_  ]+)>\n([a-zA-Z0-9\(\)\[\]\\-,_\n\s ;:\'\\.\\^\\~\\{\\}\\+]+)\n\n/',$mol[1],$matches);
      $num2 = preg_match_all('/> <([a-zA-Z0-9_  ]+)>\n([^<^>]+)\n\n/',$mol[1],$matches);
      //$num2 = preg_match_all('/> <([!-~]+)>([a-zA-Z0-9_\n\s]+)/',$mol[1],$matches);
      //$num2 = preg_match_all('/> <([!-~]+)>([a-zA-Z0-9_\s]+)\\\\n/',$mol[1],$matches);

      //echo var_dump($matches);



      foreach ($matches[1] as $mat) {
        $tag[] = $mat;
        
      }
      foreach ($matches[2] as $mat_d) {
        $tag_data[] = $mat_d;
      }


      //for ($i=0; $i<count($tag); $i++) {        
          //fwrite($wfp, "<".$tag[$i].">\n");
          //$hoge = array_merge($hoge,array($tag[$i]=>$tag_data[$i]));
//          fwrite($wfp, "<![CDATA[".$tag_data[$i]."]]>\n");
          //fwrite($wfp, $tag_data[$i]);
          //fwrite($wfp, "</".$tag[$i].">\n");
      //}
      //echo var_dump($tag);
      //echo var_dump($tag_data);

      //fwrite($wfp, $mol[1]);
    }
    //fwrite($wfp, "</molecule>\n");


//    $jsonstr =  json_encode($hoge, JSON_UNESCAPED_UNICODE);
    //echo $jsonstr;
//    fwrite($wfp, $jsonstr."\n");

//    echo $idString."\n";
    $idcount++;
    $data = "";
//    fclose($wfp);

  $tagArray[] = $tag;
  $tag_dataArray[] = $tag_data;

  }
  else {
    //$data = $data.str_replace("\n", "\\n", $line);
    //$data = $data.str_replace("\n", "\\n", $line);
    $data = $data.$line;
    //$data = $data.rtrim($line, "\n");
  }
//}
}
//fwrite($wfp, "</moldb>");

//fclose($wfp);
fclose($fp);


$keyarray = array();
foreach ($tagArray as $arr){
  foreach ($arr as $val){
    if (!in_array($val, $keyarray, true)) {
      $keyarray[] = $val;
    }
  }
}

$unique = array_unique($keyarray);

$sql = "CREATE TABLE testmol.pubchem (
id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
";



for ($i=0; $i<count($unique); $i++) {        
  $data = $unique[$i];
  $replace = str_replace(' ', '_', $data);
  if ($replace !=null && $replace != ""){
    $sql .= $replace." TEXT,\n";
  }
}
$sql .= "created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP\n);";



?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SQL</title>
</head>
<body>
<?php
echo $sql."<hr>";

/**
 * MySQLに接続
 */
try{
  //$dbh = new PDO($dsn, $user, $password);
  $dbh = new PDO("mysql:host=localhost:3306; dbname=testmol; charset=utf8", 'mol', 'mol');
  print('接続に成功しました。<br>');
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
/**
* デーブルの削除
*/
try{
  $stmt = $dbh->query("DROP TABLE IF EXISTS testmol.pubchem");
  $results = $stmt->fetchall();
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
  die();
}
/**
* テーブルの作成
*/
$create_sql = $sql;
$stmt = $dbh->query($create_sql);

echo 'created table<hr>';

/**
 * データの挿入
 */
//$insert_sql = 'ここから';
//$stmt = $dbh->query($insert_sql);
//$results = $stmt->fetchall();



$insert_contents = array();
for ($i=0; $i<count($tag); $i++) {        
  $data = $tag[$i];
  $replace = str_replace(' ', '_', $data);
  $insert_contents[] = $replace;
}


// データ挿入
// $tagArray[] = $tag;
// $tag_dataArray[] = $tag_data;

//foreach($tagArray as $tagv){
$datacount = 0;
for ($j=0; $j<count($tagArray); $j++) {  
  $datacount = $j+1;
echo $datacount.",";
$insert_sql = "INSERT INTO testmol.pubchem (
  ";  
  
  for ($i=0; $i<count($tagArray[$j]); $i++) {        
    $data = $tagArray[$j][$i];
    $replace = str_replace(' ', '_', $data);
    $insert_sql .= $replace;
    if ($i<count($tagArray[$j])-1){
      $insert_sql .= ",\n";
    }
    else {
      $insert_sql .= " ) VALUES (";
    }
  }
  $insert_sql .= " "; 
  for ($i=0; $i<count($tagArray[$j]); $i++) {        
    $data = $tagArray[$j][$i];
    $replace = str_replace(' ', '_', $data);
    $insert_sql .= " :".$replace;
    if ($i<count($tagArray[$j])-1){
      $insert_sql .= ",\n";
    }
    else {
      $insert_sql .= " )";
    }
  }
  $insert_sql .= ";";

//echo $insert_sql."<hr>";

//$insert_sql = "INSERT INTO testmol.pubchem (name, category, description) VALUES (:name, :category, :description)"; // INSERT文を変数に格納。:nameや:categoryはプレースホルダという、値を入れるための単なる空箱
$stmt = $dbh->prepare($insert_sql); //挿入する値は空のまま、SQL実行の準備をする




//$params = array(':name' => $name, ':category' => $category, ':description' => $description); // 挿入する値を配列に格納する
$params = array();
for ($i=0; $i<count($tagArray[$j]); $i++) { 
  //$key = "':".$tagArray[$j][$i]."'";
  $key = ":".$tagArray[$j][$i];
  $val = $tag_dataArray[$j][$i];
  $params[$key] = $val;
  //echo $key." => ".$val."<br>";
}

//$params = array();
//$hoge['key2'] = 'value2';



$stmt->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行



}
echo "count of inserted data: ".$datacount."<br>";
echo '<br />データ挿入<br /><hr>';





/* データの取得
 * PDO::FETCH_ASSOC 連想配列で返すフラグみたいなもの
 */
$stmt = $dbh->query("SELECT COUNT(id) FROM testmol.pubchem GROUP BY id;");
$results = $stmt->fetchall(PDO::FETCH_ASSOC);
echo '<br />データ確認<br />';
var_dump($results);

?>
</body>
</html>
<?php
//header('Content-Type: text/plain;charset=UTF-8');
ini_set('auto_detect_line_endings', 1);

$sdfile = "Compound_000175001_000200000.sdf";
date_default_timezone_set('Asia/Tokyo');


$fp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR.$sdfile,"r");
//$wfp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."xml".DIRECTORY_SEPARATOR.$sdfile."_.xml","a");

$data = "";

//$jsonstr =  json_encode($value_array, JSON_UNESCAPED_UNICODE);

$idcount = 1;
/*
fwrite($wfp, "<?xml version=\"1.0\"?>\n<moldb>\n");
*/
$arr_mol = array();
while (!feof($fp)) {
   $line = fgets($fp);

  if ($idcount < 1) {
  if(strpos($line,'$$$$')!== false){
    $wfp = fopen(dirname(__FILE__).DIRECTORY_SEPARATOR."json".DIRECTORY_SEPARATOR.$sdfile."-".$idcount.".json","a");
    $mol = explode("M  END", $data);
    //fwrite($wfp, "<molecule>\n");
    $idString = str_pad($idcount, 4, 0, STR_PAD_LEFT);

    $hoge = array('id'=>$idString);
    

    //fwrite($wfp, "<id>".$idString."</id>\n");
    if (count($mol)>0){
      //fwrite($wfp, "<molfile>\n<![CDATA[".$mol[0]."]]>\n</molfile>\n");
      //fwrite($wfp, "<molfile>".$mol[0]."</molfile>\n");
      $hoge = array_merge($hoge,array('molfile'=>$mol[0]));
    }
    if (count($mol)>1){
      //$pattern '/> <([!-~]+)>\n([a-zA-Z0-9_\n\s]+)\n/';
      //echo $mol[1];
      //$num2 = preg_match_all('/> <([!-~]+)>\n([a-zA-Z0-9_\n\s]+)\n/',$mol[1],$matches);
      $num2 = preg_match_all('/> <([!-~]+)>([a-zA-Z0-9_\n\s]+)/',$mol[1],$matches);
      //$num2 = preg_match_all('/> <([!-~]+)>([a-zA-Z0-9_\s]+)\\\\n/',$mol[1],$matches);

      echo var_dump($matches);

      $tag = array();
      $tag_data = array();

      foreach ($matches[1] as $mat) {
        $tag[] = $mat;
      }
      foreach ($matches[2] as $mat_d) {
        $tag_data[] = $mat_d;
      }


      for ($i=0; $i<count($tag); $i++) {        
          //fwrite($wfp, "<".$tag[$i].">\n");
          $hoge = array_merge($hoge,array($tag[$i]=>$tag_data[$i]));
//          fwrite($wfp, "<![CDATA[".$tag_data[$i]."]]>\n");
          //fwrite($wfp, $tag_data[$i]);
          //fwrite($wfp, "</".$tag[$i].">\n");
      }
      //echo var_dump($tag);
      //echo var_dump($tag_data);

      //fwrite($wfp, $mol[1]);
    }
    //fwrite($wfp, "</molecule>\n");


    $jsonstr =  json_encode($hoge, JSON_UNESCAPED_UNICODE);
    echo $jsonstr;

    echo $idString."\n";
    $idcount++;
    $data = "";
    fclose($wfp);
  }
  else {
    //$data = $data.str_replace("\n", "\\n", $line);
    $data = $data.$line;
  }
}
}
//fwrite($wfp, "</moldb>");

//fclose($wfp);
fclose($fp);
?>
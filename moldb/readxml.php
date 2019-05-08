<?php

	$sdfile = "Compound_000175001_000200000.sdf";
	$path = dirname(__FILE__).DIRECTORY_SEPARATOR."xml".DIRECTORY_SEPARATOR.$sdfile."_.xml";

    $xml = simplexml_load_file($path); //XML ファイルの URL を指定
    var_dump( $xml ); //構造を分かりやすく出力
?>
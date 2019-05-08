<?php

class Molecule {
    var $id; // molecule id
    var $molfile;
    /*
    var $name;  // aa name
    var $symbol;    // three letter symbol
    var $code;  // one letter code
    var $type;  // hydrophobic, charged or neutral
    */

    function Molecule ($aa) 
    {
        foreach ($aa as $k=>$v)
            $this->$k = $aa[$k];
    }
}

function readDatabase($filename, $id) 
{
    // read the XML database of Molecules
    $data = implode("", file($filename));
    $parser = xml_parser_create();
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, $data, $values, $tags);
    xml_parser_free($parser);

    // loop through the structures
    foreach ($tags as $key=>$val) {
        if ($key == "molecule") {
            $molranges = $val;
            // each contiguous pair of array entries are the 
            // lower and upper range for each molecule definition
            for ($i=0; $i < count($molranges); $i+=2) {
                //echo $molranges[$i]["value"];
                $offset = $molranges[$i] + 1;
                $len = $molranges[$i + 1] - $offset;
                $tdb[] = parseMol(array_slice($values, $offset, $len));
            }
        } else {
            continue;
        }
    }
    return $tdb;
}

function parseMol($mvalues) 
{
    for ($i=0; $i < count($mvalues); $i++) {
        $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
    }
    return new Molecule($mol);
}

$sdfile = "Compound_000175001_000200000.sdf";
$path = dirname(__FILE__).DIRECTORY_SEPARATOR."xml".DIRECTORY_SEPARATOR.$sdfile."_.xml";
$db = readDatabase($path, 1);
//$db = readDatabase("moldb.xml", 1);
echo "** Database of Molecule objects:\n";
print_r($db);

?>
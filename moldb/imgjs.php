<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="http://boscoh.com/code/ChemDoodleWeb/ChemDoodleWeb-libs.js"></script>
<script type="text/javascript" src="http://boscoh.com/code/ChemDoodleWeb/ChemDoodleWeb.js"></script>
</head>



<title></title>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js" type="text/javascript">
</script><![endif]-->
<header id="head"><h1></h1></header>

<body>

<?php
$molfile = "";
try {
    //echo $id;
    require_once(__DIR__ . '/getmolfile.php');

}catch (Exception $e){
	print('Error:'.$e->getMessage());
	die();
}
?>

<script>
  var size = 10;
  var factor = 0.23043017839057;
//  var factor = 0.1;
  var viewACS = new ChemDoodle.ViewerCanvas('viewACS', 100 * size, 100 * size);
  viewACS.specs.bonds_width_2D = .6 * size;
  viewACS.specs.bonds_saturationWidth_2D = .18 * size * factor;
  viewACS.specs.bonds_hashSpacing_2D = 2.5 * size * factor;
  viewACS.specs.atoms_font_size_2D = 5 * size;
  viewACS.specs.atoms_font_families_2D = ['Helvetica', 'Arial', 'sans-serif'];
  viewACS.specs.atoms_displayTerminalCarbonLabels_2D = false;
  var caffeineMolFile = <?php $mol = str_replace("\n", '\\n', $molfile); echo"'".$mol."'"; ?>;
  //var caffeineMolFile = '134692085\n  -OEChem-02021922062D\n\n 57 60  0     1  0  0  0  0  0999 V2000\n    2.9866    3.5724    0.0000 S   0  0  0  0  0  0  0  0  0  0  0  0\n    6.2680   -3.2185    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    6.2494   -4.9760    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    2.4900    2.7044    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    3.4833    4.4403    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    2.1187    4.0690    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    3.8546    3.0757    0.0000 O   0  0  0  0  0  0  0  0  0  0  0  0\n    3.9180   -2.4402    0.0000 C   0  0  3  0  0  0  0  0  0  0  0  0\n    4.7840   -2.9402    0.0000 C   0  0  2  0  0  0  0  0  0  0  0  0\n    4.8001   -3.9817    0.0000 C   0  0  2  0  0  0  0  0  0  0  0  0\n    3.9180   -1.4402    0.0000 C   0  0  1  0  0  0  0  0  0  0  0  0\n    3.0080   -2.9470    0.0000 C   0  0  1  0  0  0  0  0  0  0  0  0\n    5.6501   -2.4402    0.0000 C   0  0  1  0  0  0  0  0  0  0  0  0\n    3.9021   -4.5094    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    3.0080   -0.9333    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    4.7840   -0.9402    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    3.0000   -3.9886    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    3.0000    0.1083    0.0000 C   0  0  1  0  0  0  0  0  0  0  0  0\n    5.6501   -1.4402    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    5.7881   -4.0888    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    4.8001    0.1014    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    3.9021    0.6291    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    5.3101   -4.8418    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    2.1478   -2.4370    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    2.4967    0.9724    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    2.0000    0.1044    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    2.9933    1.8403    0.0000 C   0  0  0  0  0  0  0  0  0  0  0  0\n    3.3835   -2.1260    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    4.0479   -3.3652    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    4.6541   -1.8652    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.0164   -2.3270    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    6.4527   -2.1603    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.5048   -4.9854    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    4.3030   -4.9823    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.3964   -0.8319    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.8035   -1.5186    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.3900   -3.8778    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.7864   -4.5707    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    6.1870   -1.1302    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    5.4093   -0.0141    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    5.0181    0.6818    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    4.3030    1.1020    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.5048    1.1051    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    4.7768   -5.1580    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    5.6263   -5.3752    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    5.8434   -4.5257    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.4640   -1.9037    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    1.6145   -2.1208    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    1.8316   -2.9703    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.0202    1.3691    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.0232    0.5720    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    1.9976    0.7244    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    1.3800    0.1021    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    2.0024   -0.5156    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.4698    1.4436    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.4667    2.2407    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n    3.1712    4.9760    0.0000 H   0  0  0  0  0  0  0  0  0  0  0  0\n  1  4  1  0  0  0  0\n  1  5  1  0  0  0  0\n  1  6  2  0  0  0  0\n  1  7  2  0  0  0  0\n  2 13  1  0  0  0  0\n  2 20  1  0  0  0  0\n  3 20  2  0  0  0  0\n  4 27  1  0  0  0  0\n  5 57  1  0  0  0  0\n  8  9  1  0  0  0  0\n  8 11  1  0  0  0  0\n  8 12  1  0  0  0  0\n  8 28  1  0  0  0  0\n  9 10  1  0  0  0  0\n  9 13  1  0  0  0  0\n  9 29  1  6  0  0  0\n 10 14  1  0  0  0  0\n 10 20  1  0  0  0  0\n 10 23  1  6  0  0  0\n 11 15  1  0  0  0  0\n 11 16  1  0  0  0  0\n 11 30  1  6  0  0  0\n 12 17  1  0  0  0  0\n 12 24  1  0  0  0  0\n 12 31  1  0  0  0  0\n 13 19  1  0  0  0  0\n 13 32  1  6  0  0  0\n 14 17  1  0  0  0  0\n 14 33  1  0  0  0  0\n 14 34  1  0  0  0  0\n 15 18  1  0  0  0  0\n 15 35  1  0  0  0  0\n 15 36  1  0  0  0  0\n 16 19  2  0  0  0  0\n 16 21  1  0  0  0  0\n 17 37  1  0  0  0  0\n 17 38  1  0  0  0  0\n 18 22  1  0  0  0  0\n 18 25  1  0  0  0  0\n 18 26  1  1  0  0  0\n 19 39  1  0  0  0  0\n 21 22  1  0  0  0  0\n 21 40  1  0  0  0  0\n 21 41  1  0  0  0  0\n 22 42  1  0  0  0  0\n 22 43  1  0  0  0  0\n 23 44  1  0  0  0  0\n 23 45  1  0  0  0  0\n 23 46  1  0  0  0  0\n 24 47  1  0  0  0  0\n 24 48  1  0  0  0  0\n 24 49  1  0  0  0  0\n 25 27  1  0  0  0  0\n 25 50  1  0  0  0  0\n 25 51  1  0  0  0  0\n 26 52  1  0  0  0  0\n 26 53  1  0  0  0  0\n 26 54  1  0  0  0  0\n 27 55  1  0  0  0  0\n 27 56  1  0  0  0  0\nM  END';
//  var caffeineMolFile = 'Molecule Name\n  CHEMDOOD08070920033D 0   0.00000     0.00000     0\n[Insert Comment Here]\n 14 15  0  0  0  0  0  0  0  0  1 V2000\n   -0.3318    2.0000    0.0000   O 0  0  0  1  0  0  0  0  0  0  0  0\n   -0.3318    1.0000    0.0000   C 0  0  0  1  0  0  0  0  0  0  0  0\n   -1.1980    0.5000    0.0000   N 0  0  0  1  0  0  0  0  0  0  0  0\n    0.5342    0.5000    0.0000   C 0  0  0  1  0  0  0  0  0  0  0  0\n   -1.1980   -0.5000    0.0000   C 0  0  0  1  0  0  0  0  0  0  0  0\n   -2.0640    1.0000    0.0000   C 0  0  0  4  0  0  0  0  0  0  0  0\n    1.4804    0.8047    0.0000   N 0  0  0  1  0  0  0  0  0  0  0  0\n    0.5342   -0.5000    0.0000   C 0  0  0  1  0  0  0  0  0  0  0  0\n   -2.0640   -1.0000    0.0000   O 0  0  0  1  0  0  0  0  0  0  0  0\n   -0.3318   -1.0000    0.0000   N 0  0  0  1  0  0  0  0  0  0  0  0\n    2.0640   -0.0000    0.0000   C 0  0  0  2  0  0  0  0  0  0  0  0\n    1.7910    1.7553    0.0000   C 0  0  0  4  0  0  0  0  0  0  0  0\n    1.4804   -0.8047    0.0000   N 0  0  0  1  0  0  0  0  0  0  0  0\n   -0.3318   -2.0000    0.0000   C 0  0  0  4  0  0  0  0  0  0  0  0\n  1  2  2  0  0  0  0\n  3  2  1  0  0  0  0\n  4  2  1  0  0  0  0\n  3  5  1  0  0  0  0\n  3  6  1  0  0  0  0\n  7  4  1  0  0  0  0\n  4  8  2  0  0  0  0\n  9  5  2  0  0  0  0\n 10  5  1  0  0  0  0\n 10  8  1  0  0  0  0\n  7 11  1  0  0  0  0\n  7 12  1  0  0  0  0\n 13  8  1  0  0  0  0\n 13 11  2  0  0  0  0\n 10 14  1  0  0  0  0\nM  END\n> <DATE>\n07-08-2009\n';
  var caffeine = ChemDoodle.readMOL(caffeineMolFile);
//  caffeine.scaleToAverageBondLength(14.4 * size);
  caffeine.scaleToAverageBondLength(10 * size);
  viewACS.loadMolecule(caffeine);
</script>



</body>
</html>
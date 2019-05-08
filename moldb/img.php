<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}

$id="0001";
if(isset($_REQUEST['id'])) {
    if ($_REQUEST["id"] != "") {
        $id = $_REQUEST["id"];
    }
}
$imgSize = 300;
if(isset($_GET['size'])) {
	$imgSize = $_GET['size'];
}
$viewid = "true";
if(isset($_GET['viewid'])) {
	$viewid = $_GET['viewid'];
}


ini_set('auto_detect_line_endings', 1);

header("content-type: image/png");
$image = imagecreate(300, 300); 


//session_start();

$molfile = "";

try {
    //echo $id;
    require_once(__DIR__ . '/getmolfile.php');

}catch (Exception $e){
	print('Error:'.$e->getMessage());
	die();
}
//echo $molfile;
$molfile = str_replace("\n", '\\n', $molfile);

try {
if (strlen($molfile) > 5) {
	$atoms = explode("\\n", $molfile);
	$count = 0;
	$atomX = array();
	$atomY = array();
	$atomS = array();
	$atomcount = 0;
	$bond1 = array();
	$bond2 = array();
	$bondt = array();
	$bonds = array();
	$bondcount = 0;
	$atomNumber = 0;
	$bondNumber = 0;
	foreach ($atoms as &$value){	
		if ($count > 2) {
			if ($count < 3) {
			}
			else if ($count == 3){
				$atomNumber = (int)substr($value, 0, 3);
				$bondNumber = (int)substr($value, 3, 3);
			}
			else if ($count <= (3 + $atomNumber)) {
				$atomX[$atomcount] = (float)substr($value, 0, 9);
				$atomY[$atomcount] = (float)substr($value, 10, 10);
				$atomS[$atomcount] = trim(substr($value, 30, 3));
				$atomcount++;
			}
			else {
				if (strlen($value) > 10) {
					$bond1[$bondcount] = (int)substr($value, 0, 3);
					$bond2[$bondcount] = (int)substr($value, 3, 3);
					$bondt[$bondcount] = (int)substr($value, 6, 3);
					$bonds[$bondcount] = (int)substr($value, 9, 3);
					$bondcount++;
				}
			}
		}
		$count++;
	}
	$maxX = max($atomX);
	$maxY = max($atomY);
	$minX = min($atomX);
	$minY = min($atomY);
	$Xsize = abs($maxX - $minX);
	$Ysize = abs($maxY - $minY);
	$imagesizeY = (int)($imgSize * $Ysize / $Xsize);
	$image = imagecreate($imgSize, $imagesizeY); 
	//背景色
	$back = imagecolorallocate($image, 255, 255, 255); 
	//文字の色
	$text_color = imagecolorallocate($image, 0, 0, 0);
	$white_color = imagecolorallocate($image, 255, 255, 255);
	$red_color = imagecolorallocate($image, 255, 0, 0);
	// イメージのサイズを基準とした線の太さ設定
	imagesetthickness($image, 1);
	$linewidth = (int)($imgSize / 180);
	imagesetthickness($image, $linewidth );
	//表示サイズの調整
	$factor =  100;
	if ($Xsize != 0) {
		$factor = $imgSize * 0.9 / $Xsize;
	}
	//bond
	$count = 0;
	$bondwidthPara = 3;
	for ($count = 0; $count < count($bond1); $count++){

		if ($bond1[$count] > 0 && $bond2[$count] > 0) { 
			$x1 = (int)(($atomX[$bond1[$count] - 1] - $minX) * $factor + $imgSize * 0.05);
			$y1 = (int)(abs(($atomY[$bond1[$count] - 1] - $maxY)) * $factor + $imagesizeY * 0.05);
			$x2 = (int)(($atomX[$bond2[$count] - 1] - $minX) * $factor + $imgSize * 0.05);
			$y2 = (int)(abs(($atomY[$bond2[$count] - 1] - $maxY)) * $factor + $imagesizeY * 0.05);
		


			if ($bondt[$count] == 1) {		
				
				if ($bonds[$count] === 0) {
					imageline( $image, $x1, $y1, $x2, $y2, $text_color );
				}
				else if ($bonds[$count] === 1) {
					imagesetthickness($image, $linewidth  * $bondwidthPara);
					imageline( $image, $x1, $y1, $x2, $y2, $text_color );
					imagesetthickness($image, $linewidth );
				}
				else if ($bonds[$count] === 6) {
					imagesetthickness($image, $linewidth  * $bondwidthPara);
					imagedashedline( $image, $x1, $y1, $x2, $y2, $text_color );
					imagesetthickness($image, $linewidth );
				}
				else {
	                $nyoro_color = imagecolorallocate($image, 255, 255, 0);
    	            imageline( $image, $x1, $y1, $x2, $y2, $nyoro_color );
				}
			}
			else if ($bondt[$count] == 2) {
				imagesetthickness($image, $linewidth  * $bondwidthPara);
				imageline( $image, $x1, $y1, $x2, $y2, $text_color );
				//white_color
				imagesetthickness($image, (int)($linewidth * ($bondwidthPara * 0.5)));
				imageline( $image, $x1, $y1, $x2, $y2, $back );
				imagesetthickness($image, $linewidth );
			}
			else if ($bondt[$count] == 3) {
				imagesetthickness($image, $linewidth  * $bondwidthPara * 1.8);
				imageline( $image, $x1, $y1, $x2, $y2, $text_color );

				imagesetthickness($image, (int)($linewidth * ($bondwidthPara)) );
				imageline( $image, $x1, $y1, $x2, $y2, $back );
				imagesetthickness($image, $linewidth );
				imageline( $image, $x1, $y1, $x2, $y2, $text_color );
			}
			else {
	                $nyoro_color = imagecolorallocate($image, 255, 255, 0);
    	            imageline( $image, $x1, $y1, $x2, $y2, $nyoro_color );
				}
			}
	}
	// atomic symbol
	//TTFフォントのパス
	$font_path = "./mplus-1mn-medium.ttf";
	//フォントサイズ
	$font_size = 10;
	$xyorder = $Xsize - $Ysize;
	if ($xyorder > 0){
		$font_size = (int)($imgSize * 0.03) ;	
	}
	else {
		$font_size = (int)($imagesizeY * 0.05 ) ;
	}
	$text_color = imagecolorallocate($image, 255, 0, 0);
	if ($viewid == "true") {
		imagettftext($image, 
					(int)($font_size / 2), 
					0, 
					10, 
					50, 
					$text_color, 
					$font_path, 
					"id:".strval($id));
	}
	$count = 0;
	for ($count = 0; $count < count($atomX); $count++){
		$text_color = imagecolorallocate($image, 0, 0, 0);
		if ($atomS[$count] !== "C") {
			if ($atomS[$count] === "O") {
				$text_color = imagecolorallocate($image, 255, 0, 0);
			}
			else if ($atomS[$count] === "N") {
				$text_color = imagecolorallocate($image, 0, 0, 255);
			}
			$x1 = (int)((
				$atomX[$count] - $minX) * $factor 
				+ $imgSize * 0.05 
				- $font_size * 0.5);		
			$y1 = (int)(
				abs(($atomY[$count] - $maxY)) * $factor 
				+ $imagesizeY * 0.05 
				+ $font_size * 0.5);
			ImageFilledRectangle( $image, 
				$x1, 
				$y1 - $font_size, 
				$x1 + $font_size, 
				$y1, 
				$white_color );
			imagettftext($image, 
				$font_size, 
				0, 
				(int)($x1 + $font_size * 0.2), 
				$y1, 
				$text_color, 
				$font_path, 
				$atomS[$count]);
		}
	}
}
else {
	$image = imagecreate(250, 100); 
	$back = imagecolorallocate($image, 255, 255, 255); 
	//文字の色
	$text_color = imagecolorallocate($image, 0, 0, 0);
	$font_path = "./mplus-1mn-medium.ttf";
	//フォントサイズ
	$font_size = 50;
	$text_color = imagecolorallocate($image, 255, 0, 0);
	imagettftext($image, 
				(int)($font_size / 2), 
				0, 
				20, 
				50, 
				$text_color, 
				$font_path, 
				"not found!");
}
 //png画像の出力
imagepng($image);
//画像の保存
imagepng($image, './img/'.$id.'.png');
//リソース開放
imagedestroy($image);
}catch (Exception $e){
	print('Error:'.$e->getMessage());
	die();
}

?>
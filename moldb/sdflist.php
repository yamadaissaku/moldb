<?php
session_start();

// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Main</title>
    </head>
    <body>
<?php
$count = 0;

$html = "<table border=\"1\">\n";
$html .= "<tr>\n";
$html .= "<th>count</th>\n";
$html .= "<th>File name</th>\n";
$html .= "<th>JSON DB update</th>\n";
$html .= "<th>RDB SQL</th>\n";
$html .= "<th>SDFダウンロード</th>\n";
$html .= "<th>Date</th>\n";
$html .= "<th>Size</th>\n";
$html .= "</tr>\n";



//検索するディレクトリ
$dir = dirname(__FILE__) .DIRECTORY_SEPARATOR. 'sdf'.DIRECTORY_SEPARATOR;

$result = list_files($dir);


function list_files($dir){
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator(
			$dir,
			FilesystemIterator::SKIP_DOTS
	  		|FilesystemIterator::KEY_AS_PATHNAME
			|FilesystemIterator::CURRENT_AS_FILEINFO
		), RecursiveIteratorIterator::LEAVES_ONLY
	);

	$list = array();
	foreach($iterator as $pathname){
		$list[] = $pathname;
		//echo $pathname."<br>";
	}
	return $list;
}


foreach(glob('sdf/{*.sd,*.sdf,*.gz,*.zip}', GLOB_BRACE) as $file) {
//foreach ($result as $file) {
	# code...

//foreach(glob('sdf/{*.sd,*.sdf,*.gz,*.zip}', GLOB_BRACE) as $file) {
//foreach(glob('{*.sdf}',GLOB_BRACE) as $file){
    if(is_file($file)){
		$count++;
		//$sdf = file_get_contents($file);		

		$html .= "<tr>\n";
		$html .= "<td>\n";
		$html .= $count."\n";
		$html .= "</td>\n";

		$html .= "<td>\n";
		$html .= $file."\n";
		$html .= "</td>\n";
		
		$html .= "<td>\n";
		$url = "sdf2json.php?file=";
		$filepath = str_replace("C:\opt\beta\moldb", "", $file);
		$fileext = pathinfo($file);
		if ($fileext['extension']=="sdf"){
			$html .= "<a href=\"".$url.$filepath."\" >DB更新</a>";
		}
		$html .= "</td>\n";

		$html .= "<td>\n";
		$url = "sdf2ctSql.php?file=";
		$filepath = str_replace("C:\opt\beta\moldb", "", $file);
		$fileext = pathinfo($file);
		if ($fileext['extension']=="sdf"){
			$html .= "<a href=\"".$url.$filepath."\" target=\"_blank\" >SQL</a>";
		}
		$html .= "</td>\n";

		$html .= "<td>\n";
		$down = "download.php?file=";		 
		$html .= "<a href=\"".$down.$file."\" >ダウンロード</a>";
		$html .= "</td>\n";

		$html .= "<td>\n";
		$timeStamp = filemtime($file);
		$html .=  date('Y/m/d H:i:s', $timeStamp);
		$html .= "</td>\n";

		$size = filesize($file);
		$html .= "<td>\n";
		$html .= (int)($size/(1000*1000))."MB\n";
		$html .= "</td>\n";


		$html .= "<tr>\n";
    }
}
$html .= "</table>\n";
echo $html;

include('menu.php');
?>



</body>
</html>
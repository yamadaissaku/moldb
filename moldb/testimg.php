<?php
$image = imagecreate(150, 150);
imagecolorallocate($image, 0xdd, 0xdd, 0xdd);
$fontColor = imagecolorallocate($image, 0xff, 0xff, 0xff);
header('Content-Type: image/png');
imagettftext($image, 20, 0, 0, 85, $fontColor, './mplus-1mn-medium.tff', 'Sample Text');
imagepng($image);
imagedestroy($image);
?>
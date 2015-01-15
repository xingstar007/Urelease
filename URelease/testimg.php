<?php
// 创建新的图像实例
$im = imagecreatetruecolor(100, 100);

// 设置背景为白色
imagefilledrectangle($im, 0, 0, 99, 99, 0xFFFFFF);

//在图像上写字
imagestring($im, 3, 40, 20, 'GD Library', 0xFFBA00);

// 输出图像到浏览器
header('Content-Type: image/gif');

// imagegif($im);
// imagedestroy($im);

$dst_path = 'http://hi.csdn.net/attachment/201202/11/0_1328950935qYty.gif';
$dst = imagecreatefromstring(file_get_contents($dst_path));
imagegif($dst);
imagedestroy($dst);

?>
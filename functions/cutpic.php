<?php

function cutPic($src_img, $dst_w, $dst_h, $uname) {

	list($src_w,$src_h)=getimagesize($src_img);  // 获取原图尺寸

	$dst_scale = $dst_h/$dst_w; //目标图像长宽比
	$src_scale = $src_h/$src_w; // 原图长宽比

	if($src_scale>=$dst_scale){  // 过高
	$w = intval($src_w);
	$h = intval($dst_scale*$w);

	$x = 0;
	$y = ($src_h - $h)/3;
	}
	else{ // 过宽
	$h = intval($src_h);
	$w = intval($h/$dst_scale);

	$x = ($src_w - $w)/2;
	$y = 0;
	}

	// 剪裁
	$source=imagecreatefromjpeg($src_img);
	$croped=imagecreatetruecolor($w, $h);
	imagecopy($croped,$source,0,0,$x,$y,$src_w,$src_h);

	// 缩放
	$scale = $dst_w/$w;
	$target = imagecreatetruecolor($dst_w, $dst_h);
	$final_w = intval($w*$scale);
	$final_h = intval($h*$scale);
	imagecopyresampled($target,$croped,0,0,0,0,$final_w,$final_h,$w,$h);

	// 保存
	$timestamp = time();
	imagejpeg($target, "pic_thumb/{$uname}_{$timestamp}.jpg");
	imagedestroy($target);
	imagedestroy($source);
	imagedestroy($croped);
}

//$filepath图片路径,$new_width新的宽度,$new_height新的高度
function imagepress($filepath, $new_width, $new_height, $uname) {
	echo "I'm in!" . "<br>";
$source_info   = getimagesize($filepath);
echo print_r($source_info) . "<br>";
$source_width  = $source_info[0];
$source_height = $source_info[1];
$source_mime   = $source_info['mime'];
$source_ratio  = $source_height / $source_width;
$target_ratio  = $new_height / $new_width;
// 源图过高
if ($source_ratio > $target_ratio)
{
$cropped_width  = $source_width;
$cropped_height = $source_width * $target_ratio;
$source_x = 0;
$source_y = ($source_height - $cropped_height) / 2;
}
// 源图过宽
elseif ($source_ratio < $target_ratio)
{
$cropped_width  = $source_height / $target_ratio;
$cropped_height = $source_height;
$source_x = ($source_width - $cropped_width) / 2;
$source_y = 0;
}
// 源图适中
else
{
$cropped_width  = $source_width;
$cropped_height = $source_height;
$source_x = 0;
$source_y = 0;
}
switch ($source_mime)
{
case 'image/gif':
$source_image = imagecreatefromgif($filepath);
break;
case 'image/jpeg':
$source_image = imagecreatefromjpeg($filepath);
break;
case 'image/png':
$source_image = imagecreatefrompng($filepath);
break;
default:
return false;
break;
}
$target_image  = imagecreatetruecolor($new_width, $new_height);
$cropped_image = imagecreatetruecolor($cropped_width, $cropped_height);
// 裁剪
imagecopy($cropped_image, $source_image, 0, 0, $source_x, $source_y, $cropped_width, $cropped_height);
// 缩放
imagecopyresampled($target_image, $cropped_image, 0, 0, 0, 0, $new_width, $new_height, $cropped_width, $cropped_height);
echo print_r($target_image) . "<br>";

$timestamp = time();
imagejpeg($target_image, "pic_thumb/{$uname}_{$timestamp}.jpg");

imagedestroy($source_image);
imagedestroy($target_image);
imagedestroy($cropped_image);
}

?>
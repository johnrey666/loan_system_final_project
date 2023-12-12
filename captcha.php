<?php
session_start();

// Generate a random string and store it in the session
$captchaText = substr(md5(rand()), 0, 6);
$_SESSION['captcha'] = $captchaText;

// Create a blank image
$image = imagecreatetruecolor(100, 30);


$bgColor = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $bgColor);


$textColor = imagecolorallocate($image, 0, 0, 0);


imagestring($image, 5, 5, 5, $captchaText, $textColor);


header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
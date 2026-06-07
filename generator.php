<?php
//Отримуємо та валідуємо дані
$df = isset($_GET['df']) ? (int)$_GET['df'] : 50;
$dg = (isset($_GET['dg']) && (int)$_GET['dg'] > 0) ? (int)$_GET['dg'] : 1; 
$cl = isset($_GET['cl']) ? (int)$_GET['cl'] : 50;

//Розрахунок ефективності
$efficiency = round(($df / $dg) * ($cl / 10), 1);

//Створення полотна
$im = imagecreatetruecolor(600, 400);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$blue  = imagecolorallocate($im, 0, 102, 204);
$green = imagecolorallocate($im, 0, 128, 0);
$gray  = imagecolorallocate($im, 230, 230, 230); 
$red = imagecolorallocate($im, 255, 0, 0);

imagefill($im, 0, 0, $white);

//Ліва шкала (для синіх стовпців 0-100 pts)
for ($i = 0; $i <= 100; $i += 25) {
    $y_pos = 300 - ($i * 2); 
    imageline($im, 60, $y_pos, 540, $y_pos, $gray); 
    imagestring($im, 2, 20, $y_pos - 7, $i . " pts", $blue);
}

//Права шкала (для зеленого коефіцієнта 0-25 iX)
for ($i = 0; $i <= 25; $i += 5) {
    $y_pos = 300 - ($i * 8); 
    imagestring($im, 2, 550, $y_pos - 7, $i . " iX", $green); 
}

//Малювання стовпців
imagefilledrectangle($im, 100, 300 - ($df * 2), 150, 300, $blue);
imagefilledrectangle($im, 200, 300 - ($dg * 2), 250, 300, $blue);
imagefilledrectangle($im, 300, 300 - ($cl * 2), 350, 300, $blue);

//Маштабування зеленогостовпця під свою шкалу
$eff_visual_height = $efficiency * 8; 
imagefilledrectangle($im, 450, 300 - (int)$eff_visual_height, 500, 300, $green);

//Осі
imageline($im, 60, 300, 550, 300, $black); // X
imageline($im, 60, 50, 60, 300, $black);   // Y

//Текстові блоки
$font_file = __DIR__ . '/arial.ttf';

if (file_exists($font_file)) {
    imagettftext($im, 16, 0, 180, 40, $black, $font_file, "Звіт аеродинаміки");
    
    //Підпис осі Y
    imagettftext($im, 9, 0, 90, 320, $black, $font_file, "Притискна");
    imagettftext($im, 8, 0, 95, 335, $black, $font_file, "Downforce");

    imagettftext($im, 9, 0, 210, 320, $black, $font_file, "Опір");
    imagettftext($im, 8, 0, 212, 335, $black, $font_file, "Drag");

    imagettftext($im, 9, 0, 290, 320, $black, $font_file, "Охолодження");
    imagettftext($im, 8, 0, 305, 335, $black, $font_file, "Cooling");

    imagettftext($im, 11, 0, 435, 320, $green, $font_file, "Ефективність");
    imagettftext($im, 9, 0, 445, 335, $green, $font_file, "Efficiency");

    //Значення над зеленим стовпцем
    imagettftext($im, 12, 0, 460, 300 - (int)$eff_visual_height - 10, $green, $font_file, $efficiency);
} else {
    //Резервний варіант англійською
    imagestring($im, 4, 200, 20, "Aerodinamics report", $black);
    imagestring($im, 2, 90, 310, "Downforce", $black);
    imagestring($im, 2, 210, 310, "Drag", $black);
    imagestring($im, 2, 300, 310, "Cooling", $black);
    imagestring($im, 3, 440, 310, "Efficiency", $green);
    imagestring($im, 5, 460, 300 - (int)$eff_visual_height - 20, $efficiency, $green);
}

//Завершення та вивід
header("Content-type: image/png");
imagepng($im);
?>
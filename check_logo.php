<?php
// Análisis del logo PNG - temporal
$logoPath = __DIR__ . '/public/assets/inmobiliaria/logo.png';
$logo = imagecreatefrompng($logoPath);
imagesavealpha($logo, true);

$w = imagesx($logo);
$h = imagesy($logo);
echo "Logo size: {$w}x{$h}\n";

$transparentCount = 0;
$whiteCount = 0;
$otherCount = 0;

// Muestrear esquina superior izquierda
for ($x = 0; $x < min($w, 50); $x += 5) {
    for ($y = 0; $y < min($h, 50); $y += 5) {
        $rgba = imagecolorat($logo, $x, $y);
        $a = ($rgba >> 24) & 0x7F; // 0=opaco, 127=transparente
        $r = ($rgba >> 16) & 0xFF;
        $g = ($rgba >> 8) & 0xFF;
        $b = $rgba & 0xFF;
        if ($a > 64) $transparentCount++;
        elseif ($r > 240 && $g > 240 && $b > 240) $whiteCount++;
        else $otherCount++;
    }
}

echo "Esquina sup-izq (50x50 muestreo):\n";
echo "  Transparentes: $transparentCount\n";
echo "  Blancos:       $whiteCount\n";
echo "  Otros:         $otherCount\n";

// Centro
$centerTransparent = 0;
$centerWhite = 0;
$centerOther = 0;
for ($x = (int)($w/2) - 25; $x < (int)($w/2) + 25; $x += 5) {
    for ($y = (int)($h/2) - 25; $y < (int)($h/2) + 25; $y += 5) {
        $rgba = imagecolorat($logo, $x, $y);
        $a = ($rgba >> 24) & 0x7F;
        $r = ($rgba >> 16) & 0xFF;
        $g = ($rgba >> 8) & 0xFF;
        $b = $rgba & 0xFF;
        if ($a > 64) $centerTransparent++;
        elseif ($r > 240 && $g > 240 && $b > 240) $centerWhite++;
        else $centerOther++;
    }
}
echo "Centro:\n";
echo "  Transparentes: $centerTransparent\n";
echo "  Blancos:       $centerWhite\n";
echo "  Otros:         $centerOther\n";

imagedestroy($logo);

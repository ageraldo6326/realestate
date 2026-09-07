<?php
// Script de diagnóstico temporal - eliminar después de usar
require __DIR__ . '/vendor/autoload.php';

// Analizar si el logo tiene fondo transparente o blanco
$logoPath = __DIR__ . '/public/assets/inmobiliaria/logo.png';
$logo = imagecreatefrompng($logoPath);
imagesavealpha($logo, true);

$w = imagesx($logo);
$h = imagesy($logo);
echo "Logo size: {$w}x{$h}\n";

// Muestrear 10 píxeles de la esquina superior izquierda
$transparentCount = 0;
$whiteCount = 0;
$otherCount = 0;

// Revisar muestra de píxeles
for ($x = 0; $x < min($w, 50); $x += 5) {
    for ($y = 0; $y < min($h, 50); $y += 5) {
        $rgba = imagecolorat($logo, $x, $y);
        $a = ($rgba >> 24) & 0x7F; // alpha en GD: 0=opaco, 127=transparente
        $r = ($rgba >> 16) & 0xFF;
        $g = ($rgba >> 8) & 0xFF;
        $b = $rgba & 0xFF;
        if ($a > 64) {
            $transparentCount++;
        } elseif ($r > 240 && $g > 240 && $b > 240) {
            $whiteCount++;
        } else {
            $otherCount++;
        }
    }
}

echo "Pixel sample (esquina sup-izq 50x50):\n";
echo "  Transparentes (alpha>64): $transparentCount\n";
echo "  Blancos (r,g,b>240): $whiteCount\n";
echo "  Otros (contenido real): $otherCount\n";

// Revisar centro del logo donde debería estar el contenido
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
        if ($a > 64) {
            $centerTransparent++;
        } elseif ($r > 240 && $g > 240 && $b > 240) {
            $centerWhite++;
        } else {
            $centerOther++;
        }
    }
}
echo "Pixel sample (CENTRO):\n";
echo "  Transparentes: $centerTransparent\n";
echo "  Blancos: $centerWhite\n";
echo "  Otros (contenido): $centerOther\n";

imagedestroy($logo);

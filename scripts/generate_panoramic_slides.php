<?php
// Script com GD para criar os banners panorâmicos perfeitos para Imobiliário, Empresarial e Inventário
// Largura: 1024, Altura: 368
// Fundo: gradiente elegante preto-azulado (#071220 a #0a192f)
// Lado Direito: imagem de destaque recortada suavemente fundida no gradiente escuro

$featured = json_decode(file_get_contents(dirname(__DIR__) . '/documents/slider_featured_images.json'), true);
$upload_dir = dirname(__DIR__) . '/app/public/wp-content/uploads/2026/09/';
$out_dir = dirname(__DIR__) . '/documents/banners_slides/';

$targets = [
    [
        'name' => 'slide-banner-imobiliario.png',
        'src'  => $upload_dir . 'hero-imobiliario-bldg.jpg',
    ],
    [
        'name' => 'slide-banner-empresarial.png',
        'src'  => $upload_dir . 'hero-empresarial-person.jpg',
    ],
    [
        'name' => 'slide-banner-inventario.png',
        'src'  => $upload_dir . 'hero-inventario-doc.jpg',
    ]
];

$width = 1024;
$height = 368;

foreach ($targets as $t) {
    $canvas = imagecreatetruecolor($width, $height);
    
    // Preencher fundo com gradiente escuro #071220 -> #0a192f
    for ($x = 0; $x < $width; $x++) {
        $ratio = $x / $width;
        $r = (int)(7 + (10 - 7) * $ratio);
        $g = (int)(18 + (25 - 18) * $ratio);
        $b = (int)(32 + (47 - 32) * $ratio);
        $col = imagecolorallocate($canvas, $r, $g, $b);
        imageline($canvas, $x, 0, $x, $height, $col);
    }

    if (file_exists($t['src'])) {
        $src_img = imagecreatefromjpeg($t['src']);
        $sw = imagesx($src_img);
        $sh = imagesy($src_img);

        // Queremos posicionar no lado direito, cobrindo da coluna 480 até 1024 (544px de largura)
        $dest_w = 560;
        $dest_h = $height;
        $dest_x = $width - $dest_w;

        // Criar imagem intermediária redimensionada
        $resized = imagecreatetruecolor($dest_w, $dest_h);
        imagecopyresampled($resized, $src_img, 0, 0, 0, 0, $dest_w, $dest_h, $sw, $sh);

        // Copiar pixel a pixel ou em faixas com alpha blending no lado esquerdo do elemento
        for ($x = 0; $x < $dest_w; $x++) {
            // Gradiente suave de fade-in nos primeiros 160px do lado esquerdo do elemento
            $alpha = 1.0;
            if ($x < 160) {
                $alpha = $x / 160;
            }
            for ($y = 0; $y < $dest_h; $y++) {
                $rgb = imagecolorat($resized, $x, $y);
                $sr = ($rgb >> 16) & 0xFF;
                $sg = ($rgb >> 8) & 0xFF;
                $sb = $rgb & 0xFF;

                $cur_rgb = imagecolorat($canvas, $dest_x + $x, $y);
                $cr = ($cur_rgb >> 16) & 0xFF;
                $cg = ($cur_rgb >> 8) & 0xFF;
                $cb = $cur_rgb & 0xFF;

                $final_r = (int)($cr * (1 - $alpha) + $sr * $alpha);
                $final_g = (int)($cg * (1 - $alpha) + $sg * $alpha);
                $final_b = (int)($cb * (1 - $alpha) + $sb * $alpha);

                $pix = imagecolorallocate($canvas, $final_r, $final_g, $final_b);
                imagesetpixel($canvas, $dest_x + $x, $y, $pix);
            }
        }
        imagedestroy($resized);
        imagedestroy($src_img);
    }

    imagepng($canvas, $out_dir . $t['name']);
    imagedestroy($canvas);
    echo "Gerado com sucesso: {$t['name']} (1024x368)\n";
}

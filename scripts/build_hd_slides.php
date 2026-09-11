<?php
// Gerador de Banners Panorâmicos Nativos em Alta Resolução (1920 x 600)
// Proporção ideal de telas modernas: 16:5 / 16:6 (3.2:1)
// Esquerda: 0 a 900px espaço escuro degradê para textos e botões
// Direita: 950 a 1920px destaque nítido, sem deformação e sem cortar cabeça/rosto

$width = 1920;
$height = 600;
$out_dir = dirname(__DIR__) . '/documents/banners_slides_hd/';
if (!is_dir($out_dir)) {
    mkdir($out_dir, 0777, true);
}

$dir = dirname(__DIR__) . '/app/public/wp-content/uploads/2026/09/';

$slides = [
    [
        'name' => 'banner-hd-institucional.jpg',
        'src'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/banner_slide_geral_1789145301524.jpg', // gerado perfeito 16:9
        'type' => 'wide_fade'
    ],
    [
        'name' => 'banner-hd-trabalhista.jpg',
        'src'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/banner_slide_trabalhista_1789145342544.jpg', // gerado perfeito 16:9
        'type' => 'wide_fade'
    ],
    [
        'name' => 'banner-hd-divorcio.jpg',
        'src'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/.user_uploaded/media_1789143141748.png', // Themis perfeita
        'type' => 'fit_right'
    ],
    [
        'name' => 'banner-hd-imobiliario.jpg',
        'src'  => $dir . 'hero-imobiliario-bldg.jpg',
        'type' => 'fit_right'
    ],
    [
        'name' => 'banner-hd-empresarial.jpg',
        'src'  => $dir . 'hero-empresarial.jpg',
        'type' => 'fit_right'
    ],
    [
        'name' => 'banner-hd-inventario.jpg',
        'src'  => $dir . 'hero-inventario.jpg',
        'type' => 'fit_right'
    ]
];

foreach ($slides as $s) {
    $canvas = imagecreatetruecolor($width, $height);

    // Gradiente de fundo base #071220 -> #0a192f
    for ($x = 0; $x < $width; $x++) {
        $ratio = $x / $width;
        $r = (int)(7 + (10 - 7) * $ratio);
        $g = (int)(18 + (25 - 18) * $ratio);
        $b = (int)(32 + (47 - 32) * $ratio);
        $col = imagecolorallocate($canvas, $r, $g, $b);
        imageline($canvas, $x, 0, $x, $height, $col);
    }

    if (file_exists($s['src'])) {
        $info = getimagesize($s['src']);
        $src_w = $info[0];
        $src_h = $info[1];
        $mime = $info['mime'];

        if ($mime === 'image/png') {
            $src_img = imagecreatefrompng($s['src']);
        } else {
            $src_img = imagecreatefromjpeg($s['src']);
        }

        if ($s['type'] === 'wide_fade') {
            // Imagem já panorâmica 16:9 (ex: 1920x1080)
            // Queremos redimensionar proporcionalmente para caber os 600px de altura
            $dest_h = $height;
            $dest_w = (int)($src_w * ($dest_h / $src_h));
            $resized = imagecreatetruecolor($dest_w, $dest_h);
            imagecopyresampled($resized, $src_img, 0, 0, 0, 0, $dest_w, $dest_h, $src_w, $src_h);

            // Posicionar à direita
            $dest_x = $width - $dest_w;
            if ($dest_x > 0) $dest_x = 0; // se for mais larga, ancora na direita
            $actual_x = $width - $dest_w;

            for ($x = 0; $x < $dest_w; $x++) {
                $target_x = $actual_x + $x;
                if ($target_x < 0 || $target_x >= $width) continue;

                // Fade suave na esquerda para garantir legibilidade dos textos
                $alpha = 1.0;
                if ($target_x < 900) {
                    $alpha = max(0, ($target_x - 300) / 600);
                }

                for ($y = 0; $y < $dest_h; $y++) {
                    $rgb = imagecolorat($resized, $x, $y);
                    $sr = ($rgb >> 16) & 0xFF;
                    $sg = ($rgb >> 8) & 0xFF;
                    $sb = $rgb & 0xFF;

                    $cur_rgb = imagecolorat($canvas, $target_x, $y);
                    $cr = ($cur_rgb >> 16) & 0xFF;
                    $cg = ($cur_rgb >> 8) & 0xFF;
                    $cb = $cur_rgb & 0xFF;

                    $fr = (int)($cr * (1 - $alpha) + $sr * $alpha);
                    $fg = (int)($cg * (1 - $alpha) + $sg * $alpha);
                    $fb = (int)($cb * (1 - $alpha) + $sb * $alpha);

                    imagesetpixel($canvas, $target_x, $y, imagecolorallocate($canvas, $fr, $fg, $fb));
                }
            }
            imagedestroy($resized);
        } else {
            // Imagem normal para encaixar estritamente do centro para a direita (ex: de 900px a 1920px)
            // Largura reservada: 1020px, Altura: 600px
            $box_w = 1050;
            $box_h = $height;

            // Escala cobrindo o box mantendo proporção (cover sem distorcer)
            $scale = max($box_w / $src_w, $box_h / $src_h);
            $scaled_w = (int)($src_w * $scale);
            $scaled_h = (int)($src_h * $scale);

            $crop_x = (int)(($scaled_w - $box_w) / 2);
            $crop_y = (int)(($scaled_h - $box_h) / 3); // focar ligeiramente mais no topo para rostos não cortarem
            if ($crop_y < 0) $crop_y = 0;

            $resized = imagecreatetruecolor($scaled_w, $scaled_h);
            imagecopyresampled($resized, $src_img, 0, 0, 0, 0, $scaled_w, $scaled_h, $src_w, $src_h);

            $start_x = $width - $box_w;
            for ($x = 0; $x < $box_w; $x++) {
                $target_x = $start_x + $x;
                $alpha = 1.0;
                // Fade gradativo nos primeiros 280px da imagem
                if ($x < 280) {
                    $alpha = $x / 280;
                }

                for ($y = 0; $y < $box_h; $y++) {
                    $src_px_x = $crop_x + $x;
                    $src_px_y = $crop_y + $y;
                    if ($src_px_x >= $scaled_w || $src_px_y >= $scaled_h) continue;

                    $rgb = imagecolorat($resized, $src_px_x, $src_px_y);
                    $sr = ($rgb >> 16) & 0xFF;
                    $sg = ($rgb >> 8) & 0xFF;
                    $sb = $rgb & 0xFF;

                    $cur_rgb = imagecolorat($canvas, $target_x, $y);
                    $cr = ($cur_rgb >> 16) & 0xFF;
                    $cg = ($cur_rgb >> 8) & 0xFF;
                    $cb = $cur_rgb & 0xFF;

                    $fr = (int)($cr * (1 - $alpha) + $sr * $alpha);
                    $fg = (int)($cg * (1 - $alpha) + $sg * $alpha);
                    $fb = (int)($cb * (1 - $alpha) + $sb * $alpha);

                    imagesetpixel($canvas, $target_x, $y, imagecolorallocate($canvas, $fr, $fg, $fb));
                }
            }
            imagedestroy($resized);
        }
        imagedestroy($src_img);
    }

    imagejpeg($canvas, $out_dir . $s['name'], 92);
    imagedestroy($canvas);
    echo "Gerado com sucesso em 1920x600: {$s['name']}\n";
}

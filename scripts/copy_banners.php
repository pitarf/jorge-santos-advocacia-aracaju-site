<?php
$source_dir = 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f';
$target_dir = dirname(__DIR__) . '/documents/banners_slides';
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// 1. As 3 referências que você enviou (já no formato exato 1024x368):
// media_1789143096971.png -> Geral / Equipe
// media_1789143141748.png -> Família / Divórcio / Themis Justiça
// media_1789143166125.png -> Trabalhista (Advogada + Carteira de Trabalho)
copy($source_dir . '/.user_uploaded/media_1789143096971.png', $target_dir . '/slide-banner-institucional.png');
copy($source_dir . '/.user_uploaded/media_1789143141748.png', $target_dir . '/slide-banner-divorcio-familia.png');
copy($source_dir . '/.user_uploaded/media_1789143166125.png', $target_dir . '/slide-banner-trabalhista.png');

// 2. Os banners HD gerados (16:9 de altíssima fidelidade):
copy($source_dir . '/banner_slide_geral_1789145301524.jpg', $target_dir . '/slide-banner-geral-hd.jpg');
copy($source_dir . '/banner_slide_trabalhista_1789145342544.jpg', $target_dir . '/slide-banner-trabalhista-hd.jpg');

echo "Banners organizados em $target_dir:\n";
foreach (scandir($target_dir) as $f) {
    if ($f !== '.' && $f !== '..') {
        echo " - $f\n";
    }
}

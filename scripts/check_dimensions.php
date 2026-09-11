<?php
$files = [
    'media_1789143096971.png',
    'media_1789143141748.png',
    'media_1789143166125.png'
];

foreach ($files as $f) {
    $path = 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/.user_uploaded/' . $f;
    $info = getimagesize($path);
    echo "$f: {$info[0]} x {$info[1]} ({$info['mime']})\n";
}

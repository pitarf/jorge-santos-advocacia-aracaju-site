<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$new_cards = [
    [
        'title' => 'Direito do Consumidor',
        'file'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/.user_uploaded/media_1789132725862.png',
        'filename' => 'card-direito-consumidor.png',
        'url' => home_url('/area-de-atuacao/')
    ],
    [
        'title' => 'Direito Agrário',
        'file'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/.user_uploaded/media_1789132807383.png',
        'filename' => 'card-direito-agrario.png',
        'url' => home_url('/area-de-atuacao/')
    ],
    [
        'title' => 'Direito Ambiental',
        'file'  => 'C:/Users/rfpit/.gemini/antigravity/brain/cc454a54-bc22-41a4-93ec-3b2839a00b3f/.user_uploaded/media_1789132813354.png',
        'filename' => 'card-direito-ambiental.png',
        'url' => home_url('/area-de-atuacao/')
    ]
];

$upload_dir = wp_upload_dir();
$registered = [];

foreach ($new_cards as $card) {
    $target = $upload_dir['path'] . '/' . $card['filename'];
    copy($card['file'], $target);

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $card['filename'],
        'post_mime_type' => 'image/png',
        'post_title'     => $card['title'] . ' - Jorge Santos Advogados Aracaju',
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $target);
    $attach_data = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $attach_data);
    update_post_meta($attach_id, '_wp_attachment_image_alt', $card['title'] . ' Aracaju');

    $card['id'] = $attach_id;
    $card['img_url'] = wp_get_attachment_url($attach_id);
    $registered[] = $card;
    echo "Registrado: {$card['title']} -> ID: {$attach_id} -> URL: {$card['img_url']}\n";
}

// Carregar cards anteriores
$existing_file = __DIR__ . '/documents/exact_cards_uploaded.json';
$all_cards = [];
if (file_exists($existing_file)) {
    $all_cards = json_decode(file_get_contents($existing_file), true);
}
foreach ($registered as $reg) {
    $all_cards[] = $reg;
}
file_put_contents($existing_file, json_encode($all_cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

echo "Total de cards agora: " . count($all_cards) . "\n";

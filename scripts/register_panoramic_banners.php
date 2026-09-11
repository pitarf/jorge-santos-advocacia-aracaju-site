<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$banners = [
    'institucional' => [
        'title' => 'Jorge Santos Advocacia Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-institucional.png',
        'filename' => 'slide-banner-institucional.png'
    ],
    'trabalhista' => [
        'title' => 'Advogado Trabalhista em Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-trabalhista.png',
        'filename' => 'slide-banner-trabalhista.png'
    ],
    'divorcio' => [
        'title' => 'Advogado para Divórcio em Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-divorcio-familia.png',
        'filename' => 'slide-banner-divorcio-familia.png'
    ],
    'imobiliario' => [
        'title' => 'Advogado Imobiliário em Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-imobiliario.png',
        'filename' => 'slide-banner-imobiliario.png'
    ],
    'empresarial' => [
        'title' => 'Advogado Empresarial em Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-empresarial.png',
        'filename' => 'slide-banner-empresarial.png'
    ],
    'inventario' => [
        'title' => 'Advogado para Inventário em Aracaju',
        'file'  => dirname(__DIR__) . '/documents/banners_slides/slide-banner-inventario.png',
        'filename' => 'slide-banner-inventario.png'
    ]
];

$upload_dir = wp_upload_dir();
$uploaded_map = [];

foreach ($banners as $key => $b) {
    $target = $upload_dir['path'] . '/' . $b['filename'];
    copy($b['file'], $target);

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $b['filename'],
        'post_mime_type' => 'image/png',
        'post_title'     => $b['title'] . ' - Banner',
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $target);
    $attach_data = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $attach_data);
    update_post_meta($attach_id, '_wp_attachment_image_alt', $b['title']);

    $uploaded_map[$key] = [
        'id'  => $attach_id,
        'url' => wp_get_attachment_url($attach_id)
    ];
    echo "Registrado banner: {$b['title']} -> ID: {$attach_id}\n";
}

file_put_contents(dirname(__DIR__) . '/documents/banners_registered.json', json_encode($uploaded_map, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Mapeamento salvo em documents/banners_registered.json\n";

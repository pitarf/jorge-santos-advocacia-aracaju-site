<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$hd_dir = dirname(__DIR__) . '/documents/banners_slides_hd/';
$upload_dir = wp_upload_dir();

$banners = [
    'institucional' => [
        'title' => 'Jorge Santos Advocacia Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-institucional.jpg',
        'filename' => 'banner-hd-institucional.jpg'
    ],
    'trabalhista' => [
        'title' => 'Advogado Trabalhista em Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-trabalhista.jpg',
        'filename' => 'banner-hd-trabalhista.jpg'
    ],
    'divorcio' => [
        'title' => 'Advogado para Divórcio em Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-divorcio.jpg',
        'filename' => 'banner-hd-divorcio.jpg'
    ],
    'imobiliario' => [
        'title' => 'Advogado Imobiliário em Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-imobiliario.jpg',
        'filename' => 'banner-hd-imobiliario.jpg'
    ],
    'empresarial' => [
        'title' => 'Advogado Empresarial em Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-empresarial.jpg',
        'filename' => 'banner-hd-empresarial.jpg'
    ],
    'inventario' => [
        'title' => 'Advogado para Inventário em Aracaju HD',
        'file'  => $hd_dir . 'banner-hd-inventario.jpg',
        'filename' => 'banner-hd-inventario.jpg'
    ]
];

$registered = [];
foreach ($banners as $k => $b) {
    $target = $upload_dir['path'] . '/' . $b['filename'];
    copy($b['file'], $target);

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $b['filename'],
        'post_mime_type' => 'image/jpeg',
        'post_title'     => $b['title'],
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $target);
    $attach_data = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $attach_data);
    update_post_meta($attach_id, '_wp_attachment_image_alt', $b['title']);

    $registered[$k] = [
        'id'  => $attach_id,
        'url' => wp_get_attachment_url($attach_id)
    ];
    echo "Registrado: {$b['title']} -> ID: {$attach_id}\n";
}

// Atualizar o widget nativo Slides no Elementor
$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

foreach ($data as &$root_el) {
    if (!empty($root_el['elements'])) {
        foreach ($root_el['elements'] as &$widget) {
            if (($widget['widgetType'] ?? '') === 'slides') {
                // Ajustar altura para 520px para não ficar achaparrado nem cortar rostos
                $widget['settings']['slides_height'] = [
                    'unit' => 'px',
                    'size' => 520,
                    'sizes' => []
                ];
                $widget['settings']['slides_height_tablet'] = [
                    'unit' => 'px',
                    'size' => 450,
                    'sizes' => []
                ];
                $widget['settings']['slides_height_mobile'] = [
                    'unit' => 'px',
                    'size' => 380,
                    'sizes' => []
                ];

                // Ajustar paddings para deixar os textos respirarem no lado esquerdo sem encostar na seta
                $widget['settings']['slides_padding'] = [
                    'unit' => 'px',
                    'top' => '60',
                    'right' => '45%', // Garante que o texto NUNCA ultrapasse a metade da tela ou fique por cima das pessoas
                    'bottom' => '60',
                    'left' => '80',
                    'isLinked' => false
                ];

                // Atualizar as URLs dos slides
                $keys = ['institucional', 'trabalhista', 'divorcio', 'imobiliario', 'empresarial', 'inventario'];
                foreach ($widget['settings']['slides'] as $idx => &$slide) {
                    $key = $keys[$idx] ?? 'institucional';
                    $slide['background_image'] = [
                        'url' => $registered[$key]['url'],
                        'id'  => $registered[$key]['id'],
                        'alt' => $slide['heading'] ?? '',
                        'source' => 'library',
                        'size'   => ''
                    ];
                    $slide['background_size'] = 'cover';
                    $slide['background_position'] = 'center right'; // Garante que a foto do advogado/destaque à direita seja sempre priorizada
                }
            }
        }
    }
}

update_post_meta(37, '_elementor_data', wp_slash(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "Sucesso! Slides nativos atualizados com proporção 1920x600 e foco 'center right' sem distorção.\n";

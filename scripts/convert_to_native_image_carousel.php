<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

// Mapeamento dos 10 cards 3D existentes no WordPress
$cards_order = [
    ['id' => 409, 'file' => 'card-3d-direito-empresarial.jpg', 'title' => 'Direito Empresarial', 'url' => '/advogado-empresarial-em-aracaju/'],
    ['id' => 410, 'file' => 'card-3d-direito-civil.jpg', 'title' => 'Direito Civil', 'url' => '/area-de-atuacao/'],
    ['id' => 411, 'file' => 'card-3d-direito-trabalhista.jpg', 'title' => 'Direito Trabalhista', 'url' => '/advogado-trabalhista-em-aracaju/'],
    ['id' => 412, 'file' => 'card-3d-direito-familia.jpg', 'title' => 'Direito de Família', 'url' => '/advogado-divorcio-em-aracaju/'],
    ['id' => 413, 'file' => 'card-3d-direito-imobiliario.jpg', 'title' => 'Direito Imobiliário', 'url' => '/advogado-imobiliario-em-aracaju/'],
    ['id' => 414, 'file' => 'card-3d-direito-consumidor.jpg', 'title' => 'Direito do Consumidor', 'url' => '/area-de-atuacao/'],
    ['id' => 415, 'file' => 'card-3d-direito-sucessorio.jpg', 'title' => 'Direito Sucessório e Inventário', 'url' => '/advogado-inventario-em-aracaju/'],
    ['id' => 416, 'file' => 'card-3d-direito-penal.jpg', 'title' => 'Direito Penal', 'url' => '/area-de-atuacao/'],
    ['id' => 417, 'file' => 'card-3d-direito-previdenciario.jpg', 'title' => 'Direito Previdenciário', 'url' => '/area-de-atuacao/'],
    ['id' => 418, 'file' => 'card-3d-direito-tributario.jpg', 'title' => 'Direito Tributário', 'url' => '/area-de-atuacao/']
];

$carousel_items = [];
foreach ($cards_order as $card) {
    $img_url = wp_get_attachment_url($card['id']);
    if (!$img_url) {
        $upload_dir = wp_upload_dir();
        $img_url = $upload_dir['baseurl'] . '/2026/09/' . $card['file'];
    }
    $carousel_items[] = [
        'id' => $card['id'],
        'url' => $img_url
    ];
}

// Criar a seção nativa do Elementor com widget image-carousel
$native_carousel_section = [
    'id' => 'areas_image_carousel_sec',
    'elType' => 'section',
    'settings' => [
        'layout' => 'boxed',
        'content_width' => [
            'unit' => 'px',
            'size' => 1240,
            'sizes' => []
        ],
        'background_background' => 'classic',
        'background_color' => '#071220',
        'padding' => [
            'unit' => 'px',
            'top' => '35',
            'right' => '20',
            'bottom' => '35',
            'left' => '20',
            'isLinked' => false
        ],
        'border_border' => 'solid',
        'border_width' => [
            'unit' => 'px',
            'top' => '1',
            'right' => '0',
            'bottom' => '2',
            'left' => '0',
            'isLinked' => false
        ],
        'border_color' => '#C5A880',
        'custom_css' => "/* Estilo Premium dos Cards no Carrossel Nativo */
selector .elementor-image-carousel .swiper-slide {
    padding: 10px 6px;
    box-sizing: border-box;
}
selector .elementor-image-carousel img {
    border-radius: 6px;
    border: 1px solid rgba(197, 168, 128, 0.25);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
    transition: all 0.35s ease;
    background: #000;
}
selector .elementor-image-carousel .swiper-slide:hover img {
    transform: translateY(-6px) scale(1.03);
    border-color: #C9A45C;
    box-shadow: 0 15px 35px rgba(201, 164, 92, 0.35);
}
selector .elementor-swiper-button {
    color: #C9A45C !important;
    transition: all 0.3s ease;
}
selector .elementor-swiper-button:hover {
    color: #FFFFFF !important;
    transform: scale(1.2);
}"
    ],
    'elements' => [
        [
            'id' => 'areas_image_carousel_col',
            'elType' => 'column',
            'settings' => [
                '_column_size' => 100
            ],
            'elements' => [
                [
                    'id' => 'areas_image_carousel_widget',
                    'elType' => 'widget',
                    'widgetType' => 'image-carousel',
                    'settings' => [
                        'carousel_name' => 'Carrossel Áreas de Atuação',
                        'carousel' => $carousel_items,
                        'thumbnail_size' => 'full',
                        'slides_to_show' => '6',
                        'slides_to_show_tablet' => '4',
                        'slides_to_show_mobile' => '2',
                        'slides_to_scroll' => '1',
                        'image_stretch' => 'no',
                        'navigation' => 'arrows',
                        'pause_on_hover' => 'yes',
                        'autoplay' => 'yes',
                        'autoplay_speed' => 3500,
                        'infinite' => 'yes',
                        'effect' => 'slide',
                        'speed' => 500,
                        'arrows_size' => [
                            'unit' => 'px',
                            'size' => 30,
                            'sizes' => []
                        ],
                        'arrows_color' => '#C9A45C',
                        'link_to' => 'custom',
                        'gallery_vertical_align' => 'center'
                    ]
                ]
            ]
        ]
    ]
];

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

$new_data = [];
$replaced = false;
foreach ($data as $el) {
    if (($el['id'] ?? '') === 'areas_carousel_sec_replace') {
        $new_data[] = $native_carousel_section;
        $replaced = true;
        echo "Substituído areas_carousel_sec_replace pelo widget nativo image-carousel!\n";
    } else {
        $new_data[] = $el;
    }
}

if ($replaced) {
    update_post_meta(37, '_elementor_data', wp_slash(json_encode($new_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
    echo "Sucesso! Carrossel horizontal de áreas convertido 100% para widget nativo do Elementor.\n";
} else {
    echo "Erro: Seção de áreas não encontrada.\n";
}

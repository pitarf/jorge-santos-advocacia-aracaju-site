<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

$cards_to_deploy = [
    [
        'title' => 'Direito Empresarial',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-empresarial.jpg',
        'filename' => 'card-3d-direito-empresarial.jpg',
        'url' => '/advogado-empresarial-em-aracaju/'
    ],
    [
        'title' => 'Direito Civil',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-civil.jpg',
        'filename' => 'card-3d-direito-civil.jpg',
        'url' => '/area-de-atuacao/'
    ],
    [
        'title' => 'Direito Trabalhista',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-trabalhista.jpg',
        'filename' => 'card-3d-direito-trabalhista.jpg',
        'url' => '/advogado-trabalhista-em-aracaju/'
    ],
    [
        'title' => 'Direito de Família',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-familia.jpg',
        'filename' => 'card-3d-direito-familia.jpg',
        'url' => '/advogado-divorcio-em-aracaju/'
    ],
    [
        'title' => 'Direito Imobiliário',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-imobiliario.jpg',
        'filename' => 'card-3d-direito-imobiliario.jpg',
        'url' => '/advogado-imobiliario-em-aracaju/'
    ],
    [
        'title' => 'Direito do Consumidor',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-consumidor.jpg',
        'filename' => 'card-3d-direito-consumidor.jpg',
        'url' => '/area-de-atuacao/'
    ],
    [
        'title' => 'Direito Sucessório e Inventário',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-sucessorio.jpg',
        'filename' => 'card-3d-direito-sucessorio.jpg',
        'url' => '/advogado-inventario-em-aracaju/'
    ],
    [
        'title' => 'Direito Penal',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-penal.jpg',
        'filename' => 'card-3d-direito-penal.jpg',
        'url' => '/area-de-atuacao/'
    ],
    [
        'title' => 'Direito Previdenciário',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-previdenciario.jpg',
        'filename' => 'card-3d-direito-previdenciario.jpg',
        'url' => '/area-de-atuacao/'
    ],
    [
        'title' => 'Direito Tributário',
        'file'  => dirname(__DIR__) . '/documents/novos_cards_gerados/card-direito-tributario.jpg',
        'filename' => 'card-3d-direito-tributario.jpg',
        'url' => '/area-de-atuacao/'
    ]
];

$upload_dir = wp_upload_dir();
$registered_slides = [];

foreach ($cards_to_deploy as $card) {
    $target = $upload_dir['path'] . '/' . $card['filename'];
    copy($card['file'], $target);

    $attachment = [
        'guid'           => $upload_dir['url'] . '/' . $card['filename'],
        'post_mime_type' => 'image/jpeg',
        'post_title'     => $card['title'] . ' - Jorge Santos Advogados Aracaju',
        'post_content'   => '',
        'post_status'    => 'inherit'
    ];

    $attach_id = wp_insert_attachment($attachment, $target);
    $attach_data = wp_generate_attachment_metadata($attach_id, $target);
    wp_update_attachment_metadata($attach_id, $attach_data);
    update_post_meta($attach_id, '_wp_attachment_image_alt', $card['title'] . ' Aracaju');

    $img_url = wp_get_attachment_url($attach_id);
    $registered_slides[] = [
        'title' => $card['title'],
        'url'   => $card['url'],
        'img'   => $img_url
    ];
    echo "Registrado: {$card['title']} -> ID: {$attach_id} -> URL: {$img_url}\n";
}

// Montar slides HTML
$slides_html = '';
foreach ($registered_slides as $c) {
    $slides_html .= "    <div class=\"swiper-slide js-exact-card-slide\">\n";
    $slides_html .= "        <a href=\"{$c['url']}\" class=\"js-exact-card-link\" title=\"{$c['title']}\">\n";
    $slides_html .= "            <div class=\"js-exact-card-wrap\">\n";
    $slides_html .= "                <img src=\"{$c['img']}\" alt=\"{$c['title']}\" class=\"js-exact-card-img\" />\n";
    $slides_html .= "            </div>\n";
    $slides_html .= "        </a>\n";
    $slides_html .= "    </div>\n";
}

$widget_html = <<<HTML

<!-- CARROSSEL DAS ARTES 3D ULTRA PREMIUM -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
.js-exact-carousel-section {
    position: relative;
    width: 100%;
    background-color: #071220;
    padding: 30px 15px;
    box-sizing: border-box;
    border-top: 1px solid rgba(197, 168, 128, 0.2);
    border-bottom: 2px solid #C5A880;
    overflow: hidden;
}
.js-exact-carousel-container {
    max-width: 1280px;
    margin: 0 auto;
    position: relative;
    padding: 0 45px;
    box-sizing: border-box;
}
.js-exact-swiper {
    width: 100%;
    padding: 10px 0;
}
.js-exact-card-slide {
    display: flex;
    justify-content: center;
    align-items: center;
}
.js-exact-card-link {
    display: block;
    width: 100%;
    max-width: 180px;
    text-decoration: none;
    transition: transform 0.35s ease, filter 0.35s ease;
}
.js-exact-card-wrap {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
    border: 1px solid rgba(197, 168, 128, 0.25);
    transition: all 0.35s ease;
    background: #000;
}
.js-exact-card-link:hover .js-exact-card-wrap {
    transform: translateY(-6px);
    border-color: #C9A45C;
    box-shadow: 0 15px 35px rgba(201, 164, 92, 0.35);
}
.js-exact-card-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.4s ease;
}
.js-exact-card-link:hover .js-exact-card-img {
    transform: scale(1.05);
}
.js-exact-btn-prev, .js-exact-btn-next {
    color: #C9A45C !important;
    width: 32px;
    height: 32px;
    transition: all 0.3s;
    top: 50%;
    transform: translateY(-50%);
}
.js-exact-btn-prev {
    left: 5px;
}
.js-exact-btn-next {
    right: 5px;
}
.js-exact-btn-prev:after, .js-exact-btn-next:after {
    font-size: 22px !important;
    font-weight: 900;
}
.js-exact-btn-prev:hover, .js-exact-btn-next:hover {
    color: #FFFFFF !important;
    transform: translateY(-50%) scale(1.2);
}
</style>

<div class="js-exact-carousel-section">
    <div class="js-exact-carousel-container">
        <div class="swiper js-exact-swiper">
            <div class="swiper-wrapper">
$slides_html
            </div>
        </div>
        <div class="swiper-button-prev js-exact-btn-prev"></div>
        <div class="swiper-button-next js-exact-btn-next"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    new Swiper(".js-exact-swiper", {
        slidesPerView: 2,
        spaceBetween: 18,
        loop: true,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: ".js-exact-btn-next",
            prevEl: ".js-exact-btn-prev",
        },
        breakpoints: {
            576: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 22,
            },
            992: {
                slidesPerView: 5,
                spaceBetween: 22,
            },
            1200: {
                slidesPerView: 6,
                spaceBetween: 24,
            }
        }
    });
});
</script>
HTML;

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

$updated = false;
foreach ($data as &$sec) {
    if (($sec['id'] ?? '') === 'areas_carousel_sec_replace') {
        $sec['elements'][0]['elements'][0]['settings']['html'] = $widget_html;
        $updated = true;
        break;
    }
}

if ($updated) {
    update_post_meta(37, '_elementor_data', wp_slash(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
    echo "Sucesso! Carrossel da Home atualizado com a coleção 3D ultra premium completa.\n";
} else {
    echo "Erro: Seção não encontrada.\n";
}

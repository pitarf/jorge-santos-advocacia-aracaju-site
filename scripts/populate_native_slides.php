<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$banners = json_decode(file_get_contents(dirname(__DIR__) . '/documents/banners_registered.json'), true);

$slides_data = [
    [
        'heading' => 'Advocacia Estratégica em Aracaju e Sergipe',
        'description' => 'Defesa combativa, excelência técnica e atendimento humanizado para pessoas físicas e empresas com mais de 10 anos de experiência.',
        'button_text' => 'Fale Conosco',
        'link' => [
            'url' => 'https://wa.me/5579999281768?text=' . rawurlencode('Olá! Gostaria de falar com um advogado em Aracaju.'),
            'is_external' => 'yes',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['institucional']['url'],
            'id' => $banners['institucional']['id'],
            'alt' => 'Jorge Santos Advocacia Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_inst_01'
    ],
    [
        'heading' => 'Advogado Trabalhista em Aracaju',
        'description' => 'Especialistas em rescisões, horas extras, justa causa e consultoria preventiva e defesa patronal para empresas em Sergipe.',
        'button_text' => 'Saiba Mais',
        'link' => [
            'url' => home_url('/advogado-trabalhista-em-aracaju/'),
            'is_external' => '',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['trabalhista']['url'],
            'id' => $banners['trabalhista']['id'],
            'alt' => 'Advogado Trabalhista em Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_trab_02'
    ],
    [
        'heading' => 'Advogado para Divórcio e Família',
        'description' => 'Condução ágil e segura em divórcio consensual ou litigioso, partilha equilibrada de bens, pensão e guarda de filhos.',
        'button_text' => 'Saiba Mais',
        'link' => [
            'url' => home_url('/advogado-divorcio-em-aracaju/'),
            'is_external' => '',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['divorcio']['url'],
            'id' => $banners['divorcio']['id'],
            'alt' => 'Advogado para Divórcio em Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_div_03'
    ],
    [
        'heading' => 'Advogado Imobiliário em Aracaju',
        'description' => 'Segurança total em compra e venda, regularização de imóveis em cartório, contratos de locação, usucapião e distratos.',
        'button_text' => 'Saiba Mais',
        'link' => [
            'url' => home_url('/advogado-imobiliario-em-aracaju/'),
            'is_external' => '',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['imobiliario']['url'],
            'id' => $banners['imobiliario']['id'],
            'alt' => 'Advogado Imobiliário em Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_imob_04'
    ],
    [
        'heading' => 'Advogado Empresarial em Aracaju',
        'description' => 'Blindagem preventiva, elaboração de contratos comerciais, recuperação de créditos e defesa jurídica integral de empresas.',
        'button_text' => 'Saiba Mais',
        'link' => [
            'url' => home_url('/advogado-empresarial-em-aracaju/'),
            'is_external' => '',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['empresarial']['url'],
            'id' => $banners['empresarial']['id'],
            'alt' => 'Advogado Empresarial em Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_emp_05'
    ],
    [
        'heading' => 'Advogado para Inventário e Herança',
        'description' => 'Agilidade em inventário extrajudicial em cartório ou judicial, partilha amigável de bens e proteção de herdeiros.',
        'button_text' => 'Saiba Mais',
        'link' => [
            'url' => home_url('/advogado-inventario-em-aracaju/'),
            'is_external' => '',
            'nofollow' => '',
            'custom_attributes' => ''
        ],
        'background_image' => [
            'url' => $banners['inventario']['url'],
            'id' => $banners['inventario']['id'],
            'alt' => 'Advogado para Inventário em Aracaju',
            'source' => 'library',
            'size' => ''
        ],
        'background_ken_burns' => '',
        'background_overlay' => '',
        'custom_style' => 'yes',
        'horizontal_position' => 'left',
        'vertical_position' => 'middle',
        'text_align' => 'left',
        '_id' => 'slide_inv_06'
    ]
];

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

// Localizar o container que possui o widget slides nativo
$updated = false;
foreach ($data as &$root_el) {
    if (!empty($root_el['elements'])) {
        foreach ($root_el['elements'] as &$widget) {
            if (($widget['widgetType'] ?? '') === 'slides') {
                $widget['settings']['slides'] = $slides_data;
                $widget['settings']['slides_height'] = [
                    'unit' => 'px',
                    'size' => 450,
                    'sizes' => []
                ];
                $widget['settings']['navigation'] = 'both';
                $widget['settings']['autoplay'] = 'yes';
                $widget['settings']['autoplay_speed'] = 5000;
                $widget['settings']['infinite'] = 'yes';
                $widget['settings']['pause_on_hover'] = 'yes';
                $widget['settings']['transition'] = 'slide';
                $widget['settings']['content_animation'] = 'fadeInLeft';
                $widget['settings']['slides_padding'] = [
                    'unit' => 'px',
                    'top' => '60',
                    'right' => '60',
                    'bottom' => '60',
                    'left' => '60',
                    'isLinked' => false
                ];
                $widget['settings']['slides_horizontal_position'] = 'left';
                $widget['settings']['slides_text_align'] = 'left';
                $widget['settings']['button_size'] = 'sm';
                $widget['settings']['heading_color'] = '#FFFFFF';
                $widget['settings']['description_color'] = '#E2E8F0';
                $widget['settings']['button_background_color'] = '#C9A45C';
                $widget['settings']['button_text_color'] = '#071220';
                $widget['settings']['button_hover_background_color'] = '#D4B36D';
                $widget['settings']['button_hover_text_color'] = '#000000';
                $widget['settings']['heading_typography_font_family'] = 'Cinzel';
                $widget['settings']['heading_typography_font_size'] = [
                    'unit' => 'px',
                    'size' => 38,
                    'sizes' => []
                ];
                $widget['settings']['heading_typography_font_weight'] = '700';
                $widget['settings']['description_typography_font_family'] = 'Montserrat';
                $widget['settings']['description_typography_font_size'] = [
                    'unit' => 'px',
                    'size' => 15,
                    'sizes' => []
                ];
                $updated = true;
                echo "Widget Slides nativo configurado com os 6 slides de Aracaju!\n";
                break 2;
            }
        }
    }
}

// Remover o bloco HTML antigo de slide do topo (hero_custom_slider_sec), já que o usuário colocou o Slides nativo do Elementor
$clean_data = [];
foreach ($data as $el) {
    if (($el['id'] ?? '') === 'hero_custom_slider_sec') {
        echo "Removido hero_custom_slider_sec (HTML antigo substituído pelo nativo).\n";
        continue;
    }
    $clean_data[] = $el;
}

if ($updated) {
    update_post_meta(37, '_elementor_data', wp_slash(json_encode($clean_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
    echo "Sucesso! Home atualizada com o widget Slides nativo do Elementor.\n";
} else {
    echo "Erro: Widget Slides nativo não encontrado.\n";
}

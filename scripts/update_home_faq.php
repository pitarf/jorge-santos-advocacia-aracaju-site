<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$faq_items = [
    [
        '_id' => 'faq_item_01',
        'acc_title' => '1. Como funciona o primeiro atendimento com um advogado?',
        'acc_content' => '<p>O primeiro contato é utilizado para compreender o caso, identificar os principais documentos e avaliar juridicamente as medidas que podem ser adotadas. O atendimento pode ser realizado de forma presencial ou online.</p>',
        'ekit_acc_is_active' => 'yes'
    ],
    [
        '_id' => 'faq_item_02',
        'acc_title' => '2. Posso enviar documentos pelo WhatsApp?',
        'acc_content' => '<p>Sim. Documentos e informações iniciais podem ser encaminhados pelo WhatsApp para facilitar a análise do caso e o atendimento jurídico.</p>'
    ],
    [
        '_id' => 'faq_item_03',
        'acc_title' => '3. Posso contratar o escritório mesmo estando fora de Aracaju?',
        'acc_content' => '<p>Sim. O escritório realiza atendimento online e pode atuar em processos eletrônicos em outras cidades e estados, de acordo com as particularidades de cada demanda.</p>'
    ],
    [
        '_id' => 'faq_item_04',
        'acc_title' => '4. O escritório atua em Direito Trabalhista para empregados e empresas?',
        'acc_content' => '<p>Sim. O atendimento abrange trabalhadores e empresas em questões como rescisão, verbas trabalhistas, horas extras, acidentes de trabalho, defesa empresarial e consultoria preventiva, sempre observando eventual conflito de interesses.</p>'
    ],
    [
        '_id' => 'faq_item_05',
        'acc_title' => '5. O escritório atua com divórcio, guarda e pensão alimentícia?',
        'acc_content' => '<p>Sim. A atuação em Direito de Família compreende divórcio consensual ou litigioso, guarda dos filhos, pensão alimentícia, regulamentação de convivência, união estável e partilha de bens.</p>'
    ],
    [
        '_id' => 'faq_item_06',
        'acc_title' => '6. Quais problemas imobiliários podem ser analisados?',
        'acc_content' => '<p>O escritório atua em questões envolvendo compra e venda de imóveis, distrato imobiliário, atraso de obras, loteamentos, contratos, locações, despejo, regularização e usucapião.</p>'
    ],
    [
        '_id' => 'faq_item_07',
        'acc_title' => '7. O escritório presta assessoria jurídica para empresas?',
        'acc_content' => '<p>Sim. A atuação empresarial envolve elaboração e revisão de contratos, cobranças, prevenção de riscos, conflitos entre sócios e acompanhamento jurídico das atividades da empresa.</p>'
    ],
    [
        '_id' => 'faq_item_08',
        'acc_title' => '8. O escritório realiza inventário e partilha de herança?',
        'acc_content' => '<p>Sim. O inventário pode ser judicial ou extrajudicial, dependendo das circunstâncias do caso. Também são analisadas questões envolvendo herança, partilha de bens e direitos sucessórios.</p>'
    ],
    [
        '_id' => 'faq_item_09',
        'acc_title' => '9. O escritório atua em casos de erro médico e procedimentos estéticos?',
        'acc_content' => '<p>Sim. Podem ser analisados casos envolvendo possível erro médico ou odontológico, falha em hospitais e clínicas, cirurgia plástica, procedimentos estéticos malsucedidos, falha de diagnóstico e outros danos relacionados à prestação de serviços de saúde.</p>'
    ],
    [
        '_id' => 'faq_item_10',
        'acc_title' => '10. Problemas com planos de saúde também são atendidos?',
        'acc_content' => '<p>Sim. O escritório pode analisar negativas de cobertura, tratamentos, cirurgias, medicamentos, exames, internações, reembolsos e outras controvérsias envolvendo planos de saúde.</p>'
    ]
];

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

$updated = false;
foreach ($data as &$sec) {
    if (($sec['id'] ?? '') === '721f6ad6') {
        // Coluna Esquerda: ID 25abf5ce
        foreach ($sec['elements'] as &$col) {
            if (($col['id'] ?? '') === '25abf5ce') {
                // Widget 1: sub-título
                $col['elements'][0]['settings']['title'] = 'Perguntas Frequentes';
                // Widget 2: Título Principal solicitado
                $col['elements'][1]['settings']['title'] = 'Dúvidas frequentes sobre nossos serviços jurídicos em Aracaju';
                // Widget 3: Descrição solicitada
                $col['elements'][2]['settings']['editor'] = '<p>Encontre respostas para algumas das principais dúvidas sobre atendimento, contratação e áreas de atuação.</p>';
            }

            // Coluna Direita: ID 5cd4b89a (Accordion + Novo CTA)
            if (($col['id'] ?? '') === '5cd4b89a') {
                // Atualizar o widget elementskit-accordion
                $acc = &$col['elements'][0];
                $acc['settings']['ekit_accordion_items'] = $faq_items;
                
                // Bordas neutras e detalhes em dourado:
                // Título aberto: cor dourada #C9A45C, borda cinza-clara #E2E8F0
                $acc['settings']['ekit_accordion_title_color'] = '#C9A45C';
                $acc['settings']['ekit_accordion_title_border_open_color'] = '#E2E8F0';
                // Título fechado: cor escura elegante #0B1724, borda cinza-clara #E2E8F0
                $acc['settings']['ekit_accordion_title_color_close'] = '#0B1724';
                $acc['settings']['ekit_accordion_title_border_close_color'] = '#E2E8F0';
                // Ícone dourado (#C9A45C)
                $acc['settings']['ekit_accordion_icon_color'] = '#C9A45C';
                $acc['settings']['ekit_accordion_icon_color_active'] = '#C9A45C';

                // Remover quaisquer referências globais que puxavam cor indesejada
                unset($acc['settings']['__globals__']['ekit_accordion_title_border_open_color']);
                unset($acc['settings']['__globals__']['ekit_accordion_title_border_close_color']);
                unset($acc['settings']['__globals__']['ekit_accordion_title_color']);

                // Adicionar o bloco de CTA logo após o accordion
                // Verificar se já existe widget de CTA na coluna
                $has_cta = false;
                foreach ($col['elements'] as $el) {
                    if (($el['id'] ?? '') === 'faq_cta_heading') {
                        $has_cta = true;
                        break;
                    }
                }

                if (!$has_cta) {
                    $cta_widgets = [
                        [
                            'id' => 'faq_cta_heading',
                            'elType' => 'widget',
                            'widgetType' => 'heading',
                            'settings' => [
                                'title' => 'Ainda tem dúvidas sobre o seu caso?',
                                'header_size' => 'h4',
                                'title_color' => '#0B1724',
                                'typography_font_family' => 'Cinzel',
                                'typography_font_size' => [
                                    'unit' => 'px',
                                    'size' => 22,
                                    'sizes' => []
                                ],
                                '_margin' => [
                                    'unit' => 'px',
                                    'top' => '35',
                                    'right' => '0',
                                    'bottom' => '10',
                                    'left' => '0',
                                    'isLinked' => false
                                ]
                            ],
                            'elements' => []
                        ],
                        [
                            'id' => 'faq_cta_desc',
                            'elType' => 'widget',
                            'widgetType' => 'text-editor',
                            'settings' => [
                                'editor' => '<p style="color: #4A4A4A; font-size: 15px; margin-bottom: 20px;">Converse com nossa equipe e explique sua situação.</p>',
                                '_margin' => [
                                    'unit' => 'px',
                                    'top' => '0',
                                    'right' => '0',
                                    'bottom' => '15',
                                    'left' => '0',
                                    'isLinked' => false
                                ]
                            ],
                            'elements' => []
                        ],
                        [
                            'id' => 'faq_cta_button',
                            'elType' => 'widget',
                            'widgetType' => 'button',
                            'settings' => [
                                'text' => 'Falar pelo WhatsApp',
                                'selected_icon' => [
                                    'value' => 'fab fa-whatsapp',
                                    'library' => 'fa-brands'
                                ],
                                'icon_align' => 'left',
                                'icon_indent' => [
                                    'unit' => 'px',
                                    'size' => 10,
                                    'sizes' => []
                                ],
                                'link' => [
                                    'url' => 'https://wa.me/5579999281768?text=' . rawurlencode('Olá! Estive lendo as dúvidas frequentes e gostaria de conversar com a equipe sobre o meu caso em Aracaju.'),
                                    'is_external' => 'yes',
                                    'nofollow' => '',
                                    'custom_attributes' => ''
                                ],
                                'button_background_color' => '#C9A45C',
                                'button_text_color' => '#071220',
                                'button_hover_background_color' => '#D4B36D',
                                'button_hover_text_color' => '#000000',
                                'size' => 'md',
                                'border_radius' => [
                                    'unit' => 'px',
                                    'top' => '4',
                                    'right' => '4',
                                    'bottom' => '4',
                                    'left' => '4',
                                    'isLinked' => true
                                ],
                                '_box_shadow_box_shadow_type' => 'yes',
                                '_box_shadow_box_shadow' => [
                                    'horizontal' => 0,
                                    'vertical' => 4,
                                    'blur' => 15,
                                    'spread' => 0,
                                    'color' => 'rgba(201, 164, 92, 0.35)'
                                ]
                            ],
                            'elements' => []
                        ]
                    ];

                    foreach ($cta_widgets as $cw) {
                        $col['elements'][] = $cw;
                    }
                }

                $updated = true;
            }
        }
        break;
    }
}

if ($updated) {
    // 1. Atualizar no banco local
    update_post_meta(37, '_elementor_data', wp_slash(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
    if (class_exists('\Elementor\Plugin')) {
        \Elementor\Plugin::$instance->files_manager->clear_cache();
    }
    echo "Sucesso: FAQ da Home atualizado no banco local!\n";

    // 2. Atualizar nos arquivos de sincronização
    $sync_file = dirname(__DIR__) . '/documents/elementor_sync/all_pages_elementor.json';
    $theme_sync_file = dirname(__DIR__) . '/app/public/wp-content/themes/hello-elementor/elementor_sync_data.json';
    
    if (file_exists($sync_file)) {
        $all_sync = json_decode(file_get_contents($sync_file), true);
        $all_sync[37]['elementor_data'] = $data;
        file_put_contents($sync_file, json_encode($all_sync, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        file_put_contents($theme_sync_file, json_encode($all_sync, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        echo "Arquivos de sincronização all_pages_elementor.json e tema atualizados com sucesso!\n";
    }
} else {
    echo "Erro: Seção 721f6ad6 não encontrada.\n";
}

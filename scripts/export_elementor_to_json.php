<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$pages = [37, 249, 277, 261, 212, 338, 15, 18];
$export = [];

foreach ($pages as $id) {
    $p = get_post($id);
    if ($p) {
        $export[$id] = [
            'ID'             => $id,
            'post_title'     => $p->post_title,
            'post_name'      => $p->post_name,
            'post_type'      => $p->post_type,
            'elementor_data' => json_decode(get_post_meta($id, '_elementor_data', true), true),
            'page_settings'  => get_post_meta($id, '_elementor_page_settings', true),
            'rank_math'      => [
                'title' => get_post_meta($id, 'rank_math_title', true),
                'desc'  => get_post_meta($id, 'rank_math_description', true),
                'focus' => get_post_meta($id, 'rank_math_focus_keyword', true),
            ]
        ];
    }
}

$dir = dirname(__DIR__) . '/documents/elementor_sync/';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

file_put_contents($dir . 'all_pages_elementor.json', json_encode($export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
echo "Exportadas " . count($export) . " páginas/templates com layout Elementor para documents/elementor_sync/all_pages_elementor.json\n";

<?php
/**
 * Script de Importação Automática para Produção
 * Pode ser executado via navegador (acessando /sync-elementor.php?token=jorge_aracaju_2026)
 * ou via WP-CLI / terminal: php sync-elementor.php
 */

require_once __DIR__ . '/wp-load.php';

$token_esperado = 'jorge_aracaju_2026';
if (php_sapi_name() !== 'cli') {
    $token_enviado = $_GET['token'] ?? '';
    if ($token_enviado !== $token_esperado) {
        wp_die('Acesso negado. Token inválido.');
    }
}

$sync_file = dirname(__DIR__, 2) . '/documents/elementor_sync/all_pages_elementor.json';
if (!file_exists($sync_file)) {
    // Tenta caminho alternativo relativo
    $sync_file = ABSPATH . '../documents/elementor_sync/all_pages_elementor.json';
    if (!file_exists($sync_file)) {
        $sync_file = dirname(ABSPATH) . '/documents/elementor_sync/all_pages_elementor.json';
    }
}

if (!file_exists($sync_file)) {
    die("Arquivo all_pages_elementor.json não encontrado.\n");
}

$pages = json_decode(file_get_contents($sync_file), true);
echo "Iniciando sincronização de " . count($pages) . " páginas/templates...\n";

foreach ($pages as $orig_id => $data) {
    // Encontrar post por slug
    $target_post = get_page_by_path($data['post_name'], OBJECT, ['page', 'elementor_library']);
    if (!$target_post) {
        $args = [
            'name' => $data['post_name'],
            'post_type' => $data['post_type'],
            'posts_per_page' => 1
        ];
        $posts = get_posts($args);
        if (!empty($posts)) {
            $target_post = $posts[0];
        }
    }

    if (!$target_post) {
        // Se for a página inicial
        if ($data['post_name'] === 'home' || $data['post_name'] === 'inicio' || $orig_id == 37) {
            $front_page_id = get_option('page_on_front');
            if ($front_page_id) {
                $target_post = get_post($front_page_id);
            }
        }
    }

    if ($target_post) {
        $post_id = $target_post->ID;
        update_post_meta($post_id, '_elementor_data', wp_slash(json_encode($data['elementor_data'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)));
        update_post_meta($post_id, '_elementor_edit_mode', 'builder');
        if (!empty($data['page_settings'])) {
            update_post_meta($post_id, '_elementor_page_settings', $data['page_settings']);
        }
        if (!empty($data['rank_math'])) {
            update_post_meta($post_id, 'rank_math_title', $data['rank_math']['title']);
            update_post_meta($post_id, 'rank_math_description', $data['rank_math']['desc']);
            update_post_meta($post_id, 'rank_math_focus_keyword', $data['rank_math']['focus']);
        }
        echo "Atualizado: {$data['post_title']} (ID: {$post_id})\n";
    } else {
        echo "Não encontrado por slug: {$data['post_name']}\n";
    }
}

if (class_exists('\Elementor\Plugin')) {
    \Elementor\Plugin::$instance->files_manager->clear_cache();
}

echo "Sincronização concluída com sucesso e cache do Elementor limpo!\n";

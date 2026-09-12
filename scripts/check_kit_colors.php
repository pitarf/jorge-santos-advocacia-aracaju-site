<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$kit_id = get_option('elementor_active_kit');
$meta = get_post_meta($kit_id, '_elementor_page_settings', true);

echo "Kit ID: {$kit_id}\n";
if (!empty($meta['system_colors'])) {
    echo "--- System Colors ---\n";
    foreach ($meta['system_colors'] as $c) {
        echo "{$c['_id']} ({$c['title']}): {$c['color']}\n";
    }
}
if (!empty($meta['custom_colors'])) {
    echo "--- Custom Colors ---\n";
    foreach ($meta['custom_colors'] as $c) {
        echo "{$c['_id']} ({$c['title']}): {$c['color']}\n";
    }
}

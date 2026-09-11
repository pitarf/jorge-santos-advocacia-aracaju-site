<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

foreach ($data as $root_el) {
    if (!empty($root_el['elements'])) {
        foreach ($root_el['elements'] as $widget) {
            if (($widget['widgetType'] ?? '') === 'slides') {
                echo "Container ID: " . ($root_el['id'] ?? '') . "\n";
                echo "Container settings: " . json_encode($root_el['settings'] ?? [], JSON_PRETTY_PRINT) . "\n";
                echo "Slides settings keys: " . implode(', ', array_keys($widget['settings'])) . "\n";
                echo "Slides height: " . json_encode($widget['settings']['slides_height'] ?? []) . "\n";
                echo "Slide 0 settings: " . json_encode($widget['settings']['slides'][0] ?? [], JSON_PRETTY_PRINT) . "\n";
            }
        }
    }
}

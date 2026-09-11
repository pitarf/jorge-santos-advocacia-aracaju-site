<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

function inspect_elements($elements, $depth = 0) {
    foreach ($elements as $el) {
        $type = $el['elType'] ?? 'unknown';
        $widgetType = $el['widgetType'] ?? '';
        $id = $el['id'] ?? '';
        $indent = str_repeat('  ', $depth);
        if ($type === 'widget') {
            echo "{$indent}[Widget] {$widgetType} (ID: {$id})\n";
            if (strpos($widgetType, 'carousel') !== false || strpos($widgetType, 'slider') !== false || strpos($widgetType, 'logo') !== false) {
                echo "{$indent}  Keys: " . implode(', ', array_keys($el['settings'])) . "\n";
            }
        } else {
            echo "{$indent}[{$type}] ID: {$id}\n";
        }
        if (!empty($el['elements'])) {
            inspect_elements($el['elements'], $depth + 1);
        }
    }
}

inspect_elements($data);

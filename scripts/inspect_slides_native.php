<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

function inspect_sections($elements, $depth = 0) {
    foreach ($elements as $el) {
        $type = $el['elType'] ?? 'unknown';
        $widgetType = $el['widgetType'] ?? '';
        $id = $el['id'] ?? '';
        $indent = str_repeat('  ', $depth);
        if ($type === 'widget') {
            echo "{$indent}[Widget: {$widgetType}] ID: {$id}\n";
            if ($widgetType === 'slides' || strpos($widgetType, 'slide') !== false || strpos($widgetType, 'carousel') !== false) {
                echo "{$indent}  Config keys: " . implode(', ', array_keys($el['settings'])) . "\n";
                if (isset($el['settings']['slides'])) {
                    echo "{$indent}  Slides count: " . count($el['settings']['slides']) . "\n";
                    foreach ($el['settings']['slides'] as $i => $s) {
                        echo "{$indent}    Slide {$i}: heading='{$s['heading']}', bg_url='{$s['background_image']['url']}'\n";
                    }
                }
            }
        } else {
            echo "{$indent}[{$type}] ID: {$id}\n";
        }
        if (!empty($el['elements'])) {
            inspect_sections($el['elements'], $depth + 1);
        }
    }
}

inspect_sections($data);

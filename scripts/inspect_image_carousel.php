<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

foreach ($data as $sec) {
    if (($sec['id'] ?? '') === '4c6ef8c0') {
        echo json_encode($sec, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

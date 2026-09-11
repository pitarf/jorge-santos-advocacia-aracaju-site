<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

$first_element = $data[0];
file_put_contents(dirname(__DIR__) . '/documents/native_slides_widget.json', json_encode($first_element, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
echo "Widget nativo salvo em documents/native_slides_widget.json\n";

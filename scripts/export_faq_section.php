<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data_raw = get_post_meta(37, '_elementor_data', true);
$data = json_decode($data_raw, true);

foreach ($data as $sec) {
    if (($sec['id'] ?? '') === '721f6ad6') {
        file_put_contents(dirname(__DIR__) . '/documents/faq_section_current.json', json_encode($sec, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        echo "Seção FAQ exportada para documents/faq_section_current.json\n";
        break;
    }
}

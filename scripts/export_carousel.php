<?php
require_once dirname(__DIR__) . '/app/public/wp-load.php';

$data = json_decode(get_post_meta(37, '_elementor_data', true), true);

foreach ($data as $sec) {
    if (($sec['id'] ?? '') === 'areas_carousel_sec_replace') {
        file_put_contents(dirname(__DIR__) . '/documents/areas_carousel_current.json', json_encode($sec, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        echo "Exportado para documents/areas_carousel_current.json\n";
    }
}

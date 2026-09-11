<?php
$dir = dirname(__DIR__) . '/app/public/wp-content/uploads/2026/09/';
$files = [
    'hero-geral.jpg',
    'hero-trabalhista.jpg',
    'hero-trabalhista-person.jpg',
    'hero-divorcio.jpg',
    'hero-familia-person.jpg',
    'hero-dama-justica.jpg',
    'hero-imobiliario.jpg',
    'hero-imobiliario-bldg.jpg',
    'hero-empresarial.jpg',
    'hero-empresarial-person.jpg',
    'hero-inventario.jpg',
    'hero-inventario-doc.jpg'
];
foreach ($files as $f) {
    if (file_exists($dir . $f)) {
        $sz = getimagesize($dir . $f);
        echo "$f: {$sz[0]} x {$sz[1]}\n";
    }
}

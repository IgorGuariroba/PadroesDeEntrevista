<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Controllers\VendasController;

$controller = new VendasController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'calcular':
        $controller->calcular();
        break;
    case 'index':
    default:
        $controller->index();
        break;
}

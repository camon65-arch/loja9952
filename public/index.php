<?php
require_once __DIR__.'/../vendor/autoload.php';

$env = parse_ini_file(__DIR__.'/../.env', false, INI_SCANNER_RAW);
if ($env !== false) {
    foreach ($env as $k => $v) {
        $_ENV[$k] = $v;
    }
}

use App\Controller\VeiculoController;

$uri     = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
$partes  = explode('/', $uri);
$recurso = $partes[0] ?? '';
$acao    = $partes[1] ?? '';
$id      = (int) ($partes[2] ?? 0);

$ctrl = new VeiculoController();

match ("$recurso/$acao") {
    '/' => $ctrl->catalogo(),
    'veiculo/detalhe' => $ctrl->detalhe($id),
    default => $ctrl->catalogo(),
};

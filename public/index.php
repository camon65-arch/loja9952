<?php

// ... outros imports existentes ...
use App\Controller\CarrinhoController;

$url = $_SERVER['REQUEST_URI']; // Captura o URL atual

// O bloco match associa o URL ao método correto do controlador
match ($url) {
    '/'                  => (new HomeController())->index(),
    'carrinho/'          => (new CarrinhoController())->ver(),
    'carrinho/adicionar' => (new CarrinhoController())->adicionar(),
    'carrinho/remover'   => (new CarrinhoController())->remover(),
    default              => (new ErrorController())->notFound(),
};

require_once __DIR__.'/../vendor/autoload.php';

$env = parse_ini_file(__DIR__.'/../.env', false, INI_SCANNER_RAW);
if ($env !== false) {
    foreach ($env as $k => $v) {
        $_ENV[$k] = $v;
    }
}

use App\Controller\CarrinhoController;
use App\Controller\VeiculoController;

$uri     = trim(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/', '/');
$partes  = explode('/', $uri);
$recurso = $partes[0] ?? '';
$acao    = $partes[1] ?? '';
$id      = (int) ($partes[2] ?? 0);
$rota    = "$recurso/$acao";

if ($rota === 'veiculo/detalhe') {
    (new VeiculoController())->detalhe($id);
    exit;
}

if ($rota === 'carrinho/') {
    (new CarrinhoController())->ver();
    exit;
}

if ($rota === 'carrinho/adicionar') {
    (new CarrinhoController())->adicionar();
    exit;
}

if ($rota === 'carrinho/remover') {
    (new CarrinhoController())->remover();
    exit;
}

(new VeiculoController())->catalogo();

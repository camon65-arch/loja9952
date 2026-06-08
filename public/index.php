<?php

require_once __DIR__.'/../vendor/autoload.php';

use App\Controller\CarrinhoController;
use App\Controller\AuthController;
use App\Controller\ContaController;
use App\Controller\CheckoutController;
use App\Controller\VeiculoController;
use App\Controller\ErrorController;

// Carrega variáveis de ambiente
$env = parse_ini_file(__DIR__.'/../.env', false, INI_SCANNER_RAW);
if ($env !== false) {
    foreach ($env as $k => $v) {
        $_ENV[$k] = $v;
    }
}

// Funções Helper para CSRF (Necessárias para Login e Registo)
function csrf_token() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_validar() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || $token !== ($_SESSION['csrf_token'] ?? '')) {
        http_response_code(403);
        die('Erro de segurança: Token CSRF inválido ou ausente.');
    }
}

// Determina a BASE_URL e limpa a rota
$base_path = (strpos($_SERVER['SCRIPT_NAME'], '/loja9952') === 0) ? '/loja9952' : '';
define('BASE_URL', $base_path);

$request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$route = str_replace($base_path, '', $request_path);
$route = '/' . trim($route, '/');

// Roteamento Unificado
match (true) {
    $route === '/' || $route === '/index.php' => (new VeiculoController())->catalogo(),
    $route === '/login'             => (new AuthController())->login(),
    $route === '/registar'          => (new AuthController())->registar(),
    $route === '/logout'            => (new AuthController())->logout(),
    $route === '/conta'             => (new ContaController())->ver(),
    $route === '/carrinho'          => (new CarrinhoController())->ver(),
    $route === '/carrinho/adicionar'=> (new CarrinhoController())->adicionar(),
    $route === '/checkout'          => (new CheckoutController())->ver(),
    $route === '/checkout/confirmar'=> (new CheckoutController())->confirmar(),
    $route === '/carrinho/remover'  => (new CarrinhoController())->remover(),
    strpos($route, '/veiculo/detalhe/') === 0 => (function() use ($route) {
        $id = (int)explode('/', $route)[3];
        (new VeiculoController())->detalhe($id);
    })(),
    default => (new VeiculoController())->catalogo() // Redireciona para o catálogo se não encontrar
};

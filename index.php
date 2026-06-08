<?php

// 1. Autoloader simples para o namespace 'App'
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

// 2. Função helper para o CSRF (necessária para o template detalhe.php)
function csrf_token() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Valida o token CSRF enviado via POST para proteger formulários
 */
function csrf_validar() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || $token !== ($_SESSION['csrf_token'] ?? '')) {
        http_response_code(403);
        die('Erro de segurança: Token CSRF inválido ou ausente.');
    }
}

// 3. Roteamento básico para teste
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = (strpos($_SERVER['SCRIPT_NAME'], '/loja9952') === 0) ? '/loja9952' : '';
define('BASE_URL', $base_path);
$path = str_replace($base_path, '', $request_uri);

if ($path === '/' || $path === '/index.php') {
    (new App\Controller\VeiculoController())->catalogo();
} 
elseif (strpos($path, '/veiculo/detalhe') !== false) {
    // Extrai o ID do path (/veiculo/detalhe/1) ou da query string (?id=1)
    $partes = explode('/', trim($path, '/'));
    $id = (int) ($_GET['id'] ?? ($partes[2] ?? 0));
    (new App\Controller\VeiculoController())->detalhe($id);
}
elseif ($path === '/login') {
    (new App\Controller\AuthController())->login();
}
elseif ($path === '/registar') {
    (new App\Controller\AuthController())->registar();
}
elseif ($path === '/logout') {
    (new App\Controller\AuthController())->logout();
}
elseif ($path === '/conta') {
    (new App\Controller\ContaController())->ver();
}
elseif ($path === '/conta/cancelar-reserva') {
    (new App\Controller\ContaController())->cancelarReserva();
}
elseif (strpos($path, '/carrinho/adicionar') !== false) {
    (new App\Controller\CarrinhoController())->adicionar();
}
elseif (strpos($path, '/carrinho/remover') !== false) {
    (new App\Controller\CarrinhoController())->remover();
}
elseif (strpos($path, '/carrinho') !== false) {
    (new App\Controller\CarrinhoController())->ver();
}
elseif ($path === '/checkout') {
    (new App\Controller\CheckoutController())->ver();
}
elseif ($path === '/checkout/confirmar') {
    (new App\Controller\CheckoutController())->confirmar();
}
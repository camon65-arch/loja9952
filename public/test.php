<?php

/**
 * Ficheiro de Teste de Conexão
 * Localização: /public/test.php
 */

// 1. Autoloader manual para este ficheiro (já que ele está fora da raiz)
// Ele sobe um nível para encontrar a pasta 'src'
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = dirname(__DIR__) . '/src/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) require $file;
});

try {
    echo "<h1>Teste de Diagnóstico</h1>";
    
    // Tenta estabelecer ligação
    $db = App\Database::getConnection();
    echo "✅ <span style='color:green'>Sucesso!</span> Ligação à base de dados estabelecida.";
    
} catch (Exception $e) {
    echo "❌ <span style='color:red'>Erro:</span> " . $e->getMessage();
    echo "<br><br><strong>Dica:</strong> Verifica se o ficheiro <code>.env</code> existe em: " . realpath(dirname(__DIR__) . '/.env');
}
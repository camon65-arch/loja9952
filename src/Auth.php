<?php
namespace App;

/**
 * Classe utilitária para gestão de acesso e segurança
 */
class Auth {
    public static function verificar(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (empty($_SESSION['logado']) || $_SESSION['logado'] !== true) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
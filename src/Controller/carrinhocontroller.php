<?php
namespace App\Controller;
 
use App\Model\VeiculoModel;
 
class CarrinhoController {
    private VeiculoModel $model;
 
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->model = new VeiculoModel();
    }
 
    /**
     * Retorna o caminho base do projeto para redirecionamentos.
     * Útil quando o projeto está numa subpasta do Laragon (/loja9952).
     */
    private function getBaseUrl(): string {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        return (strpos($scriptName, '/loja9952') === 0) ? '/loja9952' : '';
    }

    // Mostrar o carrinho
    public function ver(): void {
        $ids      = $_SESSION['carrinho'] ?? [];
        $veiculos = array_map(fn($id) => $this->model->getById($id), $ids);
        $veiculos = array_filter($veiculos); // remover IDs inválidos
        $titulo   = 'A minha lista de reservas';
        require dirname(__DIR__, 2) . '/templates/carrinho/ver.php';
    }
 
    // Adicionar ao carrinho
    public function adicionar(): void {
        csrf_validar();
        $id = (int) ($_POST['veiculo_id'] ?? 0);
        if ($id > 0) {
            $veiculo = $this->model->getById($id);
            $carrinho = $_SESSION['carrinho'] ?? [];
            if ($veiculo && $veiculo['is_reservado'] > 0) {
                $_SESSION['msg_erro'] = 'Desculpe, este veículo já foi reservado por outro cliente.';
            } elseif ($veiculo && !in_array($id, $carrinho)) {
                $carrinho[] = $id;
                $_SESSION['carrinho'] = $carrinho;
                $_SESSION['msg_ok']   = 'Veículo adicionado à lista!';
            } elseif ($veiculo) {
                $_SESSION['msg_info'] = 'Este veículo já está na tua lista.';
            }
        }
        header("Location: " . $this->getBaseUrl() . "/carrinho");
        exit;
    }
 
    // Remover do carrinho
    public function remover(): void {
        csrf_validar();
        $id = (int) ($_POST['veiculo_id'] ?? 0);
        $carrinho = $_SESSION['carrinho'] ?? [];
        $carrinho = array_values(array_filter($carrinho, fn($i) => $i !== $id));
        $_SESSION['carrinho'] = $carrinho;
        header("Location: " . $this->getBaseUrl() . "/carrinho");
        exit;
    }
}

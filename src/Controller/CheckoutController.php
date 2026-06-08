<?php
namespace App\Controller;
 
use App\Auth;
use App\Model\ReservaModel;
use App\Model\VeiculoModel;
 
class CheckoutController {
    public function ver(): void {
        Auth::verificar();
        if (session_status() === PHP_SESSION_NONE) session_start();
 
        $ids = $_SESSION['carrinho'] ?? [];
        if (empty($ids)) {
            header('Location: /carrinho');
            exit;
        }

        $model    = new VeiculoModel();
        // Apenas veículos que ainda estão disponíveis podem ser processados
        $veiculos = array_filter(array_map(fn($id) => $model->getById($id), $ids), fn($v) => $v && $v['disponivel'] == 1);
        $titulo   = 'Confirmar reserva';
        require dirname(__DIR__, 2) . '/templates/checkout/ver.php';
    }
 
    public function confirmar(): void {
        Auth::verificar();
        csrf_validar();
 
        $ids       = $_SESSION['carrinho'] ?? [];
        $clienteId = $_SESSION['cliente_id'];
        $mensagem  = trim($_POST['mensagem'] ?? '');
 
        $reservaModel = new ReservaModel();
        $confirmadas  = 0;
 
        foreach ($ids as $veiculoId) {
            try {
                $reservaModel->criar($clienteId, (int)$veiculoId, $mensagem);
                $confirmadas++;
            } catch (\Exception $e) {
                // Veículo pode já não estar disponível — ignorar
                error_log('Erro ao criar reserva: '.$e->getMessage());
            }
        }
 
        // Limpar carrinho após checkout:
        $_SESSION['carrinho'] = [];
        $_SESSION['msg_ok']   = "$confirmadas reserva(s) confirmada(s)! A nossa equipa entrará em contacto.";
        header('Location: ' . BASE_URL . '/conta');
        exit;
    }
}
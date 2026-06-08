<?php
namespace App\Controller;
 
use App\Auth;
use App\Model\ClienteModel;
use App\Model\ReservaModel;
 
class ContaController {
    public function ver(): void {
        Auth::verificar();
        $clienteId = $_SESSION['cliente_id'];
        $cliente   = (new ClienteModel())->getById($clienteId);
        $reservas  = (new ReservaModel())->getByCliente($clienteId);
        $titulo   = 'A minha conta';
        require dirname(__DIR__, 2) . '/templates/conta/ver.php';
    }

    public function cancelarReserva(): void {
        Auth::verificar();
        csrf_validar();

        $reservaId = (int) ($_POST['reserva_id'] ?? 0);
        $clienteId = $_SESSION['cliente_id'];

        $reservaModel = new ReservaModel();
        if ($reservaModel->cancelar($reservaId, $clienteId)) {
            $_SESSION['msg_ok'] = 'Reserva cancelada com sucesso! O veículo foi devolvido ao catálogo.';
        } else {
            $_SESSION['msg_erro'] = 'Não foi possível cancelar a reserva ou a reserva não existe.';
        }

        header('Location: ' . BASE_URL . '/conta');
        exit;
    }
}

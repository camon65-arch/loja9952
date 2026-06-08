<?php
namespace App\Model;
 
use App\Database;
use PDO;
 
class ReservaModel {
    private PDO $db;
 
    public function __construct() {
        $this->db = Database::getConnection();
    }
 
    // Criar reserva + marcar veículo como indisponível (transação)
    public function criar(int $clienteId, int $veiculoId, string $msg = ''): int {
        try {
            $this->db->beginTransaction();
 
            // Verificar se o veículo já foi reservado por outra pessoa
            $stmtCheck = $this->db->prepare('SELECT id FROM reservas WHERE veiculo_id = :vid');
            $stmtCheck->execute([':vid' => $veiculoId]);
            if ($stmtCheck->fetch()) {
                $this->db->rollBack();
                throw new \Exception('Este veículo já não se encontra disponível para reserva.');
            }

            // Inserir reserva:
            $stmt = $this->db->prepare(
                'INSERT INTO reservas (cliente_id, veiculo_id, mensagem)
                 VALUES (:cid, :vid, :msg)'
            );
            $stmt->execute([':cid'=>$clienteId,':vid'=>$veiculoId,':msg'=>$msg]);
            $id = (int) $this->db->lastInsertId();
 
            $this->db->commit();
            return $id;
 
        } catch (\PDOException $e) {
            $this->db->rollBack();
            // Optionally log the error here: error_log($e->getMessage());
            throw $e;
        }
    }
 
    // Reservas de um cliente com detalhe do veículo:
    public function getByCliente(int $clienteId): array {
        $stmt = $this->db->prepare(
            'SELECT r.*, v.modelo, v.ano, v.preco, m.nome AS marca
             FROM reservas r
             JOIN veiculos v ON v.id = r.veiculo_id
             JOIN marcas m ON m.id = v.marca_id
             WHERE r.cliente_id = :cid
             ORDER BY r.criado_em DESC'
        );
        $stmt->execute([':cid' => $clienteId]);
        return $stmt->fetchAll();
    }

    // Anular reserva + marcar veículo como disponível (transação)
    public function cancelar(int $reservaId, int $clienteId): bool {
        try {
            $this->db->beginTransaction();

            // 1. Obter o veiculo_id da reserva para o cliente especificado
            $stmt = $this->db->prepare(
                'SELECT veiculo_id FROM reservas WHERE id = :rid AND cliente_id = :cid'
            );
            $stmt->execute([':rid' => $reservaId, ':cid' => $clienteId]);
            $reserva = $stmt->fetch();

            if (!$reserva) {
                $this->db->rollBack();
                return false; // Reserva não encontrada ou não pertence a este cliente
            }
            $veiculoId = $reserva['veiculo_id'];

            // 2. Apagar a reserva
            $stmt = $this->db->prepare('DELETE FROM reservas WHERE id = :rid');
            $stmt->execute([':rid' => $reservaId]);

            $this->db->commit();
            return true;
        } catch (\PDOException $e) {
            $this->db->rollBack();
            error_log('Erro ao cancelar reserva: ' . $e->getMessage());
            throw $e;
        }
    }
}
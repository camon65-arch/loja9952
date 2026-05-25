<?php
namespace App\Controller;

use App\Model\VeiculoModel;

class VeiculoController {
    private VeiculoModel $model;

    public function __construct() {
        $this->model = new VeiculoModel();
    }

    public function catalogo(): void {
        // Recolher filtros do URL (?marca_id=1&preco_max=20000...)
        $filtros = [
            'marca_id'    => (int) ($_GET['marca_id'] ?? 0) ?: null,
            'combustivel' => $_GET['combustivel'] ?? null,
            'preco_max'   => (float) ($_GET['preco_max'] ?? 0) ?: null,
            'ano_min'     => (int) ($_GET['ano_min'] ?? 0) ?: null,
            'pesquisa'    => trim($_GET['pesquisa'] ?? ''),
        ];

        // Remover filtros vazios:
        $filtros = array_filter($filtros);

        $veiculos = $this->model->listar($filtros);
        $marcas   = $this->model->getMarcas();
        $titulo   = 'Catálogo de Veículos';

        require dirname(__DIR__, 2).'/templates/veiculos/catalogo.php';
    }

    public function detalhe(int $id): void {
        if ($id <= 0) {
            http_response_code(404);
            echo 'Veículo não encontrado.';
            return;
        }

        $veiculo = $this->model->getById($id);
        if ($veiculo === false) {
            http_response_code(404);
            echo 'Veículo não encontrado.';
            return;
        }

        $nome = htmlspecialchars($veiculo['marca'].' '.$veiculo['modelo'], ENT_QUOTES, 'UTF-8');
        $preco = number_format((float) $veiculo['preco'], 2, ',', '.');
        $ano = htmlspecialchars((string) $veiculo['ano'], ENT_QUOTES, 'UTF-8');
        $combustivel = htmlspecialchars((string) $veiculo['combustivel'], ENT_QUOTES, 'UTF-8');

        echo "<!DOCTYPE html><html lang=\"pt\"><head><meta charset=\"UTF-8\"><title>{$nome}</title></head><body>";
        echo "<h1>{$nome}</h1>";
        echo "<p>{$ano} · {$combustivel}</p>";
        echo "<p><strong>{$preco} €</strong></p>";
        echo '<p><a href="/">Voltar ao catálogo</a></p>';
        echo '</body></html>';
    }
}

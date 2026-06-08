<?php require_once dirname(__DIR__) . '/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4"><?php echo $titulo; ?></h1>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Resumo da Reserva (<?php echo count($veiculos); ?> veículo(s))</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 150px;">Imagem</th>
                                <th>Veículo</th>
                                <th class="text-end">Preço</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $v): ?>
                            <tr>
                                <td class="align-middle">
                                    <?php render_carrossel_veiculo($v, 'carrossel--carrinho'); ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($v['marca'] . ' ' . $v['modelo']); ?></strong>
                                    <br>
                                    <small class="text-muted">Ano: <?php echo $v['ano']; ?></small>
                                </td>
                                <td class="text-end align-middle">
                                    <?php echo number_format($v['preco'], 2, ',', '.'); ?> €
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="alert alert-info">
                <strong>Warning:</strong> Ao confirmar, o veículo será reservado na sua conta e ficará marcado como "Reservado" no catálogo.
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/checkout/confirmar" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        <div class="mb-3">
                            <label class="form-label">Mensagem para o vendedor</label>
                            <textarea name="mensagem" class="form-control" rows="4"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">adicionar á minha conta</button>
                        <a href="<?php echo BASE_URL; ?>/" class="btn btn-link w-100 mt-2">Voltar ao catálogo</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__DIR__) . '/footer.php'; ?>
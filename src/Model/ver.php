<?php require_once __DIR__ . '/../layout/header.php'; ?>

<div class="container my-5">
    <h1 class="mb-4"><?php echo $titulo; ?></h1>

    <div class="row">
        <!-- Lista de Veículos a Reservar -->
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Resumo da Reserva (<?php echo count($veiculos); ?> veículo(s))</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Veículo</th>
                                <th class="text-end">Preço</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $v): ?>
                            <tr>
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

            <div class="alert alert-info border-info">
                <i class="bi bi-info-circle-fill me-2"></i>
                <strong>Warning:</strong> Esta é uma reserva simulada — sem pagamento online.
            </div>
        </div>

        <!-- Formulário de Confirmação -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/checkout/confirmar" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                        
                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Informações adicionais para o vendedor</label>
                            <textarea name="mensagem" id="mensagem" class="form-control" rows="5" 
                                      placeholder="Ex: Horário preferencial para contacto..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Adicionar á reserva
                            </button>
                            <a href="<?php echo BASE_URL; ?>/" class="btn btn-outline-secondary">
                                Voltar ao catálogo
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layout/footer.php'; ?>
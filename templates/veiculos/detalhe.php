<?php // templates/veiculos/detalhe.php
?>
<?php require __DIR__ . '/../header.php'; ?>
    <a href="<?= BASE_URL ?>/">← Voltar ao catálogo</a>
    <h1><?= htmlspecialchars($veiculo['marca'].' '.$veiculo['modelo']) ?></h1>
 
    <div style="display: flex; gap: 40px; margin-top: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <!-- Espaço para a Foto -->
        <div style="flex: 1; min-width: 300px;">
            <?php render_carrossel_veiculo($veiculo, 'carrossel--detalhe'); ?>
        </div>

        <!-- Informações e Ações -->
        <div style="flex: 1; min-width: 300px;">
    <table>
        <tr><th>Marca</th>      <td><?= htmlspecialchars($veiculo['marca']) ?></td></tr>
        <tr><th>Modelo</th>     <td><?= htmlspecialchars($veiculo['modelo']) ?></td></tr>
        <tr><th>Ano</th>        <td><?= $veiculo['ano'] ?></td></tr>
        <tr><th>Quilómetros</th><td><?= number_format($veiculo['quilometros'],0,'.','.') ?> km</td></tr>
        <tr><th>Combustível</th><td><?= htmlspecialchars($veiculo['combustivel']) ?></td></tr>
        <?php if($veiculo['cilindrada']): ?>
        <tr><th>Cilindrada</th><td><?= htmlspecialchars($veiculo['cilindrada']) ?></td></tr>
        <?php endif ?>
        <tr><th>Preço</th>      <td><strong><?= number_format($veiculo['preco'],2,',','.') ?> €</strong></td></tr>
    </table>
 
            <div style="margin-top: 25px;">
                <form method="POST" action="<?= BASE_URL ?>/carrinho/adicionar">
                    <input type="hidden" name="veiculo_id" value="<?= $veiculo['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; font-size: 1.1rem; width: 100%; font-weight: bold; transition: background 0.3s;">
                        🛒 Adicionar à lista de reservas
                    </button>
                </form>
            </div>
        </div>
    </div>

    <?php if ($veiculo['descricao']): ?>
        <h3>Descrição</h3>
        <p><?= nl2br(htmlspecialchars($veiculo['descricao'])) ?></p>
    <?php endif ?>
</body></html>

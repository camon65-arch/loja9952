<?php // templates/carrinho/ver.php ?>
<?php require __DIR__ . '/../header.php'; ?>
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>

    <p><a href="<?= BASE_URL ?>/">Voltar ao catalogo</a></p>

    <?php if (!empty($_SESSION['msg_ok'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_SESSION['msg_ok'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php unset($_SESSION['msg_ok']); ?>
    <?php endif ?>

    <?php if (!empty($_SESSION['msg_info'])): ?>
        <p style="color:#555;"><?= htmlspecialchars($_SESSION['msg_info'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php unset($_SESSION['msg_info']); ?>
    <?php endif ?>

    <?php if (empty($veiculos)): ?>
        <p>A tua lista de reservas está vazia.</p>
    <?php else: ?>
        <div class="resumo-lista">
            Tens <strong><?= count($veiculos) ?></strong> veículo(s) na tua lista.
        </div>

        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Veiculo</th>
                    <th>Preco</th>
                    <th>Acao</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($veiculos as $v): ?>
                <tr>
                    <td>
                        <img src="<?= BASE_URL ?>/img/veiculos/<?= htmlspecialchars($v['foto'] ?? 'default.jpg', ENT_QUOTES, 'UTF-8') ?>" alt="Foto" class="img-carrinho">
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/veiculo/detalhe/<?= (int) $v['id'] ?>">
                            <?= htmlspecialchars($v['marca'].' '.$v['modelo'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </td>
                    <td class="preco"><?= number_format((float) $v['preco'], 2, ',', '.') ?> EUR</td>
                    <td>
                        <form method="POST" action="<?= BASE_URL ?>/carrinho/remover">
                            <input type="hidden" name="veiculo_id" value="<?= (int) $v['id'] ?>">
                            <?php if (function_exists('csrf_token')): ?>
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                            <?php endif ?>
                            <button class="botao remover" type="submit">Remover</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div style="text-align: right; margin-top: 30px;">
            <a href="<?= BASE_URL ?>/checkout" class="botao btn-checkout">Prosseguir para reserva</a>
        </div>
    <?php endif ?>
</body>
</html>

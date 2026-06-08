<?php // templates/veiculos/catalogo.php ?>
<?php require __DIR__ . '/../header.php'; ?>

<style>
    .card { position: relative; overflow: hidden; }
    .ribbon-reservado {
        position: absolute;
        top: 15px;
        left: -30px;
        width: 120px;
        background-color: #d9534f;
        color: white;
        text-align: center;
        font-weight: bold;
        font-size: 0.75rem;
        transform: rotate(-45deg);
        z-index: 5;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>

    <h1>AutoShop - Catálogo de Veículos</h1>

    <form class="filtros" method="GET" action="">
        <select name="marca_id">
            <option value="">Todas as marcas</option>
            <?php foreach ($marcas as $m): ?>
            <option value="<?= (int) $m['id'] ?>"
                <?= (($_GET['marca_id'] ?? '') == $m['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m['nome'], ENT_QUOTES, 'UTF-8') ?>
            </option>
            <?php endforeach ?>
        </select>
        <select name="combustivel">
            <option value="">Combustível</option>
            <?php foreach (['Gasolina','Diesel','Elétrico','Híbrido'] as $c): ?>
            <option <?= (($_GET['combustivel'] ?? '') === $c) ? 'selected' : '' ?>><?= htmlspecialchars($c, ENT_QUOTES, 'UTF-8') ?></option>
            <?php endforeach ?>
        </select>
        <input type="number" name="preco_max" placeholder="Preço máx. (€)"
               value="<?= htmlspecialchars($_GET['preco_max'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="number" name="ano_min" placeholder="Ano mínimo"
               value="<?= htmlspecialchars($_GET['ano_min'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="text" name="pesquisa" placeholder="Pesquisar modelo..."
               value="<?= htmlspecialchars($_GET['pesquisa'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <button type="submit">Filtrar</button>
        <a href="/" style="padding:8px 14px;color:#555;text-decoration:none;">Limpar</a>
    </form>

    <p><?= count($veiculos) ?> veículo(s) encontrado(s)</p>

    <?php if (empty($veiculos)): ?>
        <p style="color:#888;">Nenhum veículo corresponde aos filtros selecionados.</p>
    <?php else: ?>
    <div class="grelha">
    <?php foreach ($veiculos as $v): ?>
        <div class="card">
            <?php if (!empty($v['is_reservado']) && $v['is_reservado'] > 0): ?>
                <div class="ribbon-reservado">RESERVADO</div>
            <?php endif; ?>
            <?php render_carrossel_veiculo($v, 'carrossel--card'); ?>
            <div class="card-body">
                <h3><?= htmlspecialchars($v['marca'].' '.$v['modelo'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars((string) $v['ano'], ENT_QUOTES, 'UTF-8') ?> · <?= number_format((float) $v['quilometros'], 0, '.', '.') ?> km · <?= htmlspecialchars($v['combustivel'], ENT_QUOTES, 'UTF-8') ?></p>
                <div class="preco"><?= number_format((float) $v['preco'], 2, ',', '.') ?> €</div>
                <a class="detalhe" href="<?= BASE_URL ?>/veiculo/detalhe/<?= (int) $v['id'] ?>">Ver detalhe</a>
                <form action="<?= BASE_URL ?>/carrinho/adicionar" method="POST" style="display:inline-block; margin-left: 10px;">
                    <input type="hidden" name="veiculo_id" value="<?= (int) $v['id'] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <?php if (!empty($v['is_reservado']) && $v['is_reservado'] > 0): ?>
                        <button type="button" disabled style="background-color: #6c757d; color: white; border: none; padding: 7px 14px; border-radius: 4px; cursor: not-allowed; font-size:.9rem;">
                            Já Reservado
                        </button>
                    <?php else: ?>
                        <button type="submit" style="background-color: #28a745; color: white; border: none; padding: 7px 14px; border-radius: 4px; cursor: pointer; font-size:.9rem;">
                            Adicionar á reserva
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    <?php endforeach ?>
    </div>
    <?php endif ?>
</body>
</html>

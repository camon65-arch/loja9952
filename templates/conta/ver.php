<?php require dirname(__DIR__) . '/header.php'; ?>

<div style="max-width: 700px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h1>A minha conta</h1>

    <?php if ($cliente): ?>
        <table>
            <tr>
                <th>Nome</th>
                <td><?= htmlspecialchars($cliente['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($cliente['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <th>Telefone</th>
                <td><?= htmlspecialchars($cliente['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Nao foi possivel carregar os dados da conta.</p>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <a class="detalhe" href="<?= BASE_URL ?>/">Voltar ao catalogo</a>
    </p>
</div>

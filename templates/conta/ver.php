<?php require dirname(__DIR__) . '/header.php'; ?>

<div style="max-width: 900px; margin: 30px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <?php if (!empty($_SESSION['msg_ok'])): ?>
        <p style="color: green; font-weight: bold; background: #D4EDDA; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            <?= htmlspecialchars($_SESSION['msg_ok'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_ok']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color: red; font-weight: bold; background: #F8D7DA; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
            <?= htmlspecialchars($_SESSION['msg_erro'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_erro']); ?>
    <?php endif; ?>

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
        <p>Não foi possível carregar os dados da conta.</p>
    <?php endif; ?>

    <h2 style="margin-top: 40px;">As minhas reservas</h2>

    <?php if (empty($reservas)): ?>
        <p style="color: #666;">Ainda não efetuou nenhuma reserva.</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <thead>
                <tr style="background-color: #f8f9fa; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Veículo</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Ano</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6; text-align: right;">Preço</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Estado</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Data</th>
                    <th style="padding: 12px; border-bottom: 2px solid #dee2e6;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservas as $r): ?>
                    <tr>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">
                            <strong><?= htmlspecialchars($r['marca'] . ' ' . $r['modelo']) ?></strong>
                        </td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;"><?= $r['ano'] ?></td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: right;">
                            <?= number_format($r['preco'], 2, ',', '.') ?> €
                        </td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">
                            <span style="background: #d4edda; color: #155724; padding: 3px 8px; border-radius: 4px; font-size: 0.85em; font-weight: bold;">Confirmada</span>
                        </td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee; color: #666;">
                            <?= date('d/m/Y H:i', strtotime($r['criado_em'])) ?>
                        </td>
                        <td style="padding: 12px; border-bottom: 1px solid #eee;">
                            <form action="<?= BASE_URL ?>/conta/cancelar-reserva" method="POST" onsubmit="return confirm('Tem a certeza que deseja cancelar esta reserva?');">
                                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="reserva_id" value="<?= $r['id'] ?>">
                                <button type="submit" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 0.9em;">
                                    Cancelar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p style="margin-top: 20px;">
        <a class="detalhe" href="<?= BASE_URL ?>/">Voltar ao catálogo</a>
    </p>
</div>

<?php require __DIR__ . '/../header.php'; ?>

<div style="max-width: 800px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h1>A minha conta</h1>

    <?php if (!empty($_SESSION['msg_ok'])): ?>
        <p style="color: green; font-weight: bold; background: #D4EDDA; padding: 10px; border-radius: 4px;">
            <?= htmlspecialchars($_SESSION['msg_ok'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_ok']); ?>
    <?php endif; ?>

    <p style="font-size: 1.2rem;">Olá, <strong><?= htmlspecialchars($cliente['nome'] ?? 'Visitante', ENT_QUOTES, 'UTF-8') ?></strong>!</p>
    <p>O seu email de registo é: <em><?= htmlspecialchars($cliente['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></em></p>

    <h2 style="margin-top: 30px;">As tuas reservas</h2>
    <div style="background: #f0f4f8; padding: 20px; border-radius: 8px; text-align: center; color: #555;">
        <p style="font-style: italic; font-size: 1.1rem;">As tuas reservas aparecerão aqui.</p>
        <p>Ainda não tens nenhuma reserva. Explora o nosso <a href="<?= BASE_URL ?>/" style="color: #1565C0; text-decoration: none; font-weight: bold;">catálogo</a>!</p>
    </div>
</div>
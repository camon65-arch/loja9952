<?php require __DIR__ . '/../header.php'; ?>

<div style="max-width: 400px; margin: 40px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h1>Iniciar Sessão</h1>

    <?php if (!empty($_SESSION['msg_ok'])): ?>
        <p style="color: #2E7D32; font-weight: bold; background: #E8F5E9; padding: 10px; border-radius: 4px;">
            <?= htmlspecialchars($_SESSION['msg_ok'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_ok']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color: #B00020; font-weight: bold; background: #FFEBEE; padding: 10px; border-radius: 4px;">
            <?= htmlspecialchars($_SESSION['msg_erro'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_erro']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/login" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Password:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <button type="submit" style="background: #1565C0; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">
            Entrar
        </button>
    </form>
    <p style="margin-top: 20px; text-align: center;">Ainda não tem conta? <a href="<?= BASE_URL ?>/registar">Registe-se aqui</a>.</p>
</div>
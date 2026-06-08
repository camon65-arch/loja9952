<?php require __DIR__ . '/../header.php'; ?>

<div style="max-width: 400px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
    <h1>Criar Conta</h1>

    <?php if (!empty($_SESSION['msg_erro'])): ?>
        <p style="color: #B00020; font-weight: bold; background: #FFEBEE; padding: 10px; border-radius: 4px;">
            <?= htmlspecialchars($_SESSION['msg_erro'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <?php unset($_SESSION['msg_erro']); ?>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/registar" method="POST">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        
        <div style="margin-bottom: 10px;">
            <label>Nome Completo:</label><br>
            <input type="text" name="nome" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Email:</label><br>
            <input type="email" name="email" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label>Telefone (opcional):</label><br>
            <input type="text" name="telefone" style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Password:</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <div style="margin-bottom: 15px;">
            <label>Confirmar Password:</label><br>
            <input type="password" name="password2" required style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
        </div>
        
        <button type="submit" style="background: #1565C0; color: #fff; border: none; padding: 10px 20px; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">
            Adicionar á reserva
        </button>
    </form>

    <p style="margin-top: 20px; text-align: center;">
        Já tem uma conta? <a href="<?= BASE_URL ?>/login">Inicie sessão aqui</a>.
    </p>
</div>
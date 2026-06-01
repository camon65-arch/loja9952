<?php // templates/header.php
if(session_status()===PHP_SESSION_NONE) session_start();
$total_carrinho = count($_SESSION['carrinho'] ?? []);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titulo ?? 'AutoShop', ENT_QUOTES, 'UTF-8') ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width:1100px; margin:0 auto; padding:20px; color: #333; }
        header { background:#1A237E; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; align-items:center; border-radius: 8px; margin-bottom: 20px; }
        .filtros { background:#f0f4f8; padding:16px; border-radius:8px; margin-bottom:24px; display:flex; gap:12px; flex-wrap:wrap; }
        .filtros input, .filtros select { padding:8px; border:1px solid #ccc; border-radius:4px; }
        .filtros button { background:#1565C0; color:#fff; padding:8px 18px; border:none; border-radius:4px; cursor:pointer; }
        .grelha { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:20px; }
        .card { border:1px solid #ddd; border-radius:8px; overflow:hidden; transition:box-shadow .2s; }
        .card:hover { box-shadow:0 4px 16px rgba(0,0,0,.12); }
        .card img { width:100%; height:180px; object-fit:cover; background:#eee; }
        .card-body { padding:14px; }
        .card-body h3 { margin:0 0 6px; font-size:1rem; color:#1A237E; }
        .preco { font-size:1.3rem; font-weight:bold; color:#1565C0; }
        .detalhe { display:inline-block; margin-top:10px; background:#1565C0; color:#fff; padding:7px 14px; border-radius:4px; text-decoration:none; font-size:.9rem; }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        th, td { border-bottom:1px solid #ddd; padding:10px; text-align:left; }
        th { background:#f0f4f8; }
    </style>
</head>
<body>
<header>
    <a href="<?= BASE_URL ?>/" style="color:#fff;font-size:1.3rem;font-weight:bold;text-decoration:none;">🚗 AutoShop</a>
    <nav style="display:flex;gap:20px;align-items:center;">
        <a href="<?= BASE_URL ?>/" style="color:#fff;text-decoration:none;">Catálogo</a>
        <a href="<?= BASE_URL ?>/carrinho" style="color:#fff;text-decoration:none;">
            🛒 Lista (<?= $total_carrinho ?>)
        </a>
        <?php if($_SESSION['logado'] ?? false): ?>
            <a href="<?= BASE_URL ?>/conta" style="color:#fff;text-decoration:none;">A minha conta</a>
            <a href="<?= BASE_URL ?>/logout" style="color:#ccc;text-decoration:none;">Sair</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/login" style="color:#fff;text-decoration:none;">Entrar</a>
        <?php endif ?>
    </nav>
</header>

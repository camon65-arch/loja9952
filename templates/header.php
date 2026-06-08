<?php // templates/header.php
if(session_status()===PHP_SESSION_NONE) session_start();
$total_carrinho = count($_SESSION['carrinho'] ?? []);

function veiculo_imagens(array $veiculo): array {
    $imagens = [];
    $uploadsDir = dirname(__DIR__) . '/uploads/';

    if (!empty($veiculo['imagem'])) {
        $principal = (string) $veiculo['imagem'];
        if (is_file($uploadsDir . $principal)) {
            $imagens[] = $principal;
        }

        $info = pathinfo($principal);
        $interior = ($info['filename'] ?? '') . '-interior.' . ($info['extension'] ?? 'jpg');
        if (is_file($uploadsDir . $interior)) {
            $imagens[] = $interior;
        }
    }

    return array_values(array_unique($imagens));
}

function render_carrossel_veiculo(array $veiculo, string $classe = ''): void {
    $imagens = veiculo_imagens($veiculo);
    if (empty($imagens)) {
        return;
    }

    $nome = htmlspecialchars(($veiculo['marca'] ?? '').' '.($veiculo['modelo'] ?? ''), ENT_QUOTES, 'UTF-8');
    $classeExtra = $classe !== '' ? ' ' . htmlspecialchars($classe, ENT_QUOTES, 'UTF-8') : '';
    ?>
    <div class="carrossel<?= $classeExtra ?>" data-carousel>
        <div class="carrossel-slides">
            <?php foreach ($imagens as $i => $imagem): ?>
            <img class="carrossel-slide <?= $i === 0 ? 'ativo' : '' ?>"
                 src="<?= BASE_URL ?>/uploads/<?= htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') ?>"
                 alt="<?= $nome ?><?= $i === 0 ? '' : ' interior' ?>"
                 data-slide="<?= $i ?>">
            <?php endforeach ?>
        </div>
        <?php if (count($imagens) > 1): ?>
        <button class="carrossel-btn carrossel-prev" type="button" aria-label="Imagem anterior" data-carousel-prev>&lsaquo;</button>
        <button class="carrossel-btn carrossel-next" type="button" aria-label="Imagem seguinte" data-carousel-next>&rsaquo;</button>
        <div class="carrossel-pontos" aria-label="Imagens do veiculo">
            <?php foreach ($imagens as $i => $_): ?>
            <button class="carrossel-ponto <?= $i === 0 ? 'ativo' : '' ?>" type="button" aria-label="Ver imagem <?= $i + 1 ?>" data-carousel-dot="<?= $i ?>"></button>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </div>
    <?php
}
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
        .img-carrinho { width:120px; height:78px; object-fit:cover; border-radius:6px; display:block; background:#eee; }
        .carrossel { position:relative; overflow:hidden; background:#eee; }
        .carrossel-slides { position:relative; width:100%; height:100%; }
        .carrossel-slide { display:none; width:100%; height:100%; object-fit:cover; background:#eee; }
        .carrossel-slide.ativo { display:block; }
        .carrossel--card { height:180px; }
        .carrossel--detalhe { width:100%; max-width:600px; aspect-ratio:4/3; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
        .carrossel--carrinho { width:120px; height:78px; border-radius:6px; }
        .carrossel-btn { position:absolute; top:50%; transform:translateY(-50%); width:30px; height:30px; border:0; border-radius:50%; background:rgba(0,0,0,.55); color:#fff; font-size:1.5rem; line-height:1; cursor:pointer; display:flex; align-items:center; justify-content:center; }
        .carrossel-prev { left:8px; }
        .carrossel-next { right:8px; }
        .carrossel-pontos { position:absolute; left:0; right:0; bottom:8px; display:flex; gap:6px; justify-content:center; }
        .carrossel-ponto { width:8px; height:8px; padding:0; border:0; border-radius:50%; background:rgba(255,255,255,.65); cursor:pointer; }
        .carrossel-ponto.ativo { background:#fff; }
        .carrossel--carrinho .carrossel-btn { width:20px; height:20px; font-size:1rem; }
        .carrossel--carrinho .carrossel-prev { left:4px; }
        .carrossel--carrinho .carrossel-next { right:4px; }
        .carrossel--carrinho .carrossel-pontos { display:none; }
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
            <a href="<?= BASE_URL ?>/registar" style="color:#fff;text-decoration:none;">Criar cliente</a>
        <?php endif ?>
    </nav>
</header>
<script>
document.addEventListener('click', function (event) {
    var control = event.target.closest('[data-carousel-prev], [data-carousel-next], [data-carousel-dot]');
    if (!control) return;

    var carousel = control.closest('[data-carousel]');
    var slides = Array.prototype.slice.call(carousel.querySelectorAll('.carrossel-slide'));
    var dots = Array.prototype.slice.call(carousel.querySelectorAll('.carrossel-ponto'));
    var active = slides.findIndex(function (slide) { return slide.classList.contains('ativo'); });
    var next = active;

    if (control.hasAttribute('data-carousel-prev')) {
        next = (active - 1 + slides.length) % slides.length;
    } else if (control.hasAttribute('data-carousel-next')) {
        next = (active + 1) % slides.length;
    } else {
        next = parseInt(control.getAttribute('data-carousel-dot'), 10);
    }

    slides.forEach(function (slide, index) {
        slide.classList.toggle('ativo', index === next);
    });
    dots.forEach(function (dot, index) {
        dot.classList.toggle('ativo', index === next);
    });
});
</script>

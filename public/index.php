<?php

declare(strict_types=1);

$autoload = dirname(__DIR__) . '/vendor/autoload.php';
$loggerActivo = false;

if (is_file($autoload)) {
    require $autoload;

    if (class_exists(\App\FileLogger::class)) {
        $logger = new \App\FileLogger(dirname(__DIR__) . '/storage/app.log');
        $logger->info('Pagina principal consultada');
        $loggerActivo = true;
    }
}

$productos = [
    ['codigo' => 'P-001', 'nombre' => 'Teclado', 'stock' => 15],
    ['codigo' => 'P-002', 'nombre' => 'Mouse', 'stock' => 22],
    ['codigo' => 'P-003', 'nombre' => 'Monitor', 'stock' => 7],
    ['codigo' => 'P-004', 'nombre' => 'Cable HDMI', 'stock' => 31],
];

$busqueda = trim((string) ($_GET['q'] ?? ''));

$resultados = array_filter($productos, static function (array $producto) use ($busqueda): bool {
    if ($busqueda === '') {
        return true;
    }

    return stripos($producto['codigo'] . ' ' . $producto['nombre'], $busqueda) !== false;
});

function h(string $valor): string
{
    return htmlspecialchars($valor, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catálogo interno</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<main class="contenedor">
    <header>
        <span class="etiqueta">PROYECTO PHP DE PRÁCTICA</span>
        <h1>Catálogo interno</h1>
        <p>Mini aplicación para simular la integración de Composer Audit en un proyecto existente.</p>
    </header>

    <section class="tarjeta">
        <form method="get">
            <label for="q">Buscar producto</label>
            <div class="buscador">
                <input id="q" name="q" value="<?= h($busqueda) ?>" placeholder="Ejemplo: monitor">
                <button type="submit">Buscar</button>
                <a href="index.php">Limpiar</a>
            </div>
        </form>

        <table>
            <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Stock</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($resultados as $producto): ?>
                <tr>
                    <td><?= h($producto['codigo']) ?></td>
                    <td><?= h($producto['nombre']) ?></td>
                    <td><?= (int) $producto['stock'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>

    <section class="estado">
        <strong>Composer:</strong>
        <?= $loggerActivo
            ? 'dependencias instaladas; PSR-3 Logger activo.'
            : 'el proyecto funciona, pero ejecuta composer install para activar PSR-3 Logger.' ?>
    </section>
</main>
</body>
</html>

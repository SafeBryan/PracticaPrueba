<?php
session_start();
require_once 'usuarioc.php';
require_once 'reportec.php';

$usuario = new Usuario();
$reporte = new Reporte();

if (!$usuario->isLoggedIn() || !$_SESSION['es_admin']) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    $usuario->logout();
    header('Location: index.php');
    exit();
}

$reportePregunta1 = $reporte->reportePregunta1();
$reportePregunta2 = $reporte->reportePregunta2();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reportes Administrativos</title>
</head>
<body>
    <h2>Reportes Administrativos</h2>
    
    <h3>Pregunta 1: ¿Sabes programación orientada a objetos?</h3>
    <ul>
        <?php foreach ($reportePregunta1 as $reporte): ?>
            <li><?php echo $reporte['pregunta1_respuesta'] . ": " . $reporte['total']; ?></li>
        <?php endforeach; ?>
    </ul>
    
    <h3>Pregunta 2: ¿Sabes PHP?</h3>
    <ul>
        <?php foreach ($reportePregunta2 as $reporte): ?>
            <li><?php echo $reporte['pregunta2_respuesta'] . ": " . $reporte['total']; ?></li>
        <?php endforeach; ?>
    </ul>

    <form method="POST">
        <button type="submit" name="logout">Cancelar</button>
    </form>
</body>
</html>

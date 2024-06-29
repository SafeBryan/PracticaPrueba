<?php
session_start();
require_once 'usuarioc.php';
require_once 'encuestac.php';

$usuario = new Usuario();
$encuesta = new Encuesta();

if (!$usuario->isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre'];
$apellido = $_SESSION['apellido'];
$es_admin = $_SESSION['es_admin'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['logout'])) {
        $usuario->logout();
        header('Location: index.php');
        exit();
    }

    if (isset($_POST['submit_encuesta']) && !$es_admin) {
        $respuesta1 = $_POST['pregunta1'];
        $respuesta2 = $_POST['pregunta2'];
        
        if (!$encuesta->existeEncuestaUsuario($usuario_id)) {
            $encuesta->guardarEncuesta($usuario_id, $respuesta1, $respuesta2);
            $mensaje = "Encuesta guardada exitosamente.";
        } else {
            $mensaje = "Ya has completado la encuesta.";
        }
    }
}

$encuesta_usuario = $encuesta->existeEncuestaUsuario($usuario_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Encuesta</title>
</head>
<body>
    <h2>Encuesta</h2>
    <p>Nombre: <?php echo $nombre; ?></p>
    <p>Apellido: <?php echo $apellido; ?></p>

    <?php if ($es_admin): ?>
        <p>Bienvenido administrador, solo puedes acceder a los reportes.</p>
        <button type="button" onclick="window.location.href='reportes.php'">Ver Reportes</button>
    <?php else: ?>
        <?php if ($encuesta_usuario): ?>
            <p>Ya has completado la encuesta. Estas son tus respuestas:</p>
            <p>Pregunta 1: <?php echo $encuesta_usuario['pregunta1_respuesta']; ?></p>
            <p>Pregunta 2: <?php echo $encuesta_usuario['pregunta2_respuesta']; ?></p>
        <?php else: ?>
            <form method="POST">
                <label>Pregunta 1: ¿Sabes programación orientada a objetos?</label><br>
                <input type="radio" name="pregunta1" value="SI" required> Sí<br>
                <input type="radio" name="pregunta1" value="NO" required> No<br>
                
                <label>Pregunta 2: ¿Sabes PHP?</label><br>
                <input type="radio" name="pregunta2" value="SI" required> Sí<br>
                <input type="radio" name="pregunta2" value="NO" required> No<br>
                
                <button type="submit" name="submit_encuesta">Enviar Encuesta</button>
            </form>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST">
        <button type="submit" name="logout">Cancelar</button>
    </form>
    <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>
</body>
</html>

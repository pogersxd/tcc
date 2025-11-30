<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['usuario'])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" class="rel">
    <title>Meu Perfil</title>
</head>

<body>
    <h1>Meu perfil</h1>
    <h3>Foto de perfil:</h3>
    <img src="./assets/pfps/<?= $_SESSION['usuario']['foto'] ?>" width=100px height=100px alt="Imagem do seu perfil">
    <h3>Nome: </h3>
    <?= $_SESSION['usuario']['nome'] ?>
    <h3>Bio: </h3>
    <?= $_SESSION['usuario']['bio'] ?>

</body>

</html>
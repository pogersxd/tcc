<?php
session_start();
if (!isset($_SESSION['usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM - Usuários</title>
</head>

<body>
    <a href="./adm.php">Retornar à página anterior</a>
    <h2>Usuários</h2>
    <?php
    require_once __DIR__ . "/../conect.php";
    $id_adm = $_SESSION['usuario']['id_usuario'];
    $usuariosQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario != $id_adm");
    while ($usuario = mysqli_fetch_assoc($usuariosQuery)) {
        echo <<<HTML
        <form action="alterarUsuario.php" method="post" enctype="multipart/form-data" style="
        display: flex;
        flex-direction: row;
        margin-bottom: 10px;
        gap: 5px
        ">
            <input type="hidden" name="id_usuario" value="{$usuario['id_usuario']}">
            <input type="hidden" name="foto_atual" value="{$usuario['foto']}">
            <label>Nome: <input type="text" name="nome" value="{$usuario['nome']}"> </label>
            <label style="display: flex">Bio: <textarea name="bio">{$usuario['bio']}</textarea> </label>
            <label>Nova foto(opcional): <input type="file" name="foto"> </label>
            <input type="submit" value="Alterar">
            <a href="./deletarUsuario.php">Deletar</a>
        </form>
        HTML;
    }
    ?>
</body>

</html>
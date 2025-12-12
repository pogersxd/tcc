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
    echo "<h3>Se quiser alterar seu próprio perfil, faça pelo menu normal do site.</h3>";
    if (mysqli_num_rows($usuariosQuery) > 0) {
        echo <<<HTML
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Bio</th>
                    <th>Foto Atual</th>
                    <th>Nova Foto(opcional)</th>
                    <th>Operações</th>
                </tr>
        HTML;
        while ($usuario = mysqli_fetch_assoc($usuariosQuery)) {
            echo <<<HTML
            <form action="alterarUsuario.php" method="post" enctype="multipart/form-data" style="
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            gap: 5px
            ">
            <tr>
                <td>{$usuario['id_usuario']}</td>
                <input type="hidden" name="id_usuario" value="{$usuario['id_usuario']}">
                <input type="hidden" name="foto_atual" value="{$usuario['foto']}">
                <td><input type="text" name="nome" value="{$usuario['nome']}"></td>
                <td><textarea name="bio" rows="5">{$usuario['bio']}</textarea></td>
                <td><img src="../assets/pfps/{$usuario['foto']}" height="75px" alt="Foto do usuário {$usuario['nome']}"></td>
                <td><input type="file" name="foto"></td>
                <td>
                    <input type="submit" value="Alterar">
                    <a href="./deletarUsuarioConfirmar.php?id_usuario={$usuario['id_usuario']}">Deletar</a>
                </td>
            </tr>
            </form>
            HTML;
        }
        echo "</table>";
    }
    ?>
</body>

</html>
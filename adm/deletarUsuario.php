<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
if (!isset($_SESSION['usuario']) || !isset($_GET['id_usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_usuario = $_GET['id_usuario'];
if (registroExiste($conexao, 'usuario', 'id_usuario', $id_usuario)) {
    if (registroExiste($conexao, 'album', 'id_usuario', $id_usuario) || registroExiste($conexao, 'playlist', 'id_usuario', $id_usuario)) {
        echo "O usuário possui álbuns, músicas ou playlists e não pode ser excluído ainda.";
    } else {
        $sql = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
        $usuario = mysqli_fetch_assoc($sql);
        $foto = $usuario['foto'];
        if ($foto != "padrao.jpg") $deletou = unlink(__DIR__ . "/../assets/pfps/" . $foto);
        else $deletou = false;
        if ($deletou || $foto == "padrao.jpg") {
            mysqli_query($conexao, "DELETE FROM curtido WHERE id_usuario = '$id_usuario'");
            mysqli_query($conexao, "DELETE FROM usuario WHERE id_usuario = '$id_usuario'");
            echo "O usuário foi excluído com sucesso.";
            header("Location: ./usuarios.php");
        } else {
            echo "Ocorreu um erro na exclusão do usuário.";
        }
    }
} else {
    echo "O usuário não existe mais.";
}
?>
<br><a href="./usuarios.php">Retornar a tela de usuários</a>
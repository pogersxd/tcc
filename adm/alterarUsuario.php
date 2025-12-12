<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
$nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
if (!isset($_SESSION['usuario']) || !isset($_POST['id_usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$id_usuario = $_POST['id_usuario'];
$bio = mysqli_real_escape_string($conexao, $_POST["bio"]);
if (registroExiste($conexao, 'usuario', 'id_usuario', $id_usuario)) {
    if ($_FILES['foto']['size'] <= 1024 * 1024 * 10) {
        $tipoCorreto = false;
        $tipoAlternativo = false;
        if (!empty($_FILES['foto']['name'])) {
            $pasta = __DIR__ . "/../assets/pfps/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }
            $nomeArquivo = md5(time());
            $nomeCompleto = $_FILES["foto"]["name"];
            $nomeSeparado = explode('.', $nomeCompleto);
            $extensao = $nomeSeparado[count($nomeSeparado) - 1];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);
            $tiposPermitidos = [
                'image/jpeg',  // JPG, JPEG
                'image/png',   // PNG
                'image/gif',   // GIF
                'image/webp',  // WEBP (moderno)
            ];
            $extensoesPermitidas = [
                'jpg',
                'jpeg',
                'png',
                'gif',
                'webp'
            ];
            $extensaoCorreta = (in_array($extensao, $extensoesPermitidas));
            $tipoCorreto = (in_array($tipo, $tiposPermitidos) && $extensaoCorreta);
            $tipoAlternativo = ($tipo === 'application/octet-stream' && $extensaoCorreta);
            $nomeArquivoExtensao = $nomeArquivo . '.' . $extensao;
        } else {
            $nomeArquivoExtensao = $_POST['foto_atual'];
        }
        if ($tipoCorreto || $tipoAlternativo || empty($_FILES['foto']['name'])) {
            if (!empty($_FILES['foto']['name'])) {
                $antigoArquivoQuery = mysqli_query($conexao, "SELECT foto FROM usuario WHERE id_usuario = '$id_usuario'");
                $antigoArquivo = mysqli_fetch_assoc($antigoArquivoQuery)['foto'];
                $feitoUpload = move_uploaded_file($_FILES['foto']['tmp_name'], $pasta . $nomeArquivoExtensao);
                if ($feitoUpload) {
                    if ($antigoArquivo != "padrao.jpg")
                        unlink($pasta . $antigoArquivo);
                }
            } else {
                $feitoUpload = false;
            }
            if ($feitoUpload || empty($_FILES['foto']['name'])) {
                mysqli_query($conexao, "UPDATE usuario SET nome = '$nome', foto  = '$nomeArquivoExtensao', bio = '$bio' WHERE id_usuario = '$id_usuario'");
                header("Location: ./usuarios.php");
            }
        } else {
            echo "Formato de arquivo inválido (apenas imagens não .jfif)";
        }
    } else {
        echo "Arquivo muito grande (máx 10MB)";
    }
} else {
    echo "O usuário não existe mais";
}
?>
<br><a href="./usuarios.php">Retornar a tela de usuários</a>
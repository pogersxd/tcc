<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
$response = [];
if (!isset($_SESSION['usuario']) || (isset($_SESSION['usuario']) && $_SESSION['usuario']['adm'] == 0)) {
    header("Location: ../index.php");
    exit();
}
$titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
$id_album = $_POST['id_album'];
if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
    if ($_FILES['capa']['size'] <= 1024 * 1024 * 10) {
        $tipoCorreto = false;
        $tipoAlternativo = false;
        if (!empty($_FILES['capa']['name'])) {
            $pasta = __DIR__ . "/../assets/albumCovers/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }
            $nomeArquivo = md5(time());
            $nomeCompleto = $_FILES["capa"]["name"];
            $nomeSeparado = explode('.', $nomeCompleto);
            $extensao = $nomeSeparado[count($nomeSeparado) - 1];
            $tipo = mime_content_type($_FILES['capa']['tmp_name']);
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
            $nomeArquivoExtensao = $_POST['capa_atual'];
        }
        if ($tipoCorreto || $tipoAlternativo || empty($_FILES['capa']['name'])) {
            if (!empty($_FILES['capa']['name'])) {
                $feitoUpload = move_uploaded_file($_FILES['capa']['tmp_name'], $pasta . $nomeArquivoExtensao);
                $antigoArquivoQuery = mysqli_query($conexao, "SELECT capa FROM album WHERE id_album = '$id_album'");
                $antigoArquivo = mysqli_fetch_assoc($antigoArquivoQuery)['capa'];
                $feitoUpload = move_uploaded_file($_FILES['capa']['tmp_name'], $pasta . $nomeArquivoExtensao);
                if ($feitoUpload) {
                    unlink($pasta . $antigoArquivo);
                }
            } else {
                $feitoUpload = false;
            }
            if ($feitoUpload || empty($_FILES['capa']['name'])) {
                mysqli_query($conexao, "UPDATE album SET titulo = '$titulo', capa  = '$nomeArquivoExtensao' WHERE id_album = '$id_album'");
                header("Location: ./albuns.php");
            }
        } else {
            echo "Formato de arquivo inválido.";
        }
    } else {
        echo "Arquivo muito grande (máx 10MB)";
    }
} else {
    echo "O álbum não existe mais";
}
?>
<br><a href="./albuns.php">Retornar à página de álbuns</a>
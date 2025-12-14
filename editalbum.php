<?php
header("Content-Type: application/json; charset=utf-8");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";
$response = [];
if (!isset($_SESSION['usuario']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Sessão expirada ou acesso inválido",
        "nextComponent" => "loginForm"
    ]);
    exit;
} else {
    $titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
    $id_album = $_POST['id_album'];
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if ($_FILES['capa']['size'] <= 1024 * 1024 * 10) {
            $tipoCorreto = false;
            $tipoAlternativo = false;
            if (!empty($_FILES['capa']['name'])) {
                $pasta = __DIR__ . "/assets/albumCovers/";

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
                    if ($feitoUpload) {
                        unlink($pasta . $antigoArquivo);
                    }
                } else {
                    $feitoUpload = false;
                }
                if ($feitoUpload || empty($_FILES['capa']['name'])) {
                    mysqli_query($conexao, "UPDATE album SET titulo = '$titulo', capa  = '$nomeArquivoExtensao' WHERE id_album = '$id_album'");
                    $response["status"] = "success";
                    $response["message"] = "Álbum alterado com sucesso!";
                    $response["nextComponent"] = "editAlbum";
                    echo "vou dar a bunda merda";
                } else {
                    $response["status"] = "error";
                    $response["message"] = "Erro ao alterar o álbum.";
                    $response["nextComponent"] = "editAlbum";
                }
            } else {
                $response["status"] = "error";
                $response["message"] = "Formato de arquivo inválido (apenas arquivo de imagem)";
                $response["nextComponent"] = "editAlbum";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Arquivo muito grande (máx 10MB)";
            $response["nextComponent"] = "editAlbum";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "O álbum não existe mais";
        $response["nextComponent"] = "editAlbum";
    }
}
echo json_encode($response);

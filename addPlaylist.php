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
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    if (!registroExiste($conexao, 'playlist', 'titulo', $titulo)) {
        if ($_FILES['capa']['size'] <= 1024 * 1024 * 10) {
            $pasta = __DIR__ . "/assets/playlistCovers/";

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
            if ($tipoCorreto || $tipoAlternativo) {
                $nomeArquivoExtensao = $nomeArquivo . '.' . $extensao;
                $feitoUpload = move_uploaded_file($_FILES['capa']['tmp_name'], $pasta . $nomeArquivoExtensao);
                if ($feitoUpload) {
                    mysqli_query($conexao, "INSERT INTO playlist (titulo, capa, id_usuario) VALUES ('$titulo','$nomeArquivoExtensao',$id_usuario)");
                    $tabelaPlaylist = mysqli_query($conexao, "SELECT id_playlist FROM playlist WHERE capa='$nomeArquivoExtensao'");
                    $response["status"] = "success";
                    $response["message"] = "Playlist cadastrada!";
                    $response["nextComponent"] = "editPlaylist";
                }
            } else {
                $response["status"] = "error";
                $response["message"] = "Formato de arquivo inválido (apenas arquivo de imagem)";
                $response["nextComponent"] = "addPlaylistForm";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Arquivo muito grande (máx 10MB)";
            $response["nextComponent"] = "addPlaylistForm";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Já existe uma playlist com esse nome";
        $response["nextComponent"] = "addPlaylistForm";
    }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;

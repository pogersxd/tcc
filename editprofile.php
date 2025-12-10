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
    $nome = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $bio = mysqli_real_escape_string($conexao, $_POST["bio"]);
    $id_usuario = $_POST['id_usuario'];
    if (registroExiste($conexao, 'usuario', 'id_usuario', $id_usuario)) {
        if ($_FILES['foto']['size'] <= 1024 * 1024 * 10) {
            $tipoCorreto = false;
            $tipoAlternativo = false;
            if (!empty($_FILES['foto']['name'])) {
                $pasta = __DIR__ . "/assets/pfps/";

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
                        unlink($pasta . $antigoArquivo);
                    }
                } else {
                    $feitoUpload = false;
                }
                if ($feitoUpload || empty($_FILES['foto']['name'])) {
                    mysqli_query($conexao, "UPDATE usuario SET nome = '$nome', foto  = '$nomeArquivoExtensao', bio = '$bio' WHERE id_usuario = '$id_usuario'");
                    $_SESSION['usuario']['nome'] = $nome;
                    $_SESSION['usuario']['foto'] = $nomeArquivoExtensao;
                    $_SESSION['usuario']['bio'] = $bio;
                    $response["status"] = "success";
                    $response["message"] = "Perfil alterado com sucesso!";
                    $response["nextComponent"] = "profile";
                }
            } else {
                $response["status"] = "error";
                $response["message"] = "Formato de arquivo inválido (apenas arquivo de imagem)";
                $response["nextComponent"] = "profile";
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Arquivo muito grande (máx 10MB)";
            $response["nextComponent"] = "profile";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Ocorreu um erro";
        $response["nextComponent"] = "profile";
    }
}
echo json_encode($response, JSON_UNESCAPED_UNICODE);
exit;

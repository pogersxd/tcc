<?php
header("Content-Type: application/json");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/getID3/getid3/getid3.php";
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/functions.php";
$response = [];

$titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
$detalhes = mysqli_real_escape_string($conexao, $_POST['detalhes']);
$id_musica = $_POST["id_musica"];
$id_albumQuery = mysqli_query($conexao, "SELECT id_album FROM musica WHERE id_musica = '$id_musica'");
$id_album = mysqli_fetch_assoc($id_albumQuery)['id_album'];
if (isset($_SESSION['usuario'])) {
    if (registroExiste($conexao, 'musica', 'id_musica', $id_musica)) {
        if ($_FILES['arquivo']['size'] <= 1024 * 1024 * 20) {
            $tipoCorreto = false;
            $tipoAlternativo = false;
            if (!empty($_FILES['arquivo']['name'])) {
                $pasta = __DIR__ . "/assets/songs/";
                if (!is_dir($pasta)) {
                    mkdir($pasta, 0777, true);
                }
                $nomeArquivo = md5(time());
                $nomeCompleto = $_FILES["arquivo"]["name"];
                $nomeSeparado = explode('.', $nomeCompleto);
                $extensao = $nomeSeparado[count($nomeSeparado) - 1];
                $tipo = mime_content_type($_FILES['arquivo']['tmp_name']);
                $tiposPermitidos = [
                    'audio/mpeg',    // mp3
                    'audio/wav',     // wav
                    'audio/ogg',     // ogg
                    'audio/x-wav',
                    'audio/x-m4a',
                    'audio/mp4'
                ];
                $extensoesPermitidas = [
                    'mp3',
                    'mpeg',
                    'wav',
                    'ogg',
                    'opus',
                    'm4a'
                ];
                $extensaoCorreta = (in_array($extensao, $extensoesPermitidas));
                $tipoCorreto = (in_array($tipo, $tiposPermitidos) && $extensaoCorreta);
                $tipoAlternativo = ($tipo === 'application/octet-stream' && $extensaoCorreta);
            } else {
                $nomeArquivoExtensao = $_POST['arquivo_atual'];
            }
            if ($tipoCorreto || $tipoAlternativo || empty($_FILES['arquivo']['name'])) {
                if (!empty($_FILES['arquivo']['name'])) {
                    $nomeArquivoExtensao = $nomeArquivo . '.' . $extensao;
                    $antigoArquivoQuery = mysqli_query($conexao, "SELECT arquivo FROM musica WHERE id_musica = '$id_musica'");
                    $antigoArquivo = mysqli_fetch_assoc($antigoArquivoQuery)['arquivo'];
                    $feitoUpload = move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . $nomeArquivoExtensao);
                    if ($feitoUpload) {
                        unlink($pasta . $antigoArquivo);
                    }
                } else {
                    $feitoUpload = false;
                }
                if ($feitoUpload || empty($_FILES['arquivo']['name'])) {
                    if (!empty($_FILES['arquivo']['name'])) {
                        $getID3 = new getID3;
                        $infoID3 = $getID3->analyze("./assets/songs/{$nomeArquivoExtensao}");
                        $duracaoSegundos = $infoID3['playtime_seconds'];
                    } else {
                        $duracaoSegundosQuery = mysqli_query($conexao, "SELECT duracao FROM musica WHERE id_musica = '$id_musica'");
                        $duracaoSegundos = mysqli_fetch_assoc($duracaoSegundosQuery)['duracao'];
                    }
                    mysqli_query($conexao, "UPDATE musica SET titulo = '$titulo', detalhes = '$detalhes', duracao = '$duracaoSegundos', arquivo = '$nomeArquivoExtensao' WHERE id_musica = '$id_musica'");
                    $response["status"] = "success";
                    $response["message"] = "Música alterada com sucesso!";
                    $response["nextComponent"] = "addMusicForm";
                    $response["id"] = $id_album;
                }
            } else {
                $response["status"] = "error";
                $response["message"] = "Formato de arquivo inválido (apenas arquivos de áudio)";
                $response["nextComponent"] = "addMusicForm";
                $response["id"] = $id_album;
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Arquivo muito grande (máx 10MB)";
            $response["nextComponent"] = "addMusicForm";
            $response["id"] = $id_album;
        }
    } else {

        $response["status"] = "error";
        $response["message"] = "A música não existe";
        $response["nextComponent"] = "addMusicForm";
        $response["id"] = $id_album;
    }
}

echo json_encode($response);

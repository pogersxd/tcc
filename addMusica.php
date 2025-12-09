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
$id_album = $_POST["id_album"];
if (isset($_SESSION['usuario'])) {
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if ($_FILES['arquivo']['size'] <= 1024 * 1024 * 20) {
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
                'wav',
                'ogg',
                'm4a'
            ];
            $extensaoCorreta = (in_array($extensao, $extensoesPermitidas));
            $tipoCorreto = (in_array($tipo, $tiposPermitidos) && $extensaoCorreta);
            $tipoAlternativo = ($tipo === 'application/octet-stream' && $extensaoCorreta);
            if ($tipoCorreto || $tipoAlternativo) {
                $nomeArquivoExtensao = $nomeArquivo . '.' . $extensao;
                $feitoUpload = move_uploaded_file($_FILES['arquivo']['tmp_name'], $pasta . $nomeArquivoExtensao);
                if ($feitoUpload) {
                    $getID3 = new getID3;
                    $infoID3 = $getID3->analyze("./assets/songs/{$nomeArquivoExtensao}");
                    $duracaoSegundos = $infoID3['playtime_seconds'];
                    mysqli_query($conexao, "INSERT INTO musica (titulo, duracao, arquivo, detalhes, id_album) values ('$titulo', $duracaoSegundos, '$nomeArquivoExtensao', '$detalhes', $id_album)");
                    $response["status"] = "success";
                    $response["message"] = "Música enviada com sucesso!";
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
        $response["message"] = "O álbum não existe";
        $response["nextComponent"] = "addMusicForm";
        $response["id"] = $id_album;
    }
}

echo json_encode($response);

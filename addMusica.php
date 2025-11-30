<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once "./getID3/getid3/getid3.php";
include_once "conect.php";
include_once "functions.php";
if (!isset($_SESSION['usuario']) or !$_POST) {
    echo "Erro na sessão";
    echo "<a href='index.php'>Voltar à página inicial</a>";
} else {
    $titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
    $detalhes = mysqli_real_escape_string($conexao, $_POST['detalhes']);
    $id_album = $_POST["id_album"];
    if (registroExiste($conexao, 'album', 'id_album', $id_album)) {
        if ($_FILES['arquivo']['size'] <= 1024 * 1024 * 10) {
            $pasta = "./assets/songs/";
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
                    header("Location: addMusicForm.php?id_album={$id_album}");
                }
            } else header("Location: addMusicForm.php?id_album={$id_album}&erro=0");
        } else header("Location: addMusicForm.php?id_album={$id_album}&erro=1");
    } else header("Location: addMusicForm.php?id_album={$id_album}&erro=2");
}

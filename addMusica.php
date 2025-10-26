<?php
session_start();
include_once "./getID3/getid3/getid3.php";
include_once "conect.php";
if (!isset($_SESSION['usuario']) or !$_POST) header("Location: index.php");
$titulo = $_POST["titulo"];
$detalhes = $_POST['detalhes'];
$id_album = $_POST["id_album"];
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
    } else echo "Arquivo tem um formato inválido.";
} else echo "Arquivo muito grande.";
echo "<br><a href='./addMusicForm.php?id_album={$id_album}'></a>";
// $extensao = $nomeSeparado[$ultimaPosicao];

// $nomeArquivoExtensao = $nomeArquivo . "." . $extensao;

// $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
// if (!$check) {
//     echo "Este arquivo não é uma imagem!";
// }

// if ($_FILES["arquivo"]['size'] > 1024 * 1024) {
//     echo "O arquivo é muito grande!";
// }
// if (
//     $extensao != "jpg" &&
//     $extensao != "png" &&
//     $extensao != "jpeg" &&
//     $extensao != "gif"
// ) {
//     echo "A extensão do arquivo é inválida!";
// }
// $feitoUpload = move_uploaded_file($_FILES["arquivo"]["tmp_name"], $pasta . $nomeArquivoExtensao);

// if ($feitoUpload) {
//     require_once "conexao.php";
//     $conexao = conectar();
//     $sql = "INSERT INTO arquivo (nome, caminho) VALUES ('$nome', '$nomeArquivoExtensao')";
//     executarSQL($conexao, $sql);
// }
// header("Location: listar_arquivos.php");

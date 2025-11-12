<?php
session_start();
include_once "conect.php";
include_once "functions.php";
if (!isset($_SESSION['usuario']) or !$_POST) {
    echo "Erro na sessão";
    echo "<a href='index.php'>Voltar à página inicial</a>";
} else {
    $titulo = mysqli_real_escape_string($conexao, $_POST["titulo"]);
    $id_usuario = $_SESSION['usuario']['id_usuario'];
    if (!registroExiste($conexao, 'album', 'titulo', $titulo)) {
        if ($_FILES['capa']['size'] <= 1024 * 1024 * 10) {
            $pasta = "./assets/albumCovers/";
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
                    mysqli_query($conexao, "INSERT INTO album (titulo, capa, id_usuario) VALUES ('$titulo','$nomeArquivoExtensao',$id_usuario)");
                    $tabelaAlbum = mysqli_query($conexao, "SELECT id_album FROM album WHERE capa='$nomeArquivoExtensao'");
                    $album = mysqli_fetch_assoc($tabelaAlbum);
                    $id_album = $album['id_album'];
                    header("Location: editAlbum.php?id_album=$id_album");
                }
            } else header("Location: addAlbumForm.php?erro=0");
        } else header("Location: addAlbumForm.php?erro=1");
    } else header("Location: addAlbumForm.php?erro=2");
}
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

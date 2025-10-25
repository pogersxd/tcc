<?php
session_start();
include_once "conect.php";
if (!isset($_SESSION['usuario']) or !$_POST) header("Location: index.php");
$titulo = $_POST["titulo"];
// var_dump($_FILES);
$pasta = "./assets/songs/";
$nomeArquivo = md5(time());
$nomeCompleto = $_FILES["arquivo"]["name"];
$nomeSeparado = explode('.', $nomeCompleto)[count($nomeSeparado) - 1];
echo mime_content_type($_FILES['arquivo']['tmp_name']);
// $nomeSeparado = explode('.', $nomeCompleto);
// $ultimaPosicao = count($nomeSeparado) - 1;
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

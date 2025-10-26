<?php
session_start();
if (!isset($_SESSION['usuario']) || !$_POST) header("Location: index.php");
include_once "conect.php";
$titulo = $_POST["titulo"];
$capa = $_POST["capa"];
$id_usuario = $_SESSION['usuario']['id_usuario'];
$teste = mysqli_query($conexao, "SELECT * FROM album WHERE titulo = '$titulo'");
if (mysqli_num_rows($teste) == 0) {
    mysqli_query($conexao, "INSERT INTO album (titulo, capa, id_usuario) VALUES ('$titulo','$capa',$id_usuario)");
    $id_album = mysqli_fetch_assoc(mysqli_query($conexao, "SELECT * FROM album WHERE titulo = '$titulo'"))['id_album'];
    header("Location: editAlbum.php?id_album=$id_album");
}

<?php
require_once "conect.php";

if (isset($_GET['id_musica'])) {
    $id = $_GET['id_musica'];
    $sql = mysqli_query($conexao, "SELECT titulo FROM musica WHERE id_musica = '$id'");
    $tabela = mysqli_fetch_assoc($sql);
    echo $tabela['titulo'];
}
if (isset($_GET['id_album'])) {
    $id = $_GET['id_album'];
    $sql = mysqli_query($conexao, "SELECT titulo FROM musica WHERE id_album = '$id'");
    $html = "";
    while ($linha = mysqli_fetch_assoc($sql)) {
        $html .= "{$linha['titulo']}<br>";
    }
    echo $html;
}

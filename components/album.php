<?php
require_once __DIR__ . "/../conect.php";
function renderAlbum()
{
    global $conexao;
    $id_album = $_POST['id_album'];
    $html = '';
    $tabelaAlbumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
    if ($tabelaAlbumQuery) {
        $tabelaAlbum = mysqli_fetch_assoc($tabelaAlbumQuery);
        $titulo = $tabelaAlbum['titulo'];
        $capa = $tabelaAlbum['capa'];
        $id_usuario = $tabelaAlbum['id_album'];
        $html = "
        Capa do Álbum: <br>
        <img src='./assets/albumCovers/{$capa}' class='album__image'> 
        
        ";
    }

    return $html;
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderAlbum();
}

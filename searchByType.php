<?php
require_once __DIR__ . "/conect.php";
require_once __DIR__ . "/components/singleItemMusica.php";
require_once __DIR__ . "/components/singleItemAlbum.php";
require_once __DIR__ . "/components/singleItemArtista.php";
function searchByType($tipo, $q)
{
    global $conexao;
    $html = '';
    $q = mysqli_real_escape_string($conexao, $q);

    switch ($tipo) {

        /* ======================
           MÚSICAS
        ====================== */
        case "musicas":

            $sql = mysqli_query($conexao, "
                SELECT 
                  m.titulo,
                  m.arquivo,
                  a.capa,
                  u.id_usuario,
                  u.nome
                FROM musica m
                JOIN album a   ON a.id_album = m.id_album
                JOIN usuario u ON u.id_usuario = a.id_usuario
                WHERE m.titulo LIKE '%$q%'
            ");

            if (mysqli_num_rows($sql) > 0) {
                while ($linha = mysqli_fetch_assoc($sql)) {
                    $html .= renderSingleItemMusica(
                        $linha['capa'],
                        $linha['arquivo'],
                        $linha['titulo'],
                        $linha['nome'],
                        $linha['id_usuario']
                    );
                }
            } else {
                $html = "<b>Nenhuma música encontrada!</b>";
            }
            break;


        /* ======================
           ÁLBUNS
        ====================== */
        case "albuns":

            $sql = mysqli_query($conexao, "
                SELECT 
                  a.id_album,
                  a.titulo,
                  a.capa,
                  u.id_usuario,
                  u.nome
                FROM album a
                JOIN usuario u ON u.id_usuario = a.id_usuario
                WHERE a.titulo LIKE '%$q%'
            ");

            if (mysqli_num_rows($sql) > 0) {
                while ($linha = mysqli_fetch_assoc($sql)) {
                    $html .= renderSingleItemAlbum(
                        $linha['capa'],
                        $linha['titulo'],
                        $linha['id_usuario'],
                        $linha['id_album'],
                        $linha['nome']
                    );
                }
            } else {
                $html = "<b>Nenhum álbum encontrado!</b>";
            }
            break;


        /* ======================
           ARTISTAS
        ====================== */
        case "artistas":

            $sql = mysqli_query($conexao, "
                SELECT DISTINCT
                  u.id_usuario,
                  u.nome,
                  u.foto
                FROM usuario u
                JOIN album a ON a.id_usuario = u.id_usuario
                WHERE u.nome LIKE '%$q%'
            ");

            if (mysqli_num_rows($sql) > 0) {
                while ($linha = mysqli_fetch_assoc($sql)) {
                    $html .= renderSingleItemArtista(
                        $linha['id_usuario'],
                        $linha['nome'],
                        $linha['foto']
                    );
                }
            } else {
                $html = "<b>Nenhum artista encontrado!</b>";
            }
            break;
    }

    return $html;
}

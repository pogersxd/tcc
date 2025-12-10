<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/singleItemAlbum.php";
function renderProfile()
{
    global $conexao;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $sessionIgualPost = false;
    if (isset($_SESSION['usuario']['id_usuario']) && $_POST) {
        if ($_POST['id_usuario'] == $_SESSION['usuario']['id_usuario']) $sessionIgualPost = true;
    }

    $postNaoExisteMasSessaoSim = false;
    if (!$_POST && isset($_SESSION['usuario'])) $postNaoExisteMasSessaoSim = true;
    $buttons = '';
    if ($sessionIgualPost || $postNaoExisteMasSessaoSim) {
        $id_usuario = $_SESSION['usuario']['id_usuario'];
        $buttons = <<<HTML
                        <div class="profile-buttons">
                            <button class="profile-edit" onclick="loadEditProfile('{$id_usuario}')"><i class="fa-solid fa-pen"></i> Editar perfil</button>
                            <a href="./logout.php" class="profile-logout" ><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
                        </div>
        HTML;
        $nome = $_SESSION['usuario']['nome'];
        $bio = $_SESSION['usuario']['bio'];
        $foto = $_SESSION['usuario']['foto'];
    } else {
        $id_usuario = $_POST['id_usuario'];
        $usuarioQuery = mysqli_query($conexao, "SELECT * FROM usuario WHERE id_usuario = '$id_usuario'");
        $usuario = mysqli_fetch_assoc($usuarioQuery);
        $nome = $usuario['nome'];
        $foto = $usuario['foto'];
        $bio = nl2br($usuario['bio']);
        if (isset($_SESSION['usuario'])) {
            $id_usuarioSessao = $_SESSION['usuario']['id_usuario'];
            $curtido = mysqli_query($conexao, "SELECT * FROM curtido WHERE id_item = '$id_usuario' AND tipo = 'artista' AND id_usuario = '$id_usuarioSessao'");
            $curtido = (mysqli_num_rows($curtido) > 0);
            $ativoDesativo = $curtido ? "ativo" : "";
            $buttons = <<<HTML
                    <div class="profile-buttons">
                        <button 
                            class="btn-curtir {$ativoDesativo}"
                            data-tipo="artista"
                            data-id="{$id_usuario}"
                            onclick="toggleCurtida(this)"
                            >
                            ❤︎
                        </button>
                    </div>
            HTML;
        }
    }
    $albumQuery = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = '$id_usuario'");
    $albuns = '<h2>Este perfil não tem álbuns</h2>';
    if (mysqli_num_rows($albumQuery) > 0) {
        $albuns = '<h2>Álbuns</h2>';
        $albuns .= '<div class="profile-playlist-list">';
        while ($album = mysqli_fetch_assoc($albumQuery)) {
            $albuns .= renderSingleItemAlbum($album['capa'], $album['titulo'], $id_usuario, $album['id_album'], $nome);
        }
        $albuns .= '</div>';
    }
    return <<<HTML
            <div class="profile-page">
                <div class="profile-header">
                    <img src="./assets/pfps/{$foto}" alt="Foto do usuário" class="profile-photo">

                    <div class="profile-info">
                        <span class="profile-type">Perfil</span>
                        <h1 class="profile-name">{$nome}</h1>
                        <p class="profile-text">{$bio}</p>
                        {$buttons}
                    </div>
                </div>

                <div class="profile-section">
                    {$albuns}
                </div>
            </div>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderProfile();
}

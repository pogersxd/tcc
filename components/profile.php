<?php
function renderProfile()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $sessionIgualPost = false;
    if (isset($_SESSION['usuario']['id_usuario']) && $_POST) {
        if ($_POST['id_usuario'] == $_SESSION['usuario']['id_usuario']) $sessionIgualPost = true;
    }

    $postNaoExisteMasSessaoSim = false;
    if (!$_POST && isset($_SESSION['usuario'])) $postNaoExisteMasSessaoSim = true;

    if ($sessionIgualPost || $postNaoExisteMasSessaoSim) {
        // return <<<HTML
        //     <div>
        //     <h1>Meu perfil</h1>
        //     <h3>Foto de perfil:</h3>
        //     <img src="./assets/pfps/{$_SESSION['usuario']['foto']}" width=100px height=100px alt="Imagem do seu perfil">
        //     <h3>Nome: </h3>
        //     {$_SESSION['usuario']['nome']}
        //     <h3>Bio: </h3>
        //     {$_SESSION['usuario']['bio']}
        //     <div>
        //     HTML;
        return <<<HTML
            <div class="profile-page">
                <div class="profile-header">
                    <img src="./assets/pfps/{$_SESSION['usuario']['foto']}" alt="Foto do usuário" class="profile-photo">

                    <div class="profile-info">
                        <span class="profile-type">Perfil</span>
                        <h1 class="profile-name">{$_SESSION['usuario']['nome']}</h1>

                        <div class="profile-buttons">
                            <button class="profile-edit"><i class="fa-solid fa-pen"></i> Editar perfil</button>
                            <a href="./logout.php" class="profile-logout" ><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
                        </div>
                    </div>
                </div>

                <div class="profile-section">
                    <h2>Suas playlists</h2>

                    <div class="profile-playlist-list">

                    <div class="profile-playlist-card">
                        <img src="" class="profile-playlist-image">
                        <div class="profile-playlist-title">Minhas Favoritas</div>
                        <div class="profile-playlist-count">18 músicas</div>
                    </div>

                    <div class="profile-playlist-card">
                        <img src="" class="profile-playlist-image">
                        <div class="profile-playlist-title">Para Estudar</div>
                        <div class="profile-playlist-count">32 músicas</div>
                    </div>

                    </div>
            </div>

</div>
HTML;
    } else {
        $id_usuario = $_POST['id_usuario'];
    }
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderProfile();
}

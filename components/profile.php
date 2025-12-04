<?php
function renderProfile()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!$_POST || $_POST['id_usuario'] == $_SESSION['usuario']['id_usuario']) {
        return <<<HTML
            <div>
            <h1>Meu perfil</h1>
            <h3>Foto de perfil:</h3>
            <img src="./assets/pfps/{$_SESSION['usuario']['foto']}" width=100px height=100px alt="Imagem do seu perfil">
            <h3>Nome: </h3>
            {$_SESSION['usuario']['nome']}
            <h3>Bio: </h3>
            {$_SESSION['usuario']['bio']}
            <div>
            HTML;
    } else header("Location: index.php");
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderProfile();
}

<?php
function renderLogin()
{
    return <<<HTML
    <h1>Realizar Login</h1>
    <form id="loginForm">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Conectar">
    </form>
    Não tem uma conta? <a href="#" onclick="loadComponent('register')">Cadastre-se</a><br>
    <a href="#" onclick="loadComponent('mainMenu')">Continuar sem conta</a>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderLogin();
}

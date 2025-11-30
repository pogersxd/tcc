<?php
function renderLogin()
{
    return <<<HTML
    <h1>Realizar Login</h1>
    <form id="loginForm">
        Email: <input type="email" name="email" require_onced><br>
        Senha: <input type="password" name="senha" require_onced><br>
        <input type="submit" value="Conectar">
    </form>
    Não tem uma conta? <a href="#" onclick="loadComponent('register')">Cadastre-se</a><br>
    <a href="#" onclick="loadComponent('mainMenu')">Continuar sem conta</a>
    HTML;
}

echo renderLogin();

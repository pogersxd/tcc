<?php
function renderLogin()
{
    return <<<HTML
    <h2 class="form-title">Realizar Login</h2>
    <form id="loginForm" class="default-form">
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" required></label><br>
        <input type="submit" value="Conectar">
    </form>
    Não tem uma conta? <a href="#" onclick="loadComponent('register')">Cadastre-se</a><br>
    <a href="#" onclick="loadComponent('mainMenu')">Continuar sem conta</a>
    HTML;
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderLogin();
}

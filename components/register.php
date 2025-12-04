<?php
function renderRegister()
{
    return <<<HTML
    <div>
    <form id="registerForm">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="text" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title='O email precisa ter "@" e "."'  name="email" required><br>
        Senha: <input type="password"
        name="senha"
        id="senha"
        pattern=".{6,20}"
        title="A senha deve ter entre 6 e 20 caracteres"
        required>
        <br>
        Confirmar senha: <input type="password" id="confirmar" required><br>
        <button type="submit" id="botao" disabled>Registrar</button>
        <div id="mensagem" style="color: red;"></div>
    </form>
    Já tem uma conta? <a href="#" onclick="loadComponent('login')">Entre</a><br>
    <a href="#" onclick="loadComponent('mainMenu')">Continuar sem conta</a>
    </div>
    HTML;
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderRegister();
}

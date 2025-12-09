<?php
function renderRegister()
{
    return <<<HTML
    <div>
    <h2 class="form-title">Cadastrar-se</h2>
    <form id="registerForm" class="default-form">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>Email: <input type="text" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title='O email precisa ter "@" e "."'  name="email" required></label><br>
        <label>Senha: <input type="password"
        name="senha"
        id="senha"
        pattern=".{6,20}"
        title="A senha deve ter entre 6 e 20 caracteres"
        required>
        </label>
        <br>
        <label>Confirmar senha: <input type="password" id="confirmar" required></label><br>
        <button type="submit" id="botao" disabled>Registrar</button>
        <div id="mensagem" style="color: red;"></div>
        <span  class="form-link">Já tem uma conta? <a href="#" onclick="loadComponent('login')">Entre</a></span><br>
        <a href="#" class="form-link" onclick="loadComponent('mainMenu')">Continuar sem conta</a>
    </form>
    </div>
    HTML;
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderRegister();
}

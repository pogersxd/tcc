<?php
function renderRegister()
{
    return <<<HTML
    <div>
    <form id="register">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" id="senha" pattern=".{6,20}" title="Digite uma senha entre 6 e 20 caracteres" required><br>
        Confirmar senha: <input type="password" id="confirmar" required><br>
        <button type="submit" id="botao" disabled>Registrar</button>
        <div id="mensagem" style="color: red;"></div>
    </form>
    Já tem uma conta? <a href="./login.php">Entre</a>
    <a href="./index.php">Continuar sem conta</a>
    </div>
    HTML;
}
if ($_SERVER["SCRIPT_FILENAME"] === __FILE__) {
    echo renderRegister();
}

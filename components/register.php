<?php
function renderRegister()
{
    return <<<HTML
    <form id="register">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" id="senha" pattern=".{6,20}" title="Digite uma senha entre 6 e 20 dígitos" required><br>
        Confirmar senha: <input type="password" name="senha" id="confirmar" required><br>
        <button type="submit" id="botao" disabled>Registrar</button>
        <div id="mensagem" style="color: red;"></div>
    </form>
    Já tem uma conta? <a href="./login.php">Entre</a>
    <a href="./index.php">Continuar sem conta</a>
    <script>
        const senha = document.getElementById("senha");
        const confirmarSenha = document.getElementById("confirmar");
        const botao = document.getElementById("botao");
        const mensagem = document.getElementById("mensagem");

        function verificarSenhas() {
            if (senha.value === "" || confirmarSenha.value === "") {
                mensagem.innerHTML = "";
                botao.disabled = true;
                return;
            }
            if (senha.value != confirmarSenha.value) {
                mensagem.innerHTML = "As senhas não coincidem";
                botao.disabled = true;
            } else {
                mensagem.innerHTML = "";
                botao.disabled = false;
            }
        }
        senha.addEventListener("input", verificarSenhas);
        confirmarSenha.addEventListener("input", verificarSenhas);
    </script>
    HTML;
}
if ($_SERVER["SCRIPT_FILENAME"] === __FILE__) {
    echo renderRegister();
}

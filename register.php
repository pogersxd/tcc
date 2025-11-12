<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCC - Registrar</title>
    <link rel="stylesheet" href="styles.css" class="rel">
    <link rel="icon" href="assets/james.png">
</head>

<body>
    <form action="createAccount.php" method="post">
        Nome: <input type="text" name="nome" required><br>
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" id="senha" required><br>
        Confirmar senha: <input type="password" name="senha" id="confirmar" required><br>
        <button type="submit" id="botao" disabled>Registrar</button>
        <div id="mensagem" style="color: red;"></div>
    </form>
    Já tem uma conta? <a href="./login.php">Entre</a>
    <a href="./index.php">Continuar sem conta</a>
    <?php
    session_start();
    if (isset($_SESSION["naoUnico"])) {
        if ($_SESSION["naoUnico"] == true) echo "Email já em uso.";
        unset($_SESSION["naoUnico"]);
    }
    ?>
</body>
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

</html>
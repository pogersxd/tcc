<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCC - Login</title>
    <link rel="stylesheet" href="styles.css" class="rel">
    <link rel="icon" href="assets/james.png">
</head>

<body>
    <h1>Realizar Login</h1>
    <form action="verifyLogin.php" method="post">
        Email: <input type="email" name="email" required><br>
        Senha: <input type="password" name="senha" required><br>
        <input type="submit" value="Conectar">
    </form>
    Não tem uma conta? <a href="./register.php">Cadastre-se</a><br>
    <a href="./index.php">Continuar sem conta</a>
    <?php
    session_start();
    if (isset($_SESSION["errou"])) {
        if ($_SESSION["errou"] == true) echo "Email ou senha incorretos.";
        unset($_SESSION["errou"]);
    }
    ?>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCC - Login</title>
    <link rel="icon" href="assets/james.png">
</head>

<body>
    <div>
        <div>
            <div>
                <form action="verify_login.php" method="post">
                    Email: <input type="email" name="email" required><br>
                    Senha: <input type="password" name="senha" required><br>
                    <input type="submit" value="Conectar">
                </form>
            </div>
            <div>
                Não tem uma conta? <a href="./register.php">Cadastre-se</a>
            </div>
            <a href="./index.php">Continuar sem conta</a>
            <?php
            session_start();
            if (isset($_SESSION["errou"])) {
                if ($_SESSION["errou"] == true) echo "Email ou senha incorretos.";
                unset($_SESSION["errou"]);
            }
            ?>
        </div>
    </div>
</body>

</html>
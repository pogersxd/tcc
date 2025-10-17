<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TCC - Registrar</title>
    <link rel="icon" href="assets/james.png">
</head>

<body>
    <div>
        <div>
            <div>
                <form action="create_account.php" method="post">
                    Nome: <input type="text" name="nome" required><br>
                    Email: <input type="email" name="email" required><br>
                    Senha: <input type="password" name="senha" required><br>
                    <input type="submit" value="Registrar">
                </form>
            </div>
            <div>
                Já tem uma conta? <a href="./login.php">Entre</a>
            </div>
            <a href="./index.php">Continuar sem conta</a>
            <?php
            session_start();
            if (isset($_SESSION["naoUnico"])) {
                if ($_SESSION["naoUnico"] == true) echo "Email já em uso.";
                unset($_SESSION["naoUnico"]);
            }
            ?>
        </div>
    </div>
</body>

</html>
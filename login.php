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
                    Usuário: <input type="text" name="usuario">
                    Email: <input type="email" name="email">
                    Senha: <input type="password" name="senha">
                    <input type="submit" value="Conectar">
                </form>
            </div>
            <div>
                Não tem uma conta? <a href="/register.php">Cadastre-se</a>
            </div>
        </div>
    </div>
</body>

</html>
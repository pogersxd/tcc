<?php
session_start();
if (!isset($_SESSION['usuario'])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar álbum</title>
</head>

<body>
    <h1>Cadastrar álbum</h1>
    <form action="addAlbum.php" method="post">
        Título do álbum: <input type="text" name="titulo" required><br>
        Capa do álbum: capa_padrao.jpg <input type="hidden" name="capa" value="capa_padrao.jpg" required><br>
        <input type="submit" value="Adicionar">
        <br><a href="index.php">Voltar à página inicial</a>
    </form>
</body>

</html>
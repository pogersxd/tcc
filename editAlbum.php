<?php
session_start();
include_once "conect.php";
if (!isset($_SESSION['usuario'])) header("Location: index.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar álbuns</title>
</head>

<body>

</body>

</html>
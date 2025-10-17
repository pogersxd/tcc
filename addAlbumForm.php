<?php
session_start();
if (!isset($_SESSION)) header("Location: index.php")
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar álbum</title>
</head>

<body>
    <form action="addAlbumSong.php" method="post">
        <input type="text">
    </form>
</body>

</html>
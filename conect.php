<?php
$conexao = mysqli_connect('localhost', 'root', '', 'streaming_musica');
if (!$conexao) {
    die("erro na conexão");
    exit();
}

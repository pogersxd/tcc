<?php
function registroExiste($conexao, $tabela, $coluna, $valor)
{
    $valor = mysqli_real_escape_string($conexao, $valor);
    $query = "SELECT 1 FROM $tabela WHERE $coluna = '$valor' LIMIT 1";
    $resultado = mysqli_query($conexao, $query);
    return mysqli_num_rows($resultado) > 0;
}
function tabelaVazia($conexao, $tabela)
{
    $resultado = mysqli_query($conexao, "SELECT 1 FROM $tabela LIMIT 1");
    return mysqli_num_rows($resultado) === 0;
}

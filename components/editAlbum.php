<?php
function renderEditAlbum()
{

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    include __DIR__ . "/../conect.php";
    include __DIR__ . "/../functions.php";
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    if (isset($_GET['id_album'])) {
        header("Location: addMusicForm.php?id_album={$_GET['id_album']}");
    }
    echo "<h1>Seus álbuns</h1>";
    if (registroExiste($conexao, 'album', 'id_usuario', $_SESSION['usuario']['id_usuario'])) {
        $sql = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
        echo '
        <table>
            <tr>
                <th>Título</th>
                <th>Capa</th>
                <th>Operações</th>
            </tr>';
        while ($linha = mysqli_fetch_assoc($sql)) {
            echo "<tr>
                    <td>{$linha['titulo']}</td>
                    <td>{$linha['capa']}</td>
                    <td><a href='addMusicForm?id_album={$linha['id_album']}'>Gerenciar músicas</a>
                    | <button onclick='" . 'openDeleteModal("album", ' . $linha['id_album'] . ")'>Excluir</button></td>
                </tr>
                <div id='confirmModal" . $linha['id_album'] . "' class='modal' style='display:none'>
                    <div class='modal-content'>
                        <h2 id='modalTitle" . $linha['id_album'] . "'></h2>
                        <p id='modalMessage" . $linha['id_album'] . "'></p>
                        <div class='modal-buttons'>
                            <a id='confirmDelete' class='deleteAlbumBtn' href='#' data-id='{$linha['id_album']}'>Excluir</a>
                            <a id='cancelDelete' class='cancelBtn' href='#'>Cancelar</a>
                        </div>
                    </div>
                </div>";
        }
        echo "</table>";
    } else {
        echo "Você não tem nenhum álbum cadastrado. <br>";
        echo "<a href='#' onclick='loadComponent(\"addAlbumForm\")'>Cadastrar álbum</a>";
    }
    echo '<br><a href="#" onclick="loadComponent(\'mainMenu\')">Voltar à página inicial</a>';
}
echo renderEditAlbum();

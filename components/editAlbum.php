<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
function renderEditAlbum()
{
    global $conexao;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['usuario'])) header("Location: index.php");
    echo "<h2>Seus álbuns</h2>";
    if (registroExiste($conexao, 'album', 'id_usuario', $_SESSION['usuario']['id_usuario'])) {
        $sql = mysqli_query($conexao, "SELECT * FROM album WHERE id_usuario = {$_SESSION['usuario']['id_usuario']}");
        echo <<<HTML
            <table>
                <tr>
                    <th>Título</th>
                    <th>Capa</th>
                    <th>Operações</th>
                </tr>
            HTML;
        while ($linha = mysqli_fetch_assoc($sql)) {
            echo "<tr>
                    <td>{$linha['titulo']}</td>
                    <td><img class='edit-album__image' src='./assets/albumCovers/{$linha['capa']}'></td>
                    <td><a href='#' class='manageSongs' onclick=\"manageSongs('{$linha['id_album']}')\">Gerenciar músicas</a>
                    | <button onclick='" . 'openDeleteModal("album", ' . $linha['id_album'] . ")'>Excluir</button></td>
                </tr>
                <div id='confirmModal" . $linha['id_album'] . "' class='modal' style='display:none'>
                    <div class='modal-content'>
                        <h2 id='modalTitle" . $linha['id_album'] . "'></h2>
                        <p id='modalMessage" . $linha['id_album'] . "'></p>
                        <div class='modal-buttons'>
                            <a id='confirmDelete' class='deleteAlbumBtn' href='#' onclick=\"deleteAlbum('{$linha['id_album']}')\">Excluir</a>
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
    echo '<br><a href="#" onclick="loadComponent(\'mainMenu\')">Voltar à página inicial</a></div>';
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditAlbum();
}

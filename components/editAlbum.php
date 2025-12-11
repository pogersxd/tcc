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
        echo "<div class='albums-grid'>";

        while ($linha = mysqli_fetch_assoc($sql)) {

            echo <<<HTML
            <div class="single-item album-item">

                <img 
                    class="single-item__image" 
                    src="./assets/albumCovers/{$linha['capa']}" 
                    alt="Capa do álbum {$linha['titulo']}"
                >

                <div class="single-item__texts">
                    <span class="single-item__texts-title" title="{$linha['titulo']}">
                        {$linha['titulo']}
                    </span>
                </div>

                <div class="album-actions">
                    <button 
                        class="album-btn"
                        onclick="manageSongs('{$linha['id_album']}')">
                        Gerenciar músicas
                    </button>

                    <button 
                        class="album-btn"
                        onclick="loadEditAlbumForm('{$linha['id_album']}')">
                        Editar
                    </button>

                    <button 
                        class="album-btn"
                        onclick="openDeleteModal('album', '{$linha['id_album']}')">
                        Excluir
                    </button>
                </div>
            </div>

            <!-- Modal -->
            <div id="confirmModal{$linha['id_album']}" class="modal" style="display:none">
                <div class="modal-content">
                    <h2 id="modalTitle{$linha['id_album']}">Excluir álbum</h2>
                    <p id="modalMessage{$linha['id_album']}">
                        Tem certeza que deseja excluir este álbum?
                    </p>
                    <div class="modal-buttons">
                        <button 
                            class="deleteAlbumBtn"
                            onclick="deleteAlbum('{$linha['id_album']}')">
                            Excluir
                        </button>
                        <button 
                            class="cancelBtn"
                            onclick="closeModal('confirmModal{$linha['id_album']}')">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
            HTML;
        }

        echo "</div>";
    } else {
        echo "Você não tem nenhum álbum cadastrado. <br>";
    }
}
if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderEditAlbum();
}

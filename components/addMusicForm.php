<?php
require_once __DIR__ . "/../conect.php";
require_once __DIR__ . "/../functions.php";
function renderAddMusicForm()
{
  global $conexao;
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  if (!isset($_SESSION['usuario']) or !isset($_POST['id_album'])) header("Location: index.php");
  $id_album = $_POST['id_album'];
  $tabelaAlbum = mysqli_query($conexao, "SELECT * FROM album WHERE id_album = '$id_album'");
  $album = mysqli_fetch_assoc($tabelaAlbum);
  $tituloAlbum = $album['titulo'];

  echo "<div class='album-music-page'>";

  echo "<h2 class='page-title'>
        Músicas já presentes no álbum \"$tituloAlbum\"
      </h2>";

  if (registroExiste($conexao, 'musica', 'id_album', $id_album)) {

    echo "<div class='album-music-table-wrapper'>
            <table class='album-music-table'>
              <thead>
                <tr>
                  <th>Título</th>
                  <th>Arquivo</th>
                  <th>Duração</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>";

    $sql = mysqli_query($conexao, "SELECT * FROM musica WHERE id_album = $id_album");

    while ($linha = mysqli_fetch_assoc($sql)) {

      echo "
        <tr>
          <td>{$linha['titulo']}</td>
          <td>{$linha['arquivo']}</td>
          <td>" . gmdate('i:s', $linha['duracao']) . "</td>

          <td class='music-actions'>
            <button class='btn-edit'
              onclick=\"loadEditSongForm({$linha['id_musica']})\">
              <i class='fa-solid fa-pen'></i>
            </button>

            <button class='btn-delete'
              onclick=\"openDeleteModal('music', {$linha['id_musica']})\">
              <i class='fa-solid fa-trash'></i>
            </button>
          </td>
        </tr>

        <div id='confirmModal" . $linha['id_musica'] . "' class='modal' style='display:none'>
            <div class='modal-content'>
                <h2 id='modalTitle" . $linha['id_musica'] . "'></h2>
                <p id='modalMessage" . $linha['id_musica'] . "'></p>
                <div class='modal-buttons'>
                    <a id='confirmDelete' href='#' class='deleteSongBtn' onclick=\"deleteSong('{$linha['id_musica']}', '{$linha['id_album']}')\">Excluir</a>
                    <a id='cancelDelete' class='cancelBtn' href='#'>Cancelar</a>
                </div>
            </div>
        </div>";
    }

    echo "</tbody></table></div>";
  } else {
    echo "<p class='empty-info'>Nenhuma música cadastrada.</p>";
  }

  echo "</div>";

  echo <<<HTML
    <h2 class="form-title">Adicionar música ao álbum</h2>
    <form id="add-music-form" class="default-form" enctype="multipart/form-data">
        <label>Título: <input type="text" name="titulo" required></label><br>
        <label>Arquivo: (máximo de 20MB)<input type="file" name="arquivo" required></label><br>
        <label>Detalhes: <br><textarea rows="15" name="detalhes" required></textarea></label><br>
        <input type="hidden" name="id_album" value="{$id_album}">
        <input type="submit" value="Adicionar música">
        <br><a href="#" class="form-link" onclick="loadComponent('mainMenu')">Voltar à página inicial</a>
    </form>
    HTML;
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
  renderAddMusicForm();
}

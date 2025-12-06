 <?php
  require_once __DIR__ . "/../functions.php";
  require_once __DIR__ . "/../conect.php";
  function renderPlayer()
  {
    global $conexao;
    if (isset($_POST["musica"]) && registroExiste($conexao, "musica", "arquivo", $_POST['musica'])) {
      $musica = $_POST["musica"];
      $id_usuario = $_POST["id_usuario"];
      $sql =  "SELECT * FROM musica WHERE arquivo = '$musica'";
      $tabelaMusicaQuery = mysqli_query($conexao, $sql);
      if (!$tabelaMusicaQuery) {
        die("Erro na consulta SQL: " . mysqli_error($conexao));
      }
      $tabelaMusica = mysqli_fetch_assoc($tabelaMusicaQuery);
      $id_musica = $tabelaMusica['id_musica'];
      $titulo = $tabelaMusica['titulo'];
      $id_album = $tabelaMusica['id_album'];
      $tabelaUsuarioQuery = mysqli_query($conexao, "SELECT nome FROM usuario WHERE id_usuario = '$id_usuario'");
      $tabelaUsuario = mysqli_fetch_assoc($tabelaUsuarioQuery);
      $nome = $tabelaUsuario['nome'];
      $pausePlay = "pause";
      $toca = 'autoplay';
      return <<<HTML
            <div id='player'>
              <div class="player">
                <div class="player__button">
                  <i class="fa-solid fa-circle-{$pausePlay}" id="player__pause-icon"></i>
                </div>
                <a href="#" class="player__link" onclick="loadMusicaTela('{$id_musica}')">{$titulo}</a>
                <a href="#" class="player__link" onclick="loadProfile('{$id_usuario}')"><b>{$nome}</b></a>
                <audio class="player__audio" id="player__audio" {$toca}>
                  <source src="./assets/songs/{$musica}">
                </audio>
                <div class="player__progress-wrapper">
                  <input type="range" id="player__progress" min="0" max="100" value="0" step="0.1">
                  <div id="progressTooltip">00:00</div>
                </div>
                <div class="player__time">
                  <span id="player__time"></span>
                </div>
              </div>
            </div>
          HTML;
    } else return <<<HTML
      <div id="player">
      </div>
      HTML;
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderPlayer();
  }

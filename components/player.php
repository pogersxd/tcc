 <?php
  require_once __DIR__ . "/../functions.php";
  require_once __DIR__ . "/../conect.php";
  function renderPlayer()
  {
    global $conexao;
    if (isset($_GET["musica"]) && registroExiste($conexao, "musica", "arquivo", $_GET['musica'])) {
      $musica = $_GET["musica"];
      $sql =  "SELECT * FROM musica WHERE arquivo = '$musica'";
      $tabelaMusicaQuery = mysqli_query($conexao, $sql);
      if (!$tabelaMusicaQuery) {
        die("Erro na consulta SQL: " . mysqli_error($conexao));
      }
      $tabelaMusica = mysqli_fetch_assoc($tabelaMusicaQuery);
      $titulo = $tabelaMusica['titulo'];
      $duracao = gmdate('i:m', $tabelaMusica['duracao']);
      $pausePlay = "pause";
      $toca = 'autoplay';
      return <<<HTML
            <div class="player">
              <div class="player__button">
                <i class="fa-solid fa-circle-{$pausePlay}" id="player__pause-icon"></i>
              </div>
              <p>{$titulo}</p>
              <audio class="player__audio" id="player__audio" {$toca}>
                <source src="./assets/songs/{$musica}">
              </audio>
              <div class="player__time">
                <span id="player__time">00:00</span> / {$duracao}
              </div>
            </div>
          HTML;
    }
  }
  if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"])) {
    echo renderPlayer();
  }

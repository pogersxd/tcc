 <?php
  function renderPlayer()
  {
    global $conexao;
    if (isset($_GET["musica"])) {
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
              <div class="player__time" id="player__time">
                <p>00:00</p>
              </div>
            </div>
          HTML;
    }
  }
  if ($_SERVER["SCRIPT_FILENAME"] === __FILE__) {
    echo renderPlayer();
  }

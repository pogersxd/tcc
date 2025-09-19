 <?php
include "itensArrays.php";
function renderPlayer()
{
  global $vetorMusicas, $vetorNomeMusicas;
  if (!isset($_GET["musica"]) || empty($_GET["musica"])) {
    $musica = $vetorMusicas[0];
    $nomeMusica = $vetorNomeMusicas[0];
    $pausePlay = "play";
    $toca = '';
  } else {
    $musica = $_GET["musica"];
    foreach ($vetorMusicas as $key => $value) {
      if ($value === $musica) $nomeMusica = $vetorNomeMusicas[$key];
    }
    $pausePlay = "pause";
    $toca = 'autoplay';
  }
  return <<<HTML
          <div class="player">
            <div class="player__button">
              <i class="fa-solid fa-circle-{$pausePlay}" id="player__pause-icon"></i>
            </div>
            <p>{$nomeMusica}</p>
            <audio class="player__audio" id="player__audio" {$toca}>
              <source src="./assets/{$musica}" type="audio/mpeg">
            </audio>
            <div class="player__time" id="player__time">
              <p>00:00</p>
            </div>
          </div>
        HTML;
}
if ($_SERVER["SCRIPT_FILENAME"] === __FILE__) {
  echo renderPlayer();
}
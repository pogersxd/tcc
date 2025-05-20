<?php
function renderPlayer(){
  return <<<HTML
          <div class="player">
            <div class="player__button">
              <i class="fa-solid fa-circle-play" id="player__pause-icon"></i>
            </div>
            <audio class="player__audio" id="player__audio">
              <source src="assets/thinking-time-ticking-power-223023.mp3" type="audio/mpeg">
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
const audio = document.getElementById("player__audio");
const icon = document.getElementById("player__pause-icon");
const time = document.getElementById("player__time");

if (audio && icon && time) {
  function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60)
      .toString()
      .padStart(2, "0");
    const secondsRemaining = Math.floor(seconds % 60)
      .toString()
      .padStart(2, "0");
    const time = minutes + ":" + secondsRemaining;
    return time;
  }
  icon.addEventListener("click", () => {
    if (audio.paused) {
      audio.play();
      icon.classList.remove("fa-circle-play");
      icon.classList.add("fa-circle-pause");
    } else {
      audio.pause();
      icon.classList.remove("fa-circle-pause");
      icon.classList.add("fa-circle-play");
    }
  });
  audio.addEventListener("timeupdate", () => {
    time.innerHTML = formatTime(audio.currentTime);
  });
}


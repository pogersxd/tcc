/***************************
 * 1. FUNÇÃO BASE SPA
 ***************************/
function loadPage(component, data = {}, pushHistory = true) {
  const container = document.getElementById("main-menu");
  if (!container) return;

  fetch(`./components/${component}.php`, {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams(data)
  })
    .then(res => {
      if (!res.ok) throw new Error("Erro ao carregar componente");
      return res.text();
    })
    .then(html => {
      if (component == "mainMenu") container.outerHTML = html;
      else container.innerHTML = html;

      if (pushHistory) {
        history.pushState(
          { component, data },
          "",
          "#/" + component
        );
      }
    })
    .catch(err => console.error(err));
}

/***************************
 * 2. COMPATIBILIDADE COM loadComponent
 ***************************/
function loadComponent(componentName) {
  if (componentName === "mainMenu") {
    fetch("./components/mainMenu.php")
      .then(res => res.text())
      .then(html => {
        document.getElementById("main-menu").outerHTML = html;
        history.pushState({ component: "mainMenu" }, "", "#/mainMenu");
      });
  } else {
    loadPage(componentName);
  }
}

/***************************
 * 3. HISTÓRICO (Voltar / Avançar)
 ***************************/
window.addEventListener("popstate", (event) => {
  if (!event.state) return;
  const { component, data } = event.state;
  loadPage(component, data, false);
});

/***************************
 * 4. LOADERS ESPECÍFICOS
 ***************************/
const loadAlbum = id_album => loadPage("album", { id_album });
const loadPlaylist = id_playlist => loadPage("playlist", { id_playlist });
const loadProfile = id_usuario => loadPage("profile", { id_usuario });
const loadEditAlbumForm = id_album => loadPage("editAlbumForm", { id_album });
const loadEditPlaylist = id_playlist => loadPage("editPlaylistForm", { id_playlist });
const loadEditProfile = id_usuario => loadPage("editProfileForm", { id_usuario });
const loadEditSongForm = id_musica => loadPage("editSongForm", { id_musica });
const loadMusicaTela = id_musica => loadPage("song", { id_musica });

function loadItemList(tipo) {
  loadPage("itemList", { tipo });
}

/***************************
 * 5. RELOAD LEFT BAR
 ***************************/
function reloadLeftBar() {
  fetch("./components/leftBar.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("left-bar").outerHTML = html;
    });
}

/***************************
 * 6. SEARCH
 ***************************/
let searchTimeout;

function search(q) {
  clearTimeout(searchTimeout);

  searchTimeout = setTimeout(() => {
    if (!q.trim()) {
      loadComponent("mainMenu");
      return;
    }

    fetch("components/searchResults.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({ q })
    })
      .then(res => res.text())
      .then(html => {
        document.getElementById("main-menu").innerHTML = html;
        history.pushState(
          { component: "searchResults", data: { q } },
          "",
          "#/search"
        );
      });

  }, 300);
}

/***************************
 * 7. SUBMIT DE FORMULÁRIOS
 ***************************/
document.addEventListener("submit", function (event) {
  const form = event.target;
  if (!form.id) return;

  event.preventDefault();

  const rotas = {
    "add-album-form": "./addAlbum.php",
    "add-playlist-form": "./addPlaylist.php",
    "registerForm": "./createAccount.php",
    "loginForm": "./verifyLogin.php",
    "add-music-form": "./addMusica.php",
    "edit-playlist-form": "./editplaylist.php",
    "edit-profile-form": "./editprofile.php",
    "edit-album-form": "./editalbum.php",
    "edit-song-form": "./editsong.php"
  };

  const arquivo = rotas[form.id];
  if (!arquivo) return;

  fetch(arquivo, {
    method: "POST",
    body: new FormData(form)
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message);

      if (data.nextComponent) {
        loadPage(data.nextComponent, data.id ? { id: data.id } : {});
      }

      if (data.reloadLeftBar) reloadLeftBar();
      if (data.reloadPage) window.location.reload();
    })
    .catch(err => console.error(err));
});

/***************************
 * 8. CURTIDAS
 ***************************/
function toggleCurtida(botao) {
  fetch("./toggleCurtida.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({
      tipo: botao.dataset.tipo,
      id_item: botao.dataset.id
    })
  })
    .then(res => res.json())
    .then(data => {
      botao.classList.toggle("ativo", data.curtido);
      reloadLeftBar();
    });
}

/***************************
 * 9. PLAYER
 ***************************/
function loadMusica(musica, id_usuario) {
  fetch("./components/player.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams({ musica, id_usuario })
  })
    .then(res => res.text())
    .then(html => {
      document.getElementById("player").outerHTML = html;
      logicaPlayer();
    });
}

function botaoPause() {
  const audio = document.getElementById("player__audio");
  const icon = document.getElementById("player__pause-icon");
  if (!audio || !icon) return;

  if (audio.paused) {
    audio.play();
    icon.classList.replace("fa-circle-play", "fa-circle-pause");
  } else {
    audio.pause();
    icon.classList.replace("fa-circle-pause", "fa-circle-play");
  }
}

function logicaPlayer() {
  const audio = document.getElementById("player__audio");
  const progress = document.getElementById("player__progress");
  const start = document.getElementById("player__time-start");
  const end = document.getElementById("player__time-final");

  if (!audio || !progress) return;

  const format = s =>
    `${String(Math.floor(s / 60)).padStart(2, "0")}:${String(Math.floor(s % 60)).padStart(2, "0")}`;

  audio.addEventListener("timeupdate", () => {
    progress.value = (audio.currentTime / audio.duration) * 100 || 0;
    start.textContent = format(audio.currentTime || 0);
    end.textContent = format(audio.duration || 0);
  });

  progress.addEventListener("input", () => {
    audio.currentTime = (progress.value / 100) * audio.duration;
  });

  document.addEventListener("keydown", e => {
    if (e.code === "Space" && e.target.tagName !== "INPUT") {
      e.preventDefault();
      botaoPause();
    }
  });
}

function loadComponent(componentName) {
  const container = document.getElementById("main-menu");

  if (!container) {
    console.error("Container 'main-menu' não encontrado.");
    return;
  }

  fetch(`./components/${componentName}.php`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Erro ao carregar componente.");
      }
      return response.text();
    })
    .then((html) => {
      if (componentName === "mainMenu") container.outerHTML = html;
      else {
        container.innerHTML = html;
      }
      if (componentName === "register") confirmarSenha();
    })
    .catch((err) => {
      console.error("Erro ao carregar componente:", err);
    });
}

// recarrega a barra lateral
function reloadLeftBar() {
  const leftbar = document.getElementById("left-bar");

  fetch("./components/leftBar.php")
    .then(response => response.text())
    .then(data => {
      leftbar.outerHTML = data;
    })
    .catch(err => { console.error(err) });
}

function reloadHeader() {
  const header = document.getElementById("header");

  fetch("./components/header.php")
    .then(response => response.text())
    .then(data => {
      header.outerHTML = data;
    })
    .catch(err => { console.error(err) });
}

function loadProfile(id) {
  const container = document.getElementById('main-menu');

  fetch("./components/profile.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_usuario=" + encodeURIComponent(id)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}

function loadAlbum(id_album) {
  const container = document.getElementById('main-menu');

  fetch("./components/album.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_album=" + encodeURIComponent(id_album)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}

function loadPlaylist(id_playlist) {
  const container = document.getElementById('main-menu');

  fetch("./components/playlist.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_playlist=" + encodeURIComponent(id_playlist)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}

function loadEditPlaylist(id_playlist) {
  const container = document.getElementById('main-menu');

  fetch("./components/editPlaylistForm.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_playlist=" + encodeURIComponent(id_playlist)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}

function loadItemList(tipo) {
  const container = document.getElementById("main-menu");
  let nome;
  switch (tipo) {
    case "musicas":
      nome = "Músicas";
      break;
    case "albuns":
      nome = "Álbuns";
      break;
    case "artistas":
      nome = "Artistas";
      break;
  }

  fetch("./components/itemList.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "tipo=" + encodeURIComponent(tipo)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
      const texto = document.getElementById("tipo-item-list");
      texto.textContent = nome;
    }).catch(err => {
      console.error(err);
    })
}

function curtirMusica(id) {

}
function curtirMusica(id) {

}
function curtirMusica(id) {

}

function loadMusicaTela(id_musica) {
  const container = document.getElementById('main-menu');

  fetch("./components/song.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_musica=" + encodeURIComponent(id_musica)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}

// submit de formularios
document.addEventListener("submit", function (event) {
  const form = event.target;
  let arquivo;
  switch (form.id) {
    case "add-album-form":
      arquivo = "./addAlbum.php";
      break;
    case "add-playlist-form":
      arquivo = "./addPlaylist.php";
      break;
    case "registerForm":
      arquivo = "./createAccount.php";
      break;
    case "loginForm":
      arquivo = "./verifyLogin.php";
      break;
    case "add-music-form":
      arquivo = "./addMusica.php";
      break;
    case "edit-playlist-form":
      arquivo = "./editplaylist.php";
      break;
  }

  event.preventDefault();
  const formData = new FormData(form);

  fetch(arquivo, {
    method: "POST",
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      window.alert(data.message);

      if (form.id === "add-music-form") {
        fetch("./components/addMusicForm.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "id_album=" + encodeURIComponent(data.id)
        }).then(response => response.text())
          .then(data => {
            const container = document.getElementById('main-menu');
            container.innerHTML = data;
            reloadLeftBar();
          })
          .catch(err => console.error(err));
      }
      else loadComponent(data.nextComponent);

      if (form.id === "loginForm" && data.status === "success") {
        window.location.reload();
      }
    }).catch(err => console.error(err));
});

function deletePlaylist(id) {
  fetch("./deleteAlbum.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_album=" + encodeURIComponent(id)
  }).then(response => response.json())
    .then(data => {
      loadComponent(data.nextComponent)
      window.alert(data.message)
      reloadLeftBar();
    })
    .catch(err => console.error(err));
}

// clique de links que necessitam de atributos semelhante a href = "xx.php?item=x"
function deleteAlbum(id) {
  fetch("./deleteAlbum.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_album=" + encodeURIComponent(id)
  }).then(response => response.json())
    .then(data => {
      loadComponent(data.nextComponent)
      window.alert(data.message)
      reloadLeftBar();
    })
    .catch(err => console.error(err));
}

function manageSongs(id) {
  const container = document.getElementById('main-menu');
  fetch("./components/\addMusicForm.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_album=" + encodeURIComponent(id)
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    })
    .catch(err => console.error(err));
}

function deleteSong(id_musica, id_album) {
  fetch("./deleteSong.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_musica=" + encodeURIComponent(id_musica) +
      "&id_album=" + encodeURIComponent(id_album),
  }).then(response => response.json())
    .then(data => {
      window.alert(data.message);
      fetch(`./components/${data.nextComponent}.php`, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "id_album=" + encodeURIComponent(data.id)
      }).then(response => response.text())
        .then(dados => {
          const container = document.getElementById('main-menu');
          container.innerHTML = dados;
          if (data.status === "success") reloadLeftBar();
        })
        .catch(err => {
          console.error(err);
        })
    }).catch(err => {
      console.error(err);
    })
}

function renderAlbum(id_album) {
  const container = document.getElementById('main-menu');
  fetch('./components/album.php', {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_album=" + encodeURIComponent(id_album),
  }).then(response => response.text())
    .then(data => {
      container.innerHTML = data;
    }).catch(err => console.error(err));
}


// funcao que executa a verificacao das duas senhas
function confirmarSenha() {
  const senha = document.getElementById("senha");
  const confirmarSenha = document.getElementById("confirmar");
  const botao = document.getElementById("botao");
  const mensagem = document.getElementById("mensagem");

  function verificarSenhas() {
    if (senha.value === "" || confirmarSenha.value === "") {
      mensagem.innerHTML = "";
      botao.disabled = true;
      return;
    }
    if (senha.value != confirmarSenha.value) {
      mensagem.innerHTML = "As senhas não coincidem";
      botao.disabled = true;
      return;
    } else {
      mensagem.innerHTML = "";
      botao.disabled = false;
    }
  }
  senha.addEventListener("input", verificarSenhas);
  confirmarSenha.addEventListener("input", verificarSenhas);
}

// carrega a musica no arquivo do player
function loadMusica(musica, id_usuario) {
  const player = document.getElementById('player');

  fetch("./components/player.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "musica=" + encodeURIComponent(musica) +
      "&id_usuario=" + encodeURIComponent(id_usuario),
  }
  ).then(response => response.text())
    .then(data => {
      player.outerHTML = data;
      logicaPlayer();
    }).catch(err => console.error(err));
}

function botaoPause() {
  const audio = document.getElementById("player__audio");
  const icon = document.getElementById("player__pause-icon");

  if (!audio || !icon) return;

  if (audio.paused) {
    audio.play();
    icon.classList.remove("fa-circle-play");
    icon.classList.add("fa-circle-pause");
  } else {
    audio.pause();
    icon.classList.remove("fa-circle-pause");
    icon.classList.add("fa-circle-play");
  }
}

// carrega a logica do player
function logicaPlayer() {
  const audio = document.getElementById("player__audio");
  const icon = document.getElementById("player__pause-icon");
  const timeStart = document.getElementById("player__time-start");
  const timeFinal = document.getElementById("player__time-final");
  const progress = document.getElementById('player__progress');
  const tooltip = document.getElementById('progressTooltip');

  if (audio && icon && timeStart && timeFinal) {
    function formatTime(seconds) {
      const minutes = Math.floor(seconds / 60)
        .toString()
        .padStart(2, "0");
      const secondsRemaining = Math.floor(seconds % 60)
        .toString()
        .padStart(2, "0");
      return minutes + ":" + secondsRemaining;
    }

    icon.addEventListener("click", () => {
      botaoPause();
    });

    audio.addEventListener("timeupdate", () => {
      const percent = (audio.currentTime / audio.duration) * 100;
      progress.value = percent;
      timeStart.innerHTML = formatTime(audio.currentTime)
      timeFinal.innerHTML = formatTime(audio.duration);
    });

    progress.addEventListener("input", () => {
      const newTime = (progress.value / 100) * audio.duration;
      audio.currentTime = newTime;
    })
    progress.addEventListener("mousemove", (e) => {
      if (!audio.duration) return;

      const rect = progress.getBoundingClientRect();
      const thumbWidth = 14; // aprox. tamanho do thumb em px
      const usableWidth = rect.width - thumbWidth;

      let x = e.clientX - rect.left - thumbWidth / 2;

      if (x < 0) x = 0;
      if (x > usableWidth) x = usableWidth;

      const percent = x / usableWidth;
      const hoverTime = percent * audio.duration;

      if (formatTime(hoverTime) === "-1:-1") tooltip.innerHTML = "00:00";
      else tooltip.innerHTML = formatTime(hoverTime);
      tooltip.style.display = "block";

      // centraliza no mouse
      x -= tooltip.offsetWidth / 2;

      // evita sair da esquerda
      if (x < 0) x = 0;

      // evita sair da direita
      if (x + tooltip.offsetWidth > rect.width) {
        x = rect.width - tooltip.offsetWidth;
      }

      tooltip.style.left = `${x}px`;
    });

    // quando sai do range
    progress.addEventListener("mouseleave", () => {
      tooltip.style.display = "none";
    });

    document.addEventListener("keydown", (e) => {
      // evita acionar se estiver digitando em inputs
      if (e.target.tagName === "INPUT" || e.target.tagName === "TEXTAREA") {
        return;
      }

      if (e.code === "Space") botaoPause();
    });
  }
}

//playlists
let selectedSongId = null;

function openAddToPlaylistModal(songId) {
  selectedSongId = songId;

  document.getElementById("addToPlaylistModal").style.display = "flex";

  loadUserPlaylists(songId);
}

function closeAddToPlaylistModal() {
  document.getElementById("addToPlaylistModal").style.display = "none";
}

function loadUserPlaylists(id_musica) {
  fetch("./get_playlists.php")
    .then(res => res.json())
    .then(playlists => {
      const container = document.getElementById("playlistList");
      container.innerHTML = "";
      playlists.forEach(p => {
        container.innerHTML += `
          <br>
          <a href="#" class="playlist-option" onclick="addSongToPlaylist('${p.id}',${id_musica})">
            ${p.titulo}
          </a>
        `;
      });
      if (container.innerHTML == "") container.innerHTML = "<br>Você não tem playlists";
    }).catch(err => console.error(err));
}

function addSongToPlaylist(id_playlist, id_musica) {
  fetch("./addSongPlaylist.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "id_playlist=" + encodeURIComponent(id_playlist) +
      "&id_musica=" + encodeURIComponent(id_musica),
  })
    .then(res => res.json())
    .then(data => {
      console.log(data)
      alert(data.message);
      closeAddToPlaylistModal();
      if (data.status == "success") {
        reloadLeftBar();
      }
      loadMusicaTela(data.id);
    });
}


// abre o modal de deletar
function openDeleteModal(type, id) {
  const modal = document.getElementById("confirmModal" + id);
  const modalTitle = document.getElementById("modalTitle" + id);
  const modalMessage = document.getElementById("modalMessage" + id);
  const cancelBtn = modal.querySelector(".cancelBtn");
  let dado;

  modal.style.display = "flex";
  if (type == "music") {
    dado = "id_musica";
    modalTitle.innerHTML = "<h2>Excluir música</h2>";
  } else {
    dado = "id_album";
    modalTitle.innerHTML = "<h2>Excluir álbum</h2>";
  }

  fetch("getAlbumMusicModal.php?" + dado + "=" + id)
    .then(res => res.text()
      .then(data => {
        if (type == "music") modalMessage.innerHTML = "<p>Deseja excluir a seguinte música? <br><b>" + data + " ?</b></p>";
        else modalMessage.innerHTML = "<p>Ao excluir este álbum, excluirá também as seguintes músicas, tem certeza?<br> <b>" + data + "</b></p>";
      }))

  cancelBtn.addEventListener("click", function (event) {
    event.preventDefault();
    modal.style.display = "none";
  })
}

function toggleCurtida(botao) {
  const tipo = botao.dataset.tipo;
  const id = botao.dataset.id;

  fetch('./toggleCurtida.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: "tipo=" + encodeURIComponent(tipo) +
      "&id_item=" + encodeURIComponent(id)
  })
    .then(res => res.json())
    .then(data => {
      if (data.curtido) {
        botao.classList.add('ativo');
      } else {
        botao.classList.remove('ativo');
      }
      reloadLeftBar();
    });
}
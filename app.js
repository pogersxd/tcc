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

// submit de formularios
document.addEventListener("submit", function (event) {
  const form = event.target;
  let arquivo;
  switch (form.id) {
    case "add-album-form":
      arquivo = "./addAlbum.php";
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
  }

  event.preventDefault();
  const formData = new FormData(form);

  fetch(arquivo, {
    method: "POST",
    body: formData,
  })
    .then(response => response.json())
    .then(data => {
      window.alert(data.message);

      if (form.id === "add-music-form" && data.status === "success") {
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
    });
});

// clique de links que necessitam de atributos semelhante a href = "xx.php?item=x"
document.addEventListener("click", function (event) {
  const btnDeleteAlbum = event.target.closest(".deleteAlbumBtn");
  const manageSongs = event.target.closest(".manageSongs");
  const btnDeleteSong = event.target.closest(".deleteSongBtn");

  if (btnDeleteAlbum) {
    event.preventDefault();

    const id = btnDeleteAlbum.dataset.id;
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

  if (manageSongs) {
    event.preventDefault();

    const container = document.getElementById('main-menu');

    const id = manageSongs.dataset.id;

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

  if (btnDeleteSong) {
    event.preventDefault();

    const id_musica = btnDeleteSong.dataset.song;
    const id_album = btnDeleteSong.dataset.album;

    fetch("./deleteSong.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded"
      },
      body: "id_musica=" + encodeURIComponent(id_musica) +
        "&id_album=" + encodeURIComponent(id_album)
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
          .then(data => {
            const container = document.getElementById('main-menu');
            container.innerHTML = data;
            if (data.status === "success") reloadLeftBar();
          })
          .catch(err => {
            console.error(err);
          })
      }).catch(err => {
        console.error(err);
      })
  }

});


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
function loadMusica(musica) {
  const player = document.getElementById('player');

  fetch("./components/player.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    },
    body: "musica=" + encodeURIComponent(musica),
  }
  ).then(response => response.text())
    .then(data => {
      player.innerHTML = data;
      logicaPlayer();
    }).catch(err => console.error(err));
}

// carrega a logica do player
function logicaPlayer() {
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